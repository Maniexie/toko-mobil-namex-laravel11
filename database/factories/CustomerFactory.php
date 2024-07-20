<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected static ?string $password;
    public function definition(): array
    {
        $faker = $this->withFaker();
        return [
            'foto' => $faker->foto(),
            'nama' => $faker->nama(),
            'email' => $faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('123'),
            'nomor_hp' => $faker->nomor_hp(),
            'alamat' => $faker->alamat(),
            'created_at' => $faker->created_at(),
            'updated_at' => null,
        ];
    }

    public function withFaker()
    {
        return \Faker\Factory::create('id_ID');
    }
}
