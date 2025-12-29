<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed users with different roles
        $this->call(RoleUserSeeder::class);

        $this->call([
            RoleUserSeeder::class,
            ClasseSeeder::class,   // si tu veux générer des classes automatiquement
            EleveSeeder::class,
            NoteSeeder::class,
            BulletinSeeder::class,
        ]);

        $this->command->info('Données de test créées avec succès!');
     


    }
    
}