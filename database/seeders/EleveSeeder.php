<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\Classe;

class EleveSeeder extends Seeder
{
    public function run(): void
    {
        // Créer quelques classes
        $classe4A = Classe::firstOrCreate(['nom' => '4e A']);
        $classeTleD = Classe::firstOrCreate(['nom' => 'Tle D']);
        $classe3C = Classe::firstOrCreate(['nom' => '3e C']);

        // Créer des élèves
        $eleves = [
            [
                'matricule' => 'SNC2024001',
                'nom' => 'Diallo',
                'prenom' => 'Amina',
                'classe_id' => $classe4A->id,
                'genre' => 'Féminin',
                'date_inscription' => '2024-09-01',
                'parent_nom' => 'Papa Diallo',
                'parent_relation' => 'Père',
                'parent_telephone' => '+228 90 90 90 90'
            ],
            [
                'matricule' => 'SNC2024002',
                'nom' => 'Kokoroko',
                'prenom' => 'Ray',
                'classe_id' => $classeTleD->id,
                'genre' => 'Masculin',
                'date_inscription' => '2024-09-05',
                'parent_nom' => 'Maman Kokoroko',
                'parent_relation' => 'Mère',
                'parent_telephone' => '+228 90 90 90 90'
            ],
            [
                'matricule' => 'SNC2024003',
                'nom' => 'Klanlenou',
                'prenom' => 'Arnaud',
                'classe_id' => $classe3C->id,
                'genre' => 'Masculin',
                'date_inscription' => '2024-09-10',
                'parent_nom' => 'Tuteur Klanlenou',
                'parent_relation' => 'Tuteur',
                'parent_telephone' => '+228 90 90 90 90'
            ]
        ];

        foreach ($eleves as $eleveData) {
            Eleve::firstOrCreate(['matricule' => $eleveData['matricule']], $eleveData);
        }
    }
}