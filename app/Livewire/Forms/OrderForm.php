<?php

namespace App\Livewire\Forms;

use App\Models\Order;
use Livewire\Attributes\Validate;
use Livewire\Form;

class OrderForm extends Form
{
    public ?Order $object = null;

    public ?int $user_id = null;

    public ?int $patient_id = null;

    public ?int $nurse_id = null;

    public ?int $order_status_id = null;

    public ?string $open_date = null;

    public ?float $total = null;

    public ?string $notes = null;

    #[Validate('required', as: 'medicações')]
    public array $medications = [];


    public function setObject(Order $object): void
    {
        $this->object               = $object;
        $this->user_id              = $object->user_id;
        $this->patient_id           = $object->patient_id;
        $this->nurse_id             = $object->nurse_id;
        $this->order_status_id      = $object->order_status_id;
        $this->open_date            = $object->open_date;
        $this->total                = $object->total;
        $this->notes                = $object->notes;


        foreach ($object->medications as $medication) {
            $item = [
                'id'        => $medication->id,
                'name'      => $medication->name,
                'quantity'  => $medication->pivot->quantity,
                'price'     => $medication->pivot->price,
                'total'     => strval((float)$medication->pivot->quantity * (float)$medication->pivot->price),
            ];  

            $this->medications[$medication->id] = $item;
        }
    }

    public function store(): void
    {
        $this->validate();
        
        if (empty($this->object->id)) {
            $this->object = Order::query()->create([
                'user_id'              => $this->user_id,
                'patient_id'           => $this->patient_id,
                'nurse_id'             => $this->nurse_id,
                'order_status_id'      => $this->order_status_id,
                'open_date'            => $this->open_date,
                'total'                => $this->total,
                'notes'                => $this->notes,
            ]);
        } else {
            $this->object->update([
                'user_id'              => $this->user_id,
                'patient_id'           => $this->patient_id,
                'nurse_id'             => $this->nurse_id,
                'order_status_id'      => $this->order_status_id,
                'open_date'            => $this->open_date,
                'total'                => $this->total,
                'notes'                => $this->notes,
            ]);
        }

        $medications = [];

        foreach ($this->medications as $medication) {
            $medications[$medication['id']] = [
                'quantity'  => $medication['quantity'],
                'price'     => $medication['price'],
            ];
        }

        $this->object->medications()->sync($medications);


    }
            
}
    





