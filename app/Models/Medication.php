<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medication extends Model
{
    protected $fillable = [
        'name',
        'producer',
        'type_of_aplication',
        'price',
        'age_type',
    ];

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getStockQuantityAttribute()
    {
        return $this->stockMovements()->sum('quantity');
    }


    public function producer()
    {
        return $this->belongsTo(Medication::class);
    }
}
