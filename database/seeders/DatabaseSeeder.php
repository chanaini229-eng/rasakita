<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database hanya untuk akun role Pelanggan
     */
    public function run(): void
    {
        // 0. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@rasakita.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081122334455',
                'address' => 'Kantor Pusat Restoran RasaKita',
            ]
        );

        // 1. Akun Kasir
        User::updateOrCreate(
            ['email' => 'kasir@rasakita.com'],
            [
                'name' => 'Sinta (Kasir)',
                'password' => Hash::make('password'),
                'role' => 'kasir',
                'phone' => '081355667788',
                'address' => 'Kasir Utama Restoran RasaKita',
            ]
        );
        // 1. Akun Pelanggan 1 (Budi)
        $budi = User::updateOrCreate(
            ['email' => 'pelanggan@rasakita.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'phone' => '081234567890',
                'address' => 'Jl. Mawar Indah Blok B3 No. 14, Jakarta',
            ]
        );

        // 2. Akun Pelanggan 2 (Siti) - Untuk verifikasi aturan isolasi transaksi
        $siti = User::updateOrCreate(
            ['email' => 'siti@rasakita.com'],
            [
                'name' => 'Siti Rahma',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'phone' => '089876543210',
                'address' => 'Jl. Kebon Jeruk No. 22, Jakarta Barat',
            ]
        );

        // 3. Categories
        $categories = [
            ['name' => 'Ayam', 'slug' => 'ayam', 'icon' => 'fa-drumstick-bite'],
            ['name' => 'Nasi', 'slug' => 'nasi', 'icon' => 'fa-bowl-rice'],
            ['name' => 'Mie', 'slug' => 'mie', 'icon' => 'fa-bowl-food'],
            ['name' => 'Minuman', 'slug' => 'minuman', 'icon' => 'fa-mug-hot'],
            ['name' => 'Cemilan', 'slug' => 'cemilan', 'icon' => 'fa-cookie-bite'],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
            $catModels[$cat['slug']] = Category::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        // 4. Menus (Sesuai dengan screenshot)
        $menus = [
            [
                'category_id' => $catModels['ayam']->id,
                'name' => 'Ayam Geprek Original',
                'slug' => 'ayam-geprek-original',
                'description' => 'Ayam goreng renyah digeprek dengan sambal bawang pedas gurih khas nusantara, disajikan dengan lalapan segar.',
                'price' => 15000,
                'image' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.8,
                'reviews_count' => 120,
                'is_popular' => true,
                'is_available' => true,
            ],
            [
                'category_id' => $catModels['nasi']->id,
                'name' => 'Nasi Goreng Spesial',
                'slug' => 'nasi-goreng-spesial',
                'description' => 'Nasi goreng racikan rempah istimewa dengan suwiran ayam, bakso, telur mata sapi, dan kerupuk renyah.',
                'price' => 18000,
                'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.7,
                'reviews_count' => 98,
                'is_popular' => true,
                'is_available' => true,
            ],
            [
                'category_id' => $catModels['mie']->id,
                'name' => 'Mie Ayam Bakso',
                'slug' => 'mie-ayam-bakso',
                'description' => 'Mie kenyal gurih dengan topping ayam manis gurih, sayuran sawi hijau, dan bakso sapi kenyal berdaging.',
                'price' => 16000,
                'image' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.7,
                'reviews_count' => 85,
                'is_popular' => true,
                'is_available' => true,
            ],
            [
                'category_id' => $catModels['minuman']->id,
                'name' => 'Es Teh Manis',
                'slug' => 'es-teh-manis',
                'description' => 'Seduhan teh melati pilihan yang harum disajikan dingin dengan manis gula murni yang menyegarkan.',
                'price' => 5000,
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.6,
                'reviews_count' => 60,
                'is_popular' => true,
                'is_available' => true,
            ],
            [
                'category_id' => $catModels['cemilan']->id,
                'name' => 'Pisang Goreng',
                'slug' => 'pisang-goreng',
                'description' => 'Pisang kepok manis berbalut tepung renyah keemasan, ditaburi keju parut dan lelehan susu kental manis.',
                'price' => 8000,
                'image' => 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.5,
                'reviews_count' => 50,
                'is_popular' => true,
                'is_available' => true,
            ],
            [
                'category_id' => $catModels['ayam']->id,
                'name' => 'Ayam Bakar Madu',
                'slug' => 'ayam-bakar-madu',
                'description' => 'Ayam bakar dengan bumbu madu manis legit meresap hingga ke tulang dengan aroma bakaran khas arang.',
                'price' => 17000,
                'image' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.9,
                'reviews_count' => 140,
                'is_popular' => false,
                'is_available' => true,
            ],
            [
                'category_id' => $catModels['nasi']->id,
                'name' => 'Nasi Uduk Komplit',
                'slug' => 'nasi-uduk-komplit',
                'description' => 'Nasi uduk santan gurih harum daun pandan, lengkap dengan orek tempe, bihun, telur dadar iris, dan sambal terasi.',
                'price' => 15000,
                'image' => 'https://images.unsplash.com/photo-1610057099443-fde8c4d50f91?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.7,
                'reviews_count' => 76,
                'is_popular' => false,
                'is_available' => true,
            ],
            [
                'category_id' => $catModels['mie']->id,
                'name' => 'Mie Goreng Seafood',
                'slug' => 'mie-goreng-seafood',
                'description' => 'Mie goreng oriental dengan potongan cumi, udang segar, bakso ikan, dan sawi manis renyah.',
                'price' => 22000,
                'image' => 'https://images.unsplash.com/photo-1612927601601-6638404737ce?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.8,
                'reviews_count' => 110,
                'is_popular' => false,
                'is_available' => true,
            ],
            [
                'category_id' => $catModels['minuman']->id,
                'name' => 'Jus Jeruk Segar',
                'slug' => 'jus-jeruk-segar',
                'description' => 'Perasan jeruk pontianak asli kaya vitamin C yang dingin dan menyegarkan dahaga seketika.',
                'price' => 7000,
                'image' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.7,
                'reviews_count' => 65,
                'is_popular' => false,
                'is_available' => true,
            ],
            [
                'category_id' => $catModels['cemilan']->id,
                'name' => 'Cireng Crispy Bumbu Rujak',
                'slug' => 'cireng-crispy-bumbu-rujak',
                'description' => 'Cireng aci goreng garing di luar kenyal di dalam, dicocol dengan sambal rujak gula merah pedas manis mantap.',
                'price' => 10000,
                'image' => 'https://images.unsplash.com/photo-1541592106381-b31e9677c0e5?auto=format&fit=crop&w=600&q=80',
                'rating' => 4.6,
                'reviews_count' => 42,
                'is_popular' => false,
                'is_available' => true,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(['slug' => $menu['slug']], $menu);
        }

        // 5. Riwayat transaksi sampel milik Budi
        $order1 = Order::updateOrCreate(
            ['order_number' => 'RSK-20261120-0001'],
            [
                'user_id' => $budi->id,
                'customer_name' => $budi->name,
                'customer_phone' => $budi->phone,
                'customer_address' => $budi->address,
                'notes' => 'Tolong sambalnya dipisah ya.',
                'subtotal' => 35000,
                'delivery_fee' => 5000,
                'total_price' => 40000,
                'payment_method' => 'qris',
                'payment_status' => 'paid',
                'order_status' => 'selesai',
                'created_at' => now()->subDays(4),
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $order1->id, 'menu_name' => 'Ayam Geprek Original'],
            [
                'price' => 15000,
                'quantity' => 2,
                'subtotal' => 30000,
                'notes' => 'Level 3, sambal pisah',
            ]
        );
        OrderItem::firstOrCreate(
            ['order_id' => $order1->id, 'menu_name' => 'Es Teh Manis'],
            [
                'price' => 5000,
                'quantity' => 1,
                'subtotal' => 5000,
                'notes' => 'Sedikit es',
            ]
        );

        // 6. Riwayat transaksi sampel milik Siti (Untuk menguji aturan bahwa Budi TIDAK BISA melihat transaksi Siti)
        $orderSiti = Order::updateOrCreate(
            ['order_number' => 'RSK-20261122-0002'],
            [
                'user_id' => $siti->id,
                'customer_name' => $siti->name,
                'customer_phone' => $siti->phone,
                'customer_address' => $siti->address,
                'notes' => 'Pesanan privat Siti',
                'subtotal' => 18000,
                'delivery_fee' => 5000,
                'total_price' => 23000,
                'payment_method' => 'transfer_bank',
                'payment_status' => 'paid',
                'order_status' => 'selesai',
                'created_at' => now()->subDays(2),
            ]
        );

        OrderItem::firstOrCreate(
            ['order_id' => $orderSiti->id, 'menu_name' => 'Nasi Goreng Spesial'],
            [
                'price' => 18000,
                'quantity' => 1,
                'subtotal' => 18000,
                'notes' => 'Pedas sedang',
            ]
        );
    }
}
