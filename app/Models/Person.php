<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasMany, HasOne};

class Person extends Model
{
    // use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'type',
        'name',
        'alias',
        'cpf_cnpj',
        'rg_ie',
        'birth',
        'zip_code',
        'address',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'reference',
        'note',
        'active',
    ];

    /**
     * @return BelongsToMany<Attribute, $this>
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_person', 'person_id', 'attribute_id');
    }

    /**
     * @return HasOne<Contacts, $this>
     */
    public function contact()
    {
        return $this->hasOne(Contacts::class)->oldestOfMany();
    }

    /**
     * Get the contacts associated with the person.
     *
     * @return HasMany<Contacts, $this> The related contacts.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contacts::class);
    }
}
