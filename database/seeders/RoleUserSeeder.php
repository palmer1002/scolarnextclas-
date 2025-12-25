<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user (already exists, but let's ensure it's there)
        User::firstOrCreate([
            'email' => 'admin@scolarnextclas.com'
        ], [
            'name' => 'Administrateur',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        
        // Create sample enseignant
        User::firstOrCreate([
            'email' => 'j.kokoroko@school.com'
        ], [
            'name' => 'Pr Jean Kokoroko',
            'password' => Hash::make('prof123'),
            'role' => 'enseignant',
        ]);

        User::firstOrCreate([
            'email' => 'f.traore@school.com'
        ], [
            'name' => 'Mme. Fatima Traoré',
            'password' => Hash::make('prof124'),
            'role' => 'enseignant',
        ]);
        
        // Create sample parent
        User::firstOrCreate([
            'email' => 'parent@scolarnextclas.com'
        ], [
            'name' => 'Parent Martin',
            'password' => Hash::make('parent123'),
            'role' => 'parent',
        ]);
        
        // Create sample eleve
        User::firstOrCreate([
            'email' => 'eleve@scolarnextclas.com'
        ], [
            'name' => 'Élève Durand',
            'password' => Hash::make('eleve123'),
            'role' => 'eleve',
        ]);
    }
}