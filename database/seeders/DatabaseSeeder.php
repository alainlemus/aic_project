<?php

namespace Database\Seeders;

use App\Models\Elemento;
use App\Models\Unidad;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(10)->create();

        $this->call(MunicipiosSeeder::class);

        $this->call(TiposOrdenesSeeder::class);

        Unidad::factory(10)->create();

        Elemento::factory(10)->create();

        User::factory()->create([
            'name' => 'Alain Lemus Muñoz',
            'email' => 'alainttlm@gmail.com',
            'password' => bcrypt('timoboll'),
        ]);
    }
}
