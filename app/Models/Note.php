<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'trimestre',
        'matiere',
        'note',
        'coefficient',
        'annee_scolaire'
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}