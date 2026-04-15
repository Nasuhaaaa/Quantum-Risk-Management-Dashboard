<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Seeders are called in dependency order
     */
    public function run(): void
    {
        // Tables with no dependencies
        $this->call([
            JenisPenggunaSeeder::class,
            SektorSeeder::class,
            KategoriRisikoSeeder::class,
            KategoriPuncaRisikoSeeder::class,
        ]);

        // Tables that depend on above
        $this->call([
            AgensiSeeder::class,
            SubKategoriRisikoSeeder::class,
            InventoriSeeder::class,
        ]);

        // Tables that depend on previous
        $this->call([
            SbomSeeder::class,
            UserSeeder::class,
            RisikoSeeder::class,
            PuncaRisikoSeeder::class,
        ]);

        // Tables that depend on multiple tables
        $this->call([
            CbomSeeder::class,
            RegisterRiskSeeder::class,
        ]);

        $this->command->info('All seeders executed successfully!');
    }
}
