<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PeminjamanAsset>
 */
class PeminjamanAssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_peminjaman_asset' => fake()->uuid(),
            'id_karyawan' => fake()->uuid(),
            'nm_karyawan' => fake()->name($gender = null),
            'tgl_awal_peminjaman' =>fake()->date(),
            'tgl_pengembalian' => fake()->date(),
            'keterangan' => fake()->paragraph(),
            'sts' => 0
        ];
    }
}
