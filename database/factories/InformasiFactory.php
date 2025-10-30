<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Informasi>
 */
class InformasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'index' => fake()->unique()->randomNumber(3),
            'tahun' => 2025,
            'idJenisInformasi' => fake()->numberBetween(1, 2),
            'tanggalSurat' => fake()->dateTimeThisYear(),
            'judul' => fake()->word(),
            'fileName' => 'sertifprogram.pdf',
            'filePath' => 'uploads/sertifprogram.pdf'
        ];
    }
}
