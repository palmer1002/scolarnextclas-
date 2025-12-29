<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\Bulletin;
class BulletinSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::all();

        foreach ($eleves as $eleve) {
            // Calcul des moyennes par trimestre
            for ($trimestre = 1; $trimestre <= 3; $trimestre++) {
                $notesTrimestre = Note::where('eleve_id', $eleve->id)
                    ->where('trimestre', $trimestre)
                    ->get();

                if ($notesTrimestre->count() > 0) {
                    $moyenneTrimestre = $notesTrimestre->sum(function ($note) {
                        return $note->note * $note->coefficient;
                    }) / $notesTrimestre->sum('coefficient');

                    Bulletin::updateOrCreate(
                        [
                            'eleve_id' => $eleve->id,
                            'trimestre' => $trimestre,
                        ],
                        [
                            'semestre' => $trimestre <= 2 ? 1 : 2,
                            'moyenne' => round($moyenneTrimestre, 2),
                            'annee_scolaire' => '2025-2026',
                        ]
                    );
                }
            }

            // Calcul des moyennes par semestre
            for ($semestre = 1; $semestre <= 2; $semestre++) {
                $notesSemestre = Note::where('eleve_id', $eleve->id)
                    ->where('semestre', $semestre)
                    ->get();

                if ($notesSemestre->count() > 0) {
                    $moyenneSemestre = $notesSemestre->sum(function ($note) {
                        return $note->note * $note->coefficient;
                    }) / $notesSemestre->sum('coefficient');

                    Bulletin::updateOrCreate(
                        [
                            'eleve_id' => $eleve->id,
                            'semestre' => $semestre,
                        ],
                        [
                            'moyenne' => round($moyenneSemestre, 2),
                            'annee_scolaire' => '2025-2026',
                        ]
                    );
                }
            }
        }
    }
}