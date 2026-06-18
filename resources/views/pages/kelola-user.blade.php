@extends('layouts.layoutAdminPanel')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-users text-blue-600 mr-2"></i>Kelola User
    </h1>
    <p class="text-slate-500 text-sm mt-1">Manajemen pengguna sistem mini market</p>
</div>

<div class="mb-6 flex items-center justify-between gap-4">
    <form method="GET" action="{{ route('kelola-user') }}" class="flex-1 flex gap-3">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari user..."
            class="w-full max-w-md px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
        <select name="role" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
            <option value="">Semua Role</option>
            @foreach($roles as $role)
                @continue(!auth()->user()->canAccessAllStores() && in_array($role->name, ['owner', 'store_manager'], true))
                <option value="{{ $role->name }}" @selected(request('role') === $role->name)>
                    {{ [
                        'owner' => 'Owner',
                        'store_manager' => 'Manajer Toko',
                        'supervisor' => 'Supervisor',
                        'cashier' => 'Kasir',
                        'warehouse_staff' => 'Pegawai Gudang',
                    ][$role->name] ?? $role->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
            <i class="fa-solid fa-search"></i>
            Filter
        </button>
    </form>
</div>

@canany(['create user', 'edit user'])
<div id="form-user" class="bg-white rounded-lg border border-slate-200 p-6 mb-8">
    <h2 class="font-bold text-slate-900 mb-4">
        {{ $editingUser ? 'Edit User' : 'Tambah User' }}
    </h2>

    <form
        method="POST"
        action="{{ $editingUser ? route('kelola-user.update', $editingUser) : route('kelola-user.store') }}"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @csrf
        @if($editingUser)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
            <input name="name" value="{{ old('name', $editingUser->name ?? '') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $editingUser->email ?? '') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">No. HP</label>
            <input name="phone" value="{{ old('phone', $editingUser->phone ?? '') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
            <input type="password" name="password" placeholder="{{ $editingUser ? 'Kosongkan jika tidak diganti' : 'Minimal 6 karakter' }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" @required(!$editingUser)>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
            @php($selectedRole = old('role', $editingUser?->getRoleNames()->first() ?? 'cashier'))
            <select name="role" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                @foreach($roles as $role)
                    @continue(!auth()->user()->canAccessAllStores() && in_array($role->name, ['owner', 'store_manager'], true))
                    <option value="{{ $role->name }}" @selected($selectedRole === $role->name)>
                        {{ [
                            'owner' => 'Owner',
                            'store_manager' => 'Manajer Toko',
                            'supervisor' => 'Supervisor',
                            'cashier' => 'Kasir',
                            'warehouse_staff' => 'Pegawai Gudang',
                        ][$role->name] ?? $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Cabang</label>
            @if(auth()->user()->canAccessAllStores())
                <select name="store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
                    <option value="">Pusat / Owner</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" @selected(old('store_id', $editingUser->store_id ?? '') == $store->id)>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
            @else
                <input type="hidden" name="store_id" value="{{ auth()->user()->store_id }}">
                <div class="px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-600">
                    {{ auth()->user()->store->name ?? '-' }}
                </div>
            @endif
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                <option value="active" @selected(old('status', $editingUser->status ?? 'active') === 'active')>Aktif</option>
                <option value="inactive" @selected(old('status', $editingUser->status ?? 'active') === 'inactive')>Nonaktif</option>
            </select>
        </div>
        <div class="flex items-end gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                <i class="fa-solid fa-save"></i>
                Simpan
            </button>
            @if($editingUser)
                <a href="{{ route('kelola-user') }}" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200">
                    <i class="fa-solid fa-times"></i>
                    Batal
                </a>
            @endif
        </div>
    </form>
</div>
@endcanany

<div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="font-bold text-slate-900">Daftar User</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Nama</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Email</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Role</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Cabang</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->role_label }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->store->name ?? 'Pusat' }}</td>
                        <td class="px-6 py-4">
                            <x-badge :type="$user->status_badge_type">{{ $user->status_label }}</x-badge>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @can('edit user')
                                    <a href="{{ route('kelola-user', ['edit' => $user->id]) }}#form-user" class="text-blue-600 hover:text-blue-700" title="Edit">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete user')
                                    @if(!$user->is(auth()->user()))
                                        <form method="POST" action="{{ route('kelola-user.destroy', $user) }}" onsubmit="return confirm('Nonaktifkan user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">Data user belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection