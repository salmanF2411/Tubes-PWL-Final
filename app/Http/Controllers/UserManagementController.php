<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $visibleStoreIds = $this->visibleStoreIds();

        $users = User::query()
            ->with(['store', 'roles'])
            ->when(! $this->currentUser()->canAccessAllStores(), fn ($query) => $query->whereIn('store_id', $visibleStoreIds))
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q');

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('role'), fn ($query) => $query->role($request->string('role')->toString()))
            ->orderBy('name')
            ->get();

        $stores = Store::query()
            ->whereIn('id', $visibleStoreIds)
            ->orderBy('name')
            ->get();

        $roles = Role::query()
            ->whereIn('name', ['owner', 'store_manager', 'supervisor', 'cashier', 'warehouse_staff'])
            ->orderBy('name')
            ->get();

        $editingUser = $request->filled('edit')
            ? User::query()->with('roles')->findOrFail($request->integer('edit'))
            : null;

        if ($editingUser && ! $this->currentUser()->canAccessAllStores() && ! in_array($editingUser->store_id, $visibleStoreIds, true)) {
            abort(403);
        }

        return view('pages.kelola-user', compact('users', 'stores', 'roles', 'editingUser'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateUser($request);
        $storeId = $this->resolveWritableStoreId($validated['store_id'] ?? null, $validated['role']);

        $user = User::create([
            'store_id' => $storeId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'status' => $validated['status'],
        ]);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('kelola-user')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        if (! $this->currentUser()->canAccessAllStores() && ! in_array($user->store_id, $this->visibleStoreIds(), true)) {
            abort(403);
        }

        $validated = $this->validateUser($request, $user->id);
        $storeId = $this->resolveWritableStoreId($validated['store_id'] ?? null, $validated['role']);

        $payload = [
            'store_id' => $storeId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'status' => $validated['status'],
        ];

        if (! empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        $user->update($payload);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('kelola-user')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_if($user->is($this->currentUser()), 403);

        if (! $this->currentUser()->canAccessAllStores() && ! in_array($user->store_id, $this->visibleStoreIds(), true)) {
            abort(403);
        }

        $user->update(['status' => 'inactive']);

        return redirect()->route('kelola-user')->with('success', 'User berhasil dinonaktifkan.');
    }

    private function validateUser(Request $request, ?int $ignoreId = null): array
    {
        $allowedRoles = $this->currentUser()->canAccessAllStores()
            ? ['owner', 'store_manager', 'supervisor', 'cashier', 'warehouse_staff']
            : ['supervisor', 'cashier', 'warehouse_staff'];

        return $request->validate([
            'store_id' => ['nullable', 'exists:stores,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($ignoreId)],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::in($allowedRoles)],
            'password' => [$ignoreId ? 'nullable' : 'required', 'string', 'min:6'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }

    private function resolveWritableStoreId(?int $storeId, string $role): ?int
    {
        if ($role === 'owner') {
            return null;
        }

        if (! $this->currentUser()->canAccessAllStores()) {
            return $this->currentUser()->store_id;
        }

        if (! $storeId) {
            throw ValidationException::withMessages([
                'store_id' => 'Cabang wajib dipilih untuk role selain owner.',
            ]);
        }

        return $storeId ? $this->ensureVisibleStore($storeId) : null;
    }
}