<?php

namespace App\Livewire\Order\Item;

use App\Models\Medication;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use App\Helpers\Formatter;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    #[Validate('required', as: 'produto')]
    public ?int $id = null;

    #[Validate('required', as: 'produto')]
    public ?string $name = null;

    #[Validate('required', as: 'quantidade')]
    public ?int $quantity = null;

    #[Validate('required', as: 'valor')]
    public ?float $price = null;

    //public array $medications = [];

    public array $items = [];


    public function render(): View
    {
        return view('livewire.order.item.create');
    }

    public function mount(): void {}



    #[On('order::item::selected')]
    public function preencherMedicamento($med): void
    {
        $this->id = $med['id'];
        $this->name = $med['name'];
        $this->price = $med['price'];
    }

    public function productClear(): void
    {
        $this->reset('id', 'name', 'price');
    }


    public function storess(): void
    {
        $data          = $this->validate();
        $data['total'] = $data['quantity'] * $data['price'];

        $this->dispatch('order::item::created', object: $data)->to('order.item.index');
        $this->success('Novo medicamento adicionado!');

        $this->reset();
    }


    public function store(): void
    {
        $data = $this->validate();

        $price = Formatter::toFloat($data['price']); // 🔥 aqui é o ouro
        $quantity = $data['quantity'];

        $data['price'] = $price;
        $data['total'] = $quantity * $price;

        $this->dispatch('order::item::created', object: $data)->to('order.item.index');
        $this->success('Novo medicamento adicionado!');

        $this->reset();
    }
}
