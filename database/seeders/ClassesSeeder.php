<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Collège (6ème, 5ème, 4ème, 3ème)
        $niveauxCollege = ['6ème', '5ème', '4ème', '3ème'];
        foreach ($niveauxCollege as $niveau) {
            Classe::firstOrCreate(
                ['nom' => $niveau, 'niveau' => 'Collège', 'annee_scolaire' => 2025],
                ['capacite_max' => 50, 'statut' => true]
            );
        }

        // 2. Lycée (2nde, 1ère, Tle) avec Séries (A4, C, D)
        // Note: 2nde is usually "2nde S" (Scientific) or "2nde A". 
        // User asked for "all series confounded A4, D, C".
        // Let's create:
        // 2nde A4, 2nde C, 2nde S (often S leads to C/D). 
        // Or simply follow exactly: 2nde A4, 2nde C. (D usually starts at 1ere).
        // However, "Toutes les séries" often implies standard curriculum:
        // 2nde A, 2nde S.
        // 1ere A4, 1ere C, 1ere D.
        // Tle A4, Tle C, Tle D.
        //
        // If user specifically said "6e en Tle toutes les series confordues A4, D, C",
        // I will allow A4, C, D on all Lycee levels to be safe and comprehensive.

        $niveauxLycee = ['2nde', '1ère', 'Tle'];
        $series = ['A4', 'C', 'D'];

        foreach ($niveauxLycee as $niveau) {
            foreach ($series as $serie) {
                // Skip illogical combinations if necessary, but request was broad.
                // e.g. 2nde D doesn't always exist (usually 2nde S).
                // But let's create them to ensure user has what they asked for.
                
                $nomClasse = "$niveau $serie";
                
                Classe::firstOrCreate(
                    ['nom' => $nomClasse, 'niveau' => 'Lycée', 'annee_scolaire' => 2025],
                    ['capacite_max' => 45, 'statut' => true, 'section' => $serie]
                );
            }
        }
    }
}
