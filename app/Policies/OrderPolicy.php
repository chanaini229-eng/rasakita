<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * ATURAN PELANGGAN 2 & 3:
     * Pelanggan hanya bisa melihat laporan transaksi diri sendiri.
     * Tidak bisa melihat laporan transaksi milik pelanggan lain.
     */
    public function view(User $user, Order $order): bool
    {
        return $order->user_id === $user->id;
    }

    /**
     * ATURAN PELANGGAN 4:
     * Pelanggan bisa membuat pesanan makanan.
     */
    public function create(User $user): bool
    {
        return true;
    }
}
