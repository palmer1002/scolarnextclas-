<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classe;

class EleveFactory extends Factory
{
    public function definition()
    {
        return [
            'matricule' => 'SNC' . date('Y') . str_pad($this->faker->unique()->numberBetween(1, 999), 4, '0', STR_PAD_LEFT),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'genre' => $this->faker->randomElement(['Masculin', 'Féminin']),
            'date_naissance' => $this->faker->dateTimeBetween('-18 years', '-6 years'),
            'adresse' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'parent_nom' => $this->faker->name(),
            'parent_relation' => $this->faker->randomElement(['Père', 'Mère', 'Tuteur']),
            'parent_telephone' => '+228 ' . $this->faker->regexify('[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}'),
            'classe_id' => Classe::inRandomOrder()->first()->id ?? Classe::factory(),
            'date_inscription' => $this->faker->dateTimeBetween('-1 year'),
            'statut' => 'actif',
        ];
    }
}