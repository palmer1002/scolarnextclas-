<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'nom_complet',
        'telephone',
        'email',
        'adresse',
    ];

    /**
     * Relation : un parent peut avoir plusieurs élèves.
     */
    public function eleves()
    {
        return $this->hasMany(Eleve::class, 'parent_id', 'id');
    }
}