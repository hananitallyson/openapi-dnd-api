<?php

namespace Database\Seeders;

use App\Models\Arma;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Arma::factory()->create([
            'index' => 'espada-longa',
            'nome' => 'Espada Longa',
            'alcance' => 12,
            'dano' => '1D6',
            'tipo_de_dano' => 'Cortante',
            'propriedade' => 'Leve',
        ]);
    }
}
