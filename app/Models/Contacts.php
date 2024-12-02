<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contacts extends Model
{
    protected $fillable = [
        'person_id',
        'description',
        'phone',
        'email',
    ];

    /**
     * @return BelongsTo<Person, $this>
     */
    public function persons(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
