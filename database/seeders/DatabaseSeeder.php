<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Modo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Modo::create([
            'nombre' => 'Diario',
            'intervalo' => 'days',
            'cantidad_intervalo' => 1,
        ]);
        Modo::create([
            'nombre' => 'Semanal',
            'intervalo' => 'weeks',
            'cantidad_intervalo' => 1,
        ]);
        Modo::create([
            'nombre' => 'Quincenal',
            'intervalo' => 'weeks',
            'cantidad_intervalo' => 2,
        ]);
        Modo::create([
            'nombre' => 'Mensual',
            'intervalo' => 'months',
            'cantidad_intervalo' => 1,
        ]);
        Modo::create([
            'nombre' => 'Bimensual',
            'intervalo' => 'months',
            'cantidad_intervalo' => 2,
        ]);
        Modo::create([
            'nombre' => 'Trimestral',
            'intervalo' => 'months',
            'cantidad_intervalo' => 3,
        ]);
        Modo::create([
            'nombre' => 'Semestral',
            'intervalo' => 'months',
            'cantidad_intervalo' => 6,
        ]);
        Modo::create([
            'nombre' => 'Anual',
            'intervalo' => 'years',
            'cantidad_intervalo' => 1,
        ]);
    }
}
