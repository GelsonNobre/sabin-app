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
    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function nurse()
    {
        return $this->belongsTo(\App\Models\Nurse::class);
    }

    public function medication()
    {
        return $this->belongsTo(\App\Models\Medication::class);
    }
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
