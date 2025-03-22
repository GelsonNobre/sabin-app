<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'medication_id',
        'user_id',
        'batch',
        'quantity',
        'type',
        'expirate_date',
    ];

    public function medication(): BelongsTo
    {
        return $this->belongsTo(Medication::class)
            ->with('producer');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    public static function deductStock($medicationId, $quantityNeeded)
    {
        $remaining = $quantityNeeded;

        // Busca os lotes mais antigos e NÃO vencidos primeiro
        $batches = StockMovement::where('medication_id', $medicationId)
            ->where('type', 'entrada')
            ->where('quantity', '>', 0)
            ->where('expirate_date', '>=', now()) // Apenas lotes não vencidos
            ->orderBy('expirate_date', 'asc') // Prioriza os mais próximos de vencer
            ->orderBy('created_at', 'asc') // FIFO: Primeiro a Entrar, Primeiro a Sair
            ->get();

        foreach ($batches as $batch) {
            if ($remaining <= 0) break;

            // Se o lote tem estoque suficiente, faz a retirada total
            if ($batch->quantity >= $remaining) {
                $batch->quantity -= $remaining;
                $batch->save();

                // Criamos um registro de saída para esse lote
                StockMovement::create([
                    'medication_id' => $medicationId,
                    'batch' => $batch->batch,
                    'shot' => $batch->shot,
                    'expirate_date' => $batch->expirate_date,
                    'quantity' => $remaining,
                    'type' => 'saída',
                ]);

                $remaining = 0;
            } else {
                // Se o lote não for suficiente, consome tudo dele e passa para o próximo
                $remaining -= $batch->quantity;

                StockMovement::create([
                    'medication_id' => $medicationId,
                    'batch' => $batch->batch,
                    'shot' => $batch->shot,
                    'expirate_date' => $batch->expirate_date,
                    'quantity' => $batch->quantity,
                    'type' => 'saída',
                ]);

                $batch->quantity = 0;
                $batch->save();
            }
        }

        if ($remaining > 0) {
            throw new \Exception("Estoque insuficiente para o medicamento ID: $medicationId");
        }
    }
}
