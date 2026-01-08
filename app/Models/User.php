<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function hasRole($role)
    {
        // Si vous avez une relation roles
        if ($this->roles) {
            return $this->roles->contains('name', $role);
        }

        // Si vous avez un champ role dans la table users
        return $this->role === $role;
    }

    // Convenience accessors for views -----------------------------------------------------------------
    public function getStatusAttribute($value)
    {
        // Default to 'active' if not present in DB
        return $value ?? 'active';
    }

    public function getPermissionsAttribute()
    {
        // If you later have a relation, return real permissions
        return $this->attributes['permissions'] ?? [];
    }

    public function getActivitiesAttribute()
    {
        // Placeholder collection until activity model exists
        return collect([]);
    }

    public function getRoleIconAttribute()
    {
        return match($this->role) {
            'admin' => 'user-shield',
            'enseignant' => 'chalkboard-teacher',
            'parent' => 'user',
            'eleve' => 'user-graduate',
            default => 'user',
        };
    }
}