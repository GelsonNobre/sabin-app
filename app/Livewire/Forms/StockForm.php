<?php

namespace App\Livewire\Forms;

use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StockForm extends Form
{
    public ?StockMovement $object = null;

    #[Validate('required', as: 'medication_id')]
    public  $medication_id = null;

    public ?int $user_id = null;

    #[Validate('required', as: 'quantity')]
    public ?int $quantity = null;

    #[Validate('required', as: 'expirate_date')]
    public ?string $expirate_date = null;

    #[Validate('required', as: 'batch')]
    public ?string $batch = null;

    #[Validate('required', as: 'type')]
    public ?string $type = null;




    public function setObject(StockMovement $object): void
    {
        $this->object               = $object;
        $this->medication_id        = $object->medication_id;
        $this->user_id              = $object->user_id;
        $this->quantity             = $object->quantity;
        $this->expirate_date        = $object->expirate_date;
        $this->batch                = $object->batch;
        $this->type                 = $object->type;
    }

    public function store(): void
    {
        $this->validate();

        if (empty($this->object->id)) {
            $this->object = StockMovement::query()->create([
                'medication_id'        => $this->medication_id,
                'user_id'              => Auth::id(),
                'quantity'             => $this->quantity,
                'expirate_date'        => $this->expirate_date,
                'batch'                => $this->batch,
                'type'                 => $this->type,
            ]);
        } else {
            $this->object->update([
                'medication_id'        => $this->medication_id,
                'user_id'              => Auth::id(),
                'quantity'             => $this->quantity,
                'expirate_date'        => $this->expirate_date,
                'batch'                => $this->batch,
                'type'                 => $this->type,
            ]);
        }
    }
}
