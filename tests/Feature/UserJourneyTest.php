<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Profesi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserJourneyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pengujian E2E (Simulasi): Alur User dari Login, CRUD Profesi, hingga Logout.
     */
    public function test_user_full_journey()
    {
        // 1. Arrange: Siapkan user
        $admin = Admin::factory()->create([
            'username' => 'admin_e2e',
            'password' => bcrypt('password'),
        ]);

        // 2. Act & Assert: Login
        $response = $this->post(route('login'), [
            'username' => 'admin_e2e',
            'password' => 'password',
        ]);
        $response->assertJson(['status' => true]);
        $this->assertAuthenticatedAs($admin);

        // 3. Act & Assert: Create Profesi (Sebagai User yang sudah login)
        $profesiData = [
            'nama_profesi' => 'DevOps Engineer',
            'kategori' => 'Infokom',
        ];
        $response = $this->actingAs($admin)->post(route('profesi.store'), $profesiData);
        $response->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('profesi', $profesiData);

        // 4. Act & Assert: Lihat Data di Dashboard (Index)
        $response = $this->actingAs($admin)->get(route('profesi.index'));
        $response->assertStatus(200);
        $response->assertSee('DevOps Engineer');

        // 5. Act & Assert: Logout
        $response = $this->actingAs($admin)->post(route('logout'));
        $response->assertJson(['status' => true]);
        $this->assertGuest();
    }
}
