<?php

namespace Database\Factories;

use App\Models\Daerah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Daerah>
 */
class DaerahFactory extends Factory
{
    protected $model = Daerah::class;

    public function definition(): array
    {
        return [
            'nama_daerah' => 'Kecamatan ' . fake()->unique()->word(),
            'tingkat'     => 'Kecamatan',
        ];
    }
}
