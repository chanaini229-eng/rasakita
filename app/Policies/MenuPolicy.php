<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;

class MenuPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Menu $menu): bool
    {
        return true;
    }

    /**
     * ATURAN PELANGGAN 1:
     * Pelanggan TIDAK BISA tambah menu.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * ATURAN PELANGGAN 1:
     * Pelanggan TIDAK BISA edit menu.
     */
    public function update(User $user, Menu $menu): bool
    {
        return false;
    }

    /**
     * ATURAN PELANGGAN 1:
     * Pelanggan TIDAK BISA hapus menu.
     */
    public function delete(User $user, Menu $menu): bool
    {
        return false;
    }
}
