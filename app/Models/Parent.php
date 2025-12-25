<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eleve extends Model
{
    use HasFactory;

    protected $table = 'eleve';

    protected $fillable = [
        'nom_complet',
        'matricule',
        'classe',
        'parent_id',
    ];

    /**
     * Relation : un élève appartient à un parent.
     */
    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id', 'id');
    }
}