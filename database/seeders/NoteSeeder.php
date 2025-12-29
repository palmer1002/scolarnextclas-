<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Eleve;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::all();

        foreach ($eleves as $eleve) {
            // Liste des matières
            $matieres = ['Mathématiques', 'Français', 'Anglais', 'Physique', 'SVT', 'Histoire-Géo'];

            foreach ($matieres as $matiere) {
                // Générer des notes pour les 3 trimestres
                for ($trimestre = 1; $trimestre <= 3; $trimestre++) {
                    Note::create([
                        'eleve_id' => $eleve->id,
                        'trimestre' => $trimestre,
                        'semestre' => $trimestre <= 2 ? 1 : 2, // T1 et T2 = Semestre 1, T3 = Semestre 2
                        'matiere' => $matiere,
                        'note' => fake()->randomFloat(2, 5, 20), // note réaliste entre 5 et 20
                        'coefficient' => fake()->numberBetween(1, 3),
                        'annee_scolaire' => '2025-2026',
                    ]);
                }
            }
        }
    }
}