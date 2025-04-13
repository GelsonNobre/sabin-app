<?php

namespace App\Livewire\Order\Item;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public ?int $id = null;

    public ?string $name = null;

    public array $item = [];

    public bool $editing = false;

    public function render():View
    {
        return view('livewire.order.item.edit');
    }

    public function edit(): void
    {
        $this->id          = $this->item['id'];
        $this->name         = $this->item['name'];
        $this->editing     = true;
    }


    public function update():void
    {
        $data = $this->validate();

        $this->item['id'] = $this->id;
        $this->item['name'] = $this->name;

        $this->editing = false;

        $this->dispatch('order::item::updated', items: [$this->item['id'] => $this->item])->to('order.item.index');
        $this->success('Item atualizado com sucesso!');
        $this->resetExcept('item');

    }

    public function delete(): void
    {
        $this->dispatch('order::item::deleted', key: $this->item['id'])->to('order.item.index');
        $this->success('Item deletado com sucesso!');
    }
}
