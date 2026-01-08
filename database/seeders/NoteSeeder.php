<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\Matiere;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::all();

        foreach ($eleves as $eleve) {
            // Liste des matières - vérifier si elles existent, sinon les créer
            $matieres = [
                ['nom' => 'Mathématiques', 'code' => 'MATH', 'coefficient' => 3],
                ['nom' => 'Français', 'code' => 'FR', 'coefficient' => 3],
                ['nom' => 'Anglais', 'code' => 'ANG', 'coefficient' => 2],
                ['nom' => 'Physique', 'code' => 'PHYS', 'coefficient' => 2],
                ['nom' => 'SVT', 'code' => 'SVT', 'coefficient' => 2],
                ['nom' => 'Histoire-Géo', 'code' => 'HG', 'coefficient' => 2],
            ];

            foreach ($matieres as $matiereData) {
                $matiere = Matiere::firstOrCreate(
                    ['nom' => $matiereData['nom']],
                    $matiereData
                );

                // Générer des notes pour les 3 trimestres
                for ($trimestre = 1; $trimestre <= 3; $trimestre++) {
                    Note::create([
                        'eleve_id' => $eleve->id,
                        'matiere_id' => $matiere->id,
                        'trimestre' => $trimestre,
                        'semestre' => $trimestre <= 2 ? 1 : 2, // T1 et T2 = Semestre 1, T3 = Semestre 2
                        'note' => fake()->randomFloat(2, 5, 20), // note réaliste entre 5 et 20
                        'coefficient' => $matiereData['coefficient'],
                        'annee_scolaire' => '2025-2026',
                    ]);
                }
            }
        }
    }
}