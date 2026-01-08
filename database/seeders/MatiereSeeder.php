<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;

class MatiereSeeder extends Seeder
{
    public function run(): void
    {
        $matieres = [

            // ===== COLLÈGE =====
            ['nom' => 'Mathématiques', 'code' => 'MATH', 'coefficient' => 4],
            ['nom' => 'Français', 'code' => 'FR', 'coefficient' => 3],
            ['nom' => 'Anglais', 'code' => 'ANG', 'coefficient' => 3],
            ['nom' => 'Physique-Chimie', 'code' => 'PC', 'coefficient' => 2],
            ['nom' => 'SVT', 'code' => 'SVT', 'coefficient' => 2],
            ['nom' => 'Histoire-Géographie', 'code' => 'HG', 'coefficient' => 2],
            ['nom' => 'Éducation Civique et Morale', 'code' => 'ECM', 'coefficient' => 1],
            ['nom' => 'Informatique', 'code' => 'INFO', 'coefficient' => 1],
            ['nom' => 'Technologie', 'code' => 'TECH', 'coefficient' => 1],
            ['nom' => 'EPS', 'code' => 'EPS', 'coefficient' => 1],
            ['nom' => 'Musique', 'code' => 'MUS', 'coefficient' => 1],
            ['nom' => 'Dessin', 'code' => 'DES', 'coefficient' => 1],

            // ===== LYCÉE =====
            ['nom' => 'Philosophie', 'code' => 'PHILO', 'coefficient' => 3],
            ['nom' => 'Chimie', 'code' => 'CH', 'coefficient' => 3],
            ['nom' => 'Physique', 'code' => 'PHY', 'coefficient' => 3],
            ['nom' => 'Allemand', 'code' => 'ALL', 'coefficient' => 2],
            ['nom' => 'Espagnol', 'code' => 'ESP', 'coefficient' => 2],
            ['nom' => 'Économie', 'code' => 'ECO', 'coefficient' => 2],
            ['nom' => 'Comptabilité', 'code' => 'COMP', 'coefficient' => 2],
            ['nom' => 'Gestion', 'code' => 'GEST', 'coefficient' => 2],
            ['nom' => 'Droit', 'code' => 'DRT', 'coefficient' => 2],
        ];

        foreach ($matieres as $matiere) {
            Matiere::firstOrCreate(
                ['code' => $matiere['code']],
                $matiere
            );
        }
    }
}