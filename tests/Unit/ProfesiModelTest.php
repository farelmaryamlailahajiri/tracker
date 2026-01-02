<?php

namespace Tests\Unit;

use App\Models\Profesi;
use Tests\TestCase; // Menggunakan Tests\TestCase agar bisa akses database/factory jika perlu, atau PHPUnit\Framework\TestCase untuk pure unit
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfesiModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pengujian Unit: Test Scope Query pada Model.
     */
    public function test_scope_by_kategori_filters_correctly()
    {
        // Arrange
        Profesi::factory()->create(['nama_profesi' => 'A', 'kategori' => 'Infokom']);
        Profesi::factory()->create(['nama_profesi' => 'B', 'kategori' => 'Infokom']);
        Profesi::factory()->create(['nama_profesi' => 'C', 'kategori' => 'Kesehatan']);

        // Act
        $infokom = Profesi::byKategori('Infokom')->get();
        $kesehatan = Profesi::byKategori('Kesehatan')->get();

        // Assert
        $this->assertCount(2, $infokom);
        $this->assertCount(1, $kesehatan);
        $this->assertEquals('A', $infokom->first()->nama_profesi);
    }

    /**
     * Pengujian Unit: Test Accessor Attribute.
     */
    public function test_get_nama_attribute_returns_nama_profesi()
    {
        // Arrange
        $profesi = new Profesi([
            'nama_profesi' => 'Network Engineer',
            'kategori' => 'Infokom'
        ]);

        // Act & Assert
        $this->assertEquals('Network Engineer', $profesi->nama);
    }
}
