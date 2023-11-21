<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasterKaryawan>
 */
class MasterKaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_karyawan' => fake()->uuid(),
            'nm_karyawan' => fake()->name($gender = null),
            'no_hp' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date(),
            'gender' => 'pria',
            'religion' => 'Islam',
            'tgl_mulai_kerja' => fake()->date(),
            'tgl_resign' => fake()->date(),
            'pendidikan_terakhir' => '',
            'no_kartu_keluarga' => fake()->randomNumber(5, true),
            'no_bpjs' => fake()->randomNumber(5, true),
            'no_npwp' => fake()->randomNumber(6, true),
            'alamat' => fake()->paragraph(),
            'bank_name' => 'BCA',
            'bank_account_number' => fake()->randomNumber(5, true),
            'bank_account_name' => fake()->name($gender = null),
            'bank_address' => fake()->paragraph(),
            'swift_code' => fake()->uuid()
        ];
    }
}
