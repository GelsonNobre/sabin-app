<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;


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



    public static function deductSt($medicationId, $quantityNeeded)
    {
        $remaining = $quantityNeeded;

        $batches = self::where('medication_id', $medicationId)
            ->where('type', 'entrada')
            ->where('quantity', '>', 0)
            ->where('expirate_date', '>=', now())
            ->orderBy('expirate_date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($batches as $batch) {
            if ($remaining <= 0) break;

            $retirada = min($remaining, $batch->quantity);

            // Atualiza a quantidade do lote
            $batch->quantity -= $retirada;
            $batch->save();

            // Cria o registro de saída
            self::create([
                'medication_id' => $medicationId,
                'user_id'       => Auth::id(),
                'batch'         => $batch->batch,
                'shot'          => $batch->shot ?? null, // mantém se estiver usando esse campo
                'expirate_date' => $batch->expirate_date,
                'quantity'      => $retirada,
                'type'          => 'saida',
            ]);

            $remaining -= $retirada;
        }

        if ($remaining > 0) {
            $med = \App\Models\Medication::find($medicationId);
            $estoqueAtual = (int) $med->stock ?? 0;

            throw new \Exception(
                "Estoque insuficiente para o medicamento \"{$med->name}\". " .
                    "Quantidade solicitada: $quantityNeeded. Estoque disponível: $estoqueAtual."
            );
        }
    }

    public static function deductStock($medicationId, $quantityNeeded)
    {
        $remaining = $quantityNeeded;

        $batches = self::where('medication_id', $medicationId)
            ->where('type', 'entrada')
            ->where('expirate_date', '>=', now())
            ->orderBy('expirate_date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($batches as $batch) {
            if ($remaining <= 0) break;

            // calcula quanto pode retirar desse lote
            $saidasDesseLote = self::where('type', 'saida')
                ->where('medication_id', $medicationId)
                ->where('batch', $batch->batch)
                ->sum('quantity');

            $disponivelNoLote = $batch->quantity - $saidasDesseLote;

            if ($disponivelNoLote <= 0) continue;

            $retirada = min($remaining, $disponivelNoLote);

            self::create([
                'medication_id' => $medicationId,
                'user_id'       => Auth::id(),
                'batch'         => $batch->batch,
                'shot'          => $batch->shot ?? null,
                'expirate_date' => $batch->expirate_date,
                'quantity'      => $retirada,
                'type'          => 'saida',
            ]);

            $remaining -= $retirada;
        }

        if ($remaining > 0) {
            $med = \App\Models\Medication::find($medicationId);
            $estoqueAtual = (int) $med->stock ?? 0;

            throw new \Exception(
                "Estoque insuficiente para o medicamento \"{$med->name}\". " .
                    "Quantidade solicitada: $quantityNeeded. Estoque disponível: $estoqueAtual."
            );
        }
    }
}
