<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EleveFactory extends Factory
{
    public function definition()
    {
        return [
            'matricule' => 'SNC' . date('Y') . str_pad($this->faker->unique()->numberBetween(1, 999), 4, '0', STR_PAD_LEFT),
            'prenom' => $this->faker->firstName(),
            'nom' => $this->faker->lastName(),
            'genre' => $this->faker->randomElement(['Masculin', 'Féminin']),
            'date_naissance' => $this->faker->dateTimeBetween('-18 years', '-6 years'),
            'lieu_naissance' => $this->faker->city(),
            'adresse' => $this->faker->address(),
            'telephone' => '+228 ' . $this->faker->regexify('[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}'),
            'email' => $this->faker->unique()->safeEmail(),
            'parent_nom' => $this->faker->name(),
            'parent_relation' => $this->faker->randomElement(['Père', 'Mère', 'Tuteur']),
            'parent_telephone' => '+228 ' . $this->faker->regexify('[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}'),
            'parent_email' => $this->faker->safeEmail(),
            'parent_adresse' => $this->faker->address(),
            'parent_profession' => $this->faker->jobTitle(),
            'classe_id' => \App\Models\Classe::inRandomOrder()->first()->id,
            'date_inscription' => $this->faker->dateTimeBetween('-1 year'),
            'statut' => 'actif',
            'notes' => $this->faker->sentence(),
            'groupe_sanguin' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
        ];
    }
}