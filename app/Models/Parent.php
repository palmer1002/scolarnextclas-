<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'user_id',
        'nom_complet',
        'telephone',
        'email',
        'adresse',
        'profession',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eleves()
    {
        return $this->hasMany(Eleve::class, 'parent_id'); // We need to ensure Eleve has parent_id or use user_id logic
    }
}