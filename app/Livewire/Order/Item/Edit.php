<?php

namespace App\Livewire\Order\Item;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    #[Validate('required', as: 'quantidade')]
    public ?float $quantity;

    #[Validate('required', as: 'valor')]
    public ?float $price;

    public array $med = [];

    public bool $editing = false;

    public function render(): View
    {
        return view('livewire.order.item.edit');
    }

    public function edit(): void
    {
        $this->quantity          = $this->med['quantity'];
        $this->price             = $this->med['price'];
        $this->editing           = true;
    }


    public function update(): void
    {
        $data                      = $this->validate();
        $this->med['quantity'] = $data['quantity'];
        $this->med['price']    = $data['price'];
        $this->med['total']    = ($data['quantity'] * $data['price']);

        $this->editing = false;

        $this->dispatch('order::item::updated', object: $this->med)->to('order.item.index');
        $this->success('Medicamento atualizado com sucesso!');
        $this->resetExcept('med');
    }

    public function delete(): void
    {
        $this->dispatch('order::item::deleted', key: $this->med['id'])->to('order.item.index');
        $this->success('Item deletado com sucesso!');
    }
}
