<?php

namespace App\Livewire\Forms;

use App\Models\OrderStatus;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StatusForm extends Form
{
    public ?OrderStatus $object = null;

    #[Validate('required|min:3', as: 'nome')]
    public ?string $name = null;


    public function setObject(OrderStatus $object): void
    {
        $this->object               = $object;
        $this->name                 = $object->name;
       
    }

    public function store(): void
    {
        $this->validate();

        if (empty($this->object)) {
            $this->object = OrderStatus::query()->create([
                'name'                 => $this->name,
            ]);
        } else {
            $this->object->update([
                'name'                 => $this->name,
            ]);
        }
    }
}
