<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Customer::factory(10)->create();

        for ($i = 0; $i < 25; $i++) {
            DB::table('customers')->insert([
                'foto' => Str::random(10),
                'nama' => str::random(10),
                'email' => Str::random(10) . '@example.com',
                'password' => Hash::make('123'),
                'nomor_hp' => str::random(10),
                'alamat' => str::random(10),
                'created_at' => date('Y-m-d'),
                'updated_at' => null,
            ]);
        }
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
