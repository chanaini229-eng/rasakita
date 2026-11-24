<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelangganPagesTest extends TestCase
{
    use RefreshDatabase;

    protected User $pelanggan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->pelanggan = User::where('email', 'pelanggan@rasakita.com')->first();
    }

    public function test_dashboard_pelanggan_loads_successfully(): void
    {
        $response = $this->actingAs($this->pelanggan)->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('RasaKita');
        $response->assertSee('Menu Populer');
        $response->assertSee('Ayam Geprek Original');
    }

    public function test_daftar_menu_loads_without_management_buttons(): void
    {
        $response = $this->actingAs($this->pelanggan)->get(route('menu.index'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Menu Pilihan');
        $response->assertSee('Tambah Pesanan');
        $response->assertDontSee('Kelola Menu');
        $response->assertDontSee('Hapus Menu');
    }

    public function test_tentang_kami_loads_successfully(): void
    {
        $response = $this->actingAs($this->pelanggan)->get(route('about'));
        $response->assertStatus(200);
        $response->assertSee('Cerita RasaKita');
    }

    public function test_kontak_loads_successfully(): void
    {
        $response = $this->actingAs($this->pelanggan)->get(route('contact'));
        $response->assertStatus(200);
        $response->assertSee('Hubungi Kami');
    }

    public function test_keranjang_loads_successfully(): void
    {
        $response = $this->actingAs($this->pelanggan)->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertSee('Keranjang Pesanan');
    }

    public function test_riwayat_transaksi_shows_only_own_orders(): void
    {
        $response = $this->actingAs($this->pelanggan)->get(route('order.history'));
        $response->assertStatus(200);
        $response->assertSee('RSK-20261120-0001'); // Budi's order
        $response->assertDontSee('RSK-20261122-0002'); // Siti's order must NOT be visible!
    }
}
