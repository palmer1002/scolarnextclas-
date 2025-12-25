<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'classe',
        'genre',
        'date_inscription',
        'contact_parent'
    ];

    protected $casts = [
        'date_inscription' => 'date',
    ];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }
}