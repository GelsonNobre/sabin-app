<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nurse extends Model
{
    protected $fillable = [
        'name',
        'birth',
        'phone',
        'email',
        'coren',
    ];
    
    public function nurses(): HasMany
    {
        return $this->hasmany(Nurse::class);
    }
}
