<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_berhasil_dengan_credential_yang_benar()
    {
        // Arrange: buat admin di database test
        $admin = Admin::factory()->create([
            'username' => 'tester',
            'password' => bcrypt('password123'),
        ]);

        // Act: kirim POST ke route login
        $response = $this->post(route('login'), [
            'username' => $admin->username,
            'password' => 'password123',
        ]);

        // Assert: response JSON sukses dan ada redirect
        $response->assertJson([
            'status' => true,
            'redirect' => route('dashboard'),
        ]);
    }

    public function test_login_gagal_dengan_password_salah()
    {
        $admin = Admin::factory()->create([
            'password' => bcrypt('password123'),
        ]);

       
        $response = $this->post(route('login'), [
            'username' => $admin->username,
            'password' => 'password_yang_salah',
        ]);

        $response->assertJson([
            'status' => false,
        ]);
    }

    public function test_logout_mengeluarkan_user_dan_redirect_ke_landing()
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin)
                         ->post(route('logout'));

        $response->assertJson([
            'status' => true,
            'redirect' => url('/'),
        ]);
    }
}
