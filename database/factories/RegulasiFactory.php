<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Regulasi>
 */
class RegulasiFactory extends Factory
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
            'idJenisRegulasi' => fake()->numberBetween(1, 2),
            'idDireksi' => 1,
            'tanggalSurat' => fake()->dateTimeThisYear(),
            'tujuan' => fake()->word(),
            'perihal' => fake()->words(3, true),
            'keterangan' => fake()->words(5, true),
            'fileName' => 'sertifprogram.pdf',
            'filePath' => 'uploads/sertifprogram.pdf'
        ];
    }
}
