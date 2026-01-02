<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfesiApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pengujian API: Memastikan endpoint mengembalikan JSON yang valid.
     */
    public function test_api_create_profesi_returns_json()
    {
        // Arrange
        $admin = Admin::factory()->create();
        $payload = [
            'nama_profesi' => 'Backend Developer',
            'kategori' => 'Infokom',
        ];

        // Act
        $response = $this->actingAs($admin)->postJson(route('profesi.store'), $payload);

        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Profesi berhasil ditambahkan.'
                 ]);
    }

    public function test_api_get_profesi_detail_returns_json()
    {
        // Arrange
        $admin = Admin::factory()->create();
        $profesi = \App\Models\Profesi::factory()->create([
            'nama_profesi' => 'Data Scientist',
            'kategori' => 'Infokom'
        ]);

        // Act
        $response = $this->actingAs($admin)->getJson(route('profesi.edit', $profesi->id));

        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'nama_profesi' => 'Data Scientist',
                     'kategori' => 'Infokom'
                 ]);
    }
}
