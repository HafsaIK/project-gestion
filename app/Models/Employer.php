<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Utilisation du modèle Authenticatable
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employer extends Authenticatable // Extension de Authenticatable
{
    use HasFactory;

    // Les colonnes protégées
    protected $guarded = [''];

    // Relation avec le modèle Departement
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    // Relation avec le modèle Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
