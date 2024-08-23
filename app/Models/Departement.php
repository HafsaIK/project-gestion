<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    public function employers()
    {
        return $this->hasMany(Employer::class, 'departement_id');
    }
}
