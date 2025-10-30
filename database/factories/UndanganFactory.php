<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Undangan>
 */
class UndanganFactory extends Factory
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
            'judul' => fake()->words(5, true),
            'tempatKegiatan' => fake()->word(),
            'waktuKegiatan' => fake()->dateTimeBetween('-6 months', '+6 months'),
            'isi' => '<div><strong>' . fake()->sentence(3) . '</strong></div>'
                . '<div><ul><li>' . fake()->sentence(4) . '</li><li>' . fake()->sentence(4) . '</li></ul></div>'
                . '<div><em>' . fake()->sentence(6) . '</em></div>',
            'fileName' => 'sertifprogram.pdf',
            'filePath' => 'uploads/sertifprogram.pdf'
        ];
    }
}
