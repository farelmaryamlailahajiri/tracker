<?php

namespace Database\Factories;

use App\Models\Profesi;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfesiFactory extends Factory
{
    protected $model = Profesi::class;

    public function definition(): array
    {
        return [
            'nama_profesi' => $this->faker->jobTitle,
            'kategori' => $this->faker->randomElement(['IT', 'Kesehatan', 'Pendidikan', 'Lainnya']),
            'nama' => $this->faker->jobTitle, // untuk kebutuhan test yang insert ke kolom nama
        ];
    }
}
