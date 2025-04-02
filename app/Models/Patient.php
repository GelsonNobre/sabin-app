<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'cpf',
        'gender',
        'phone',
        'birth',
        'emergency_number',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'notes',
    ];

    /**
     * @return HasMany <Order, $this>
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    //Função para retornar o nome do tipo de idade no componente Show
    public function getGenderNameAttribute(): string
    {
        return match ($this->gender) {
            'feminino'  => 'Feminino',
            'masculino' => 'Masculino',
            default     => 'Desconhecido',
        };
    }
}
