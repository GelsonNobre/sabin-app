<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * @return BelongsToMany<Person, $this>
     */
    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'attribute_person', 'attribute_id', 'person_id');
    }
}
