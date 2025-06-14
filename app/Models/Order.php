<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\OrderStatus;
use App\Models\Medication;


class Order extends Model
{

    protected $fillable = [
        'user_id',
        'order_status_id',
        'patient_id',
        'nurse_id',
        'open_date',
        'doctor',
        'CRM',
        'notes',
    ];

    protected $casts = [
        'open_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function nurse()
    {
        return $this->belongsTo(\App\Models\Nurse::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function medications()
    {
        return $this->belongsToMany(Medication::class, 'order_medications')
            ->withPivot(['quantity', 'price'])
            ->withTimestamps();
    }

    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function finalizeOrder()
    {
        foreach ($this->medications as $medication) {
            StockMovement::deductStock(
                $medication->id,
                $medication->pivot->quantity
            );
        }

        // Define status "Aguardando Pagamento"
        $status = \App\Models\OrderStatus::where('name', '2 - Aguardando Pagamento')->first();

        if (! $status) {
            throw new \Exception('Status "2 - Aguardando Pagamento" não encontrado.');
        }

        $this->update(['order_status_id' => $status->id]);
    }

    public function getTotalPriceAttribute(): float
    {
        return $this->medications->sum(function ($med) {
            return $med->pivot->price * $med->pivot->quantity;
        });
    }

    public function getPdfData(): self
    {
        return self::with(['patient', 'nurse', 'medications'])
            ->findOrFail($this->id);
    }
}
