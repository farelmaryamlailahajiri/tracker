<?php

namespace Tests\Feature;

use App\Models\Profesi;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfesiCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsAdmin()
    {
        $admin = Admin::factory()->create();
        return $this->actingAs($admin);
    }

    public function test_admin_bisa_melihat_daftar_profesi()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('profesi.index'));

        $response->assertStatus(200);
        $response->assertSee('Profesi');
    }

    public function test_admin_bisa_menambah_profesi()
    {
        $this->actingAsAdmin();


        $payload = [
            'nama_profesi' => 'Programmer',
            'kategori' => 'Infokom',
        ];

        $response = $this->post(route('profesi.store'), $payload);

        $response->assertJson([
            'status' => 'success',
        ]);

        $this->assertDatabaseHas('profesi', [
            'nama_profesi' => 'Programmer',
            'kategori' => 'Infokom',
        ]);
    }

    public function test_admin_bisa_update_profesi()
    {
        $this->actingAsAdmin();


        $profesi = Profesi::factory()->create([
            'nama_profesi' => 'Programmer',
            'kategori' => 'Infokom',
        ]);

        $payloadBaru = [
            'nama_profesi' => 'Software Engineer',
            'kategori' => 'Infokom',
        ];

        $response = $this->put(route('profesi.update', $profesi), $payloadBaru);

        $response->assertJson([
            'status' => 'success',
        ]);

        $this->assertDatabaseHas('profesi', [
            'id'   => $profesi->id,
            'nama_profesi' => 'Software Engineer',
            'kategori' => 'Infokom',
        ]);
    }

    public function test_admin_bisa_menghapus_profesi()
    {
        $this->actingAsAdmin();

        $profesi = Profesi::factory()->create([
            'nama_profesi' => 'Programmer',
            'kategori' => 'Infokom',
        ]);

        $response = $this->delete(route('profesi.destroy', $profesi));

        $response->assertJson([
            'status' => 'success',
        ]);

        $this->assertDatabaseMissing('profesi', [
            'id' => $profesi->id,
        ]);
    }
}
