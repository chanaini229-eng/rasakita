<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelangganRoleTest extends TestCase
{
    use RefreshDatabase;

    protected User $pelangganBudi;
    protected User $pelangganSiti;
    protected Menu $menuAyam;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->pelangganBudi = User::where('email', 'pelanggan@rasakita.com')->first();
        $this->pelangganSiti = User::where('email', 'siti@rasakita.com')->first();
        $this->menuAyam = Menu::first();
    }

    /**
     * ATURAN 1: Pelanggan TIDAK BISA tambah menu (403 Forbidden).
     */
    public function test_pelanggan_cannot_create_menu(): void
    {
        $response = $this->actingAs($this->pelangganBudi)->post(route('menu.manage.store'), [
            'category_id' => $this->menuAyam->category_id,
            'name' => 'Menu Ilegal Pelanggan',
            'price' => 20000,
        ]);

        $response->assertStatus(403);
    }

    /**
     * ATURAN 1: Pelanggan TIDAK BISA edit menu (403 Forbidden).
     */
    public function test_pelanggan_cannot_update_menu(): void
    {
        $response = $this->actingAs($this->pelangganBudi)->put(route('menu.manage.update', $this->menuAyam->id), [
            'name' => 'Menu Diubah Pelanggan',
            'price' => 99999,
        ]);

        $response->assertStatus(403);
    }

    /**
     * ATURAN 1: Pelanggan TIDAK BISA hapus menu (403 Forbidden).
     */
    public function test_pelanggan_cannot_delete_menu(): void
    {
        $response = $this->actingAs($this->pelangganBudi)->delete(route('menu.manage.destroy', $this->menuAyam->id));

        $response->assertStatus(403);
    }

    /**
     * ATURAN 2: Pelanggan BISA melihat laporan transaksi diri sendiri.
     */
    public function test_pelanggan_can_view_own_transaction_history(): void
    {
        $response = $this->actingAs($this->pelangganBudi)->get(route('order.history'));

        $response->assertStatus(200);
        $response->assertSee('Riwayat Transaksi');
        $response->assertSee($this->pelangganBudi->name);
    }

    /**
     * ATURAN 3: Pelanggan TIDAK BISA melihat laporan transaksi / struk orang lain.
     */
    public function test_pelanggan_cannot_view_other_customer_receipt(): void
    {
        // Pesanan milik pelanggan Siti
        $sitiOrder = Order::where('user_id', $this->pelangganSiti->id)->first();
        $this->assertNotNull($sitiOrder);

        // Pelanggan Budi mencoba membuka struk milik Siti -> Ditolak 403
        $response = $this->actingAs($this->pelangganBudi)->get(route('order.receipt', $sitiOrder->id));

        $response->assertStatus(403);
    }

    /**
     * ATURAN 4 & 5: Pelanggan BISA memesan makanan dan otomatis MENAMPILKAN STRUK diri sendiri.
     */
    public function test_pelanggan_can_order_food_and_views_receipt(): void
    {
        // 1. Tambah menu ke keranjang
        $this->actingAs($this->pelangganBudi)->post(route('cart.add'), [
            'menu_id' => $this->menuAyam->id,
            'quantity' => 2,
        ]);

        // 2. Lakukan checkout pesanan
        $response = $this->actingAs($this->pelangganBudi)->post(route('order.checkout'), [
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081234567890',
            'customer_address' => 'Jl. Pengujian No. 12',
            'payment_method' => 'qris',
            'notes' => 'Tanpa cabai',
        ]);

        // Redirect otomatis ke struk transaksi diri sendiri
        $response->assertRedirect();
        $redirectUrl = $response->headers->get('Location');
        $this->assertStringContainsString('/struk/', $redirectUrl);

        // Tampilkan halaman struk
        $receiptResponse = $this->actingAs($this->pelangganBudi)->get($redirectUrl);
        $receiptResponse->assertStatus(200);
        $receiptResponse->assertSee('Struk Pemesanan');
        $receiptResponse->assertSee('Budi Santoso');
        $receiptResponse->assertSee($this->menuAyam->name);
    }
}
