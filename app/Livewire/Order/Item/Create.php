<?php

namespace App\Livewire\Order\Item;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast; 

    public ?int $id = null;

    #[Validate('required', as: 'item')]
    public ?string $item = null;

    public array $medications;

    public array $items = [];


    public function render(): View
    {
        return view('livewire.order.item.create');
    }


    public function store(): void
    {
        $data = $this->validate();

        $data['id'] = $this->id;
        $data['name'] = $this->name;

        $this->dispatch('order::item::created', object: $data)->to('order.item.index');

        $this->success('Nova medicação adicionada com sucesso!');

        $this->reset('id', 'item', 'value');
    }
}
