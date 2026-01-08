<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer une classe par niveau (6ème → Tle)
        $niveaux = [
            '6ème', '5ème', '4ème', '3ème',
            '2nde', '1ère', 'Tle',
        ];

        foreach ($niveaux as $niveau) {
            Classe::firstOrCreate(
                ['niveau' => $niveau],
                [
                    'nom' => $niveau, // nom égal au niveau pour simplicité
                    'annee_scolaire' => '2025-2026',
                ]
            );
        }
    }
}
