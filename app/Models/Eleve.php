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
        'genre',
        'classe_id',
        'date_naissance',
        'adresse',
        'email',
        'parent_nom',
        'parent_relation',
        'parent_telephone',
        'date_inscription',
        'statut',
    ];

    protected $casts = [
        'date_inscription' => 'date',
        'date_naissance' => 'date',
    ];

    //  Relations
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    //  Accessor
    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }
}