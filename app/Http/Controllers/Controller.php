<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function currentUser(): User
    {
        return Auth::user();
    }

    protected function visibleStoreIds(): array
    {
        return $this->currentUser()->visibleStoreIds();
    }

    protected function ensureVisibleStore(int $storeId): int
    {
        abort_unless(in_array($storeId, $this->visibleStoreIds(), true), 403);

        return $storeId;
    }
}