<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\orderStatus;


class Order extends Model
{
    
    protected $fillable = [
        'patient_id',
        'nurse_id',
        'medication_id',
        'open_date',
        'total',
        'notes',
    ];
    
    public function ordersStatus(): BelongsTo
    {
        return $this->belongsTo(orderStatus::class);
    }

    public function finalizeOrder()
    {
        foreach ($this->medications as $medication) {
            $this->deductStock($medication->id, $medication->pivot->quantity);
        }

        $this->update(['status' => 'finalizada']);
    }
}
