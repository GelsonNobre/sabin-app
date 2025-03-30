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

    //Função para retornar a quantidade de stock no componente Index
    public function getStockQuantityAttribute()
    {
        return $this->stockMovements()->sum('quantity');
    }

    //Função para retornar o nome do tipo de idade no componente Show
    public function getAgeTypeNameAttribute(): string
    {
        return match ($this->age_type) {
            'adulto'   => 'Adulto',
            'infantil' => 'Infantil',
            default    => 'Desconhecido',
        };
    }

    //Função para retornar o nome do tipo de aplicação no componente Show
    public function getTypeOfAplicationNameAttribute(): string
    {
        return match ($this->type_of_aplication) {
            'IM'    => 'Intramuscular',
            'IV'    => 'Intravenosa',
            'SC'    => 'Subcutânea',
            'IA'    => 'Intra-articular',
            default => 'Desconhecida',
        };
    }

    public function producer()
    {
        return $this->belongsTo(Medication::class);
    }
}
