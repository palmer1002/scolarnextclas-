<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\Note;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed users with different roles
        $this->call(RoleUserSeeder::class);
        
        // Créer des élèves
        $eleves = [
            [
                'matricule' => 'SNC2024001',
                'nom' => 'Diallo',
                'prenom' => 'Amina',
                'classe' => '4e A',
                'genre' => 'Féminin',
                'date_inscription' => '2024-09-01',
                'contact_parent' => '+228 90 90 90 90'
            ],
            [
                'matricule' => 'SNC2024002',
                'nom' => 'Kokoroko',
                'prenom' => 'Ray',
                'classe' => 'Tle D',
                'genre' => 'Masculin',
                'date_inscription' => '2024-09-05',
                'contact_parent' => '+228 90 90 90 90'
            ],
            [
                'matricule' => 'SNC2024003',
                'nom' => 'Klanlenou',
                'prenom' => 'Arnaud',
                'classe' => '3e C',
                'genre' => 'Masculin',
                'date_inscription' => '2024-09-10',
                'contact_parent' => '+228 90 90 90 90'
            ]
        ];

        foreach ($eleves as $eleveData) {
            Eleve::firstOrCreate(['matricule' => $eleveData['matricule']], $eleveData);
        }

        // Créer des notes
        $notes = [
            [
                'eleve_id' => 1,
                'trimestre' => 1,
                'matiere' => 'Mathématiques',
                'note' => 14.89,
                'coefficient' => 1,
                'annee_scolaire' => '2024-2025'
            ],
            [
                'eleve_id' => 1,
                'trimestre' => 2,
                'matiere' => 'Mathématiques',
                'note' => 10.89,
                'coefficient' => 1,
                'annee_scolaire' => '2024-2025'
            ],
            [
                'eleve_id' => 2,
                'trimestre' => 1,
                'matiere' => 'Mathématiques',
                'note' => 10.89,
                'coefficient' => 1,
                'annee_scolaire' => '2024-2025'
            ],
            [
                'eleve_id' => 2,
                'trimestre' => 2,
                'matiere' => 'Mathématiques',
                'note' => 14.89,
                'coefficient' => 1,
                'annee_scolaire' => '2024-2025'
            ],
            [
                'eleve_id' => 3,
                'trimestre' => 1,
                'matiere' => 'Mathématiques',
                'note' => 13.00,
                'coefficient' => 1,
                'annee_scolaire' => '2024-2025'
            ],
            [
                'eleve_id' => 3,
                'trimestre' => 2,
                'matiere' => 'Mathématiques',
                'note' => 13.00,
                'coefficient' => 1,
                'annee_scolaire' => '2024-2025'
            ]
        ];

        foreach ($notes as $noteData) {
            Note::firstOrCreate([
                'eleve_id' => $noteData['eleve_id'],
                'trimestre' => $noteData['trimestre'],
                'matiere' => $noteData['matiere']
            ], $noteData);
        }

        $this->command->info('Données de test créées avec succès!');
    }
}