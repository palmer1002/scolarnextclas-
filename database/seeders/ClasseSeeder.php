<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;

class ClasseSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['nom' => '6e A', 'niveau' => 'Collège', 'annee_scolaire' => '2025-2026'],
            ['nom' => '5e B', 'niveau' => 'Collège', 'annee_scolaire' => '2025-2026'],
            ['nom' => '4e A', 'niveau' => 'Collège', 'annee_scolaire' => '2025-2026'],
            ['nom' => '3e C', 'niveau' => 'Collège', 'annee_scolaire' => '2025-2026'],
            ['nom' => '2nde A', 'niveau' => 'Lycée', 'annee_scolaire' => '2025-2026'],
            ['nom' => '1ère C', 'niveau' => 'Lycée', 'annee_scolaire' => '2025-2026'],
            ['nom' => 'Tle D', 'niveau' => 'Lycée', 'annee_scolaire' => '2025-2026'],
        ];

        foreach ($classes as $classe) {
            Classe::firstOrCreate(
                ['nom' => $classe['nom']],
                [
                    'niveau' => $classe['niveau'],
                    'annee_scolaire' => $classe['annee_scolaire']
                ]
            );
        }
    }
}