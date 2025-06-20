<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    protected $fillable = [
        'name',
    ];

    public const CONCLUIDA_ID = 5;

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
