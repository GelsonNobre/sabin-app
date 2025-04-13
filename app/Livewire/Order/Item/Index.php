<?php

namespace App\Livewire\Order\Item;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    #[Modelable]
    public array $items = [];

    public float $total = 0;


    public function render(): View
    {
        return view('livewire.order.item.index');
    }

    public function mount(): void
    {

        if ($this->items) {
            $this->updateTotal();
        }

    }

    public function boot(): void
    {
        if (empty($this->items)) {
            $this->reset('total');
        }
    }

    private function updateTotal(): void
    {
        $this->total = array_sum(array_column($this->items, 'value'));

    }

    /** @param array<string, mixed> $object */
    #[On('order::item::created')]
    public function store(array $object): void
    {

        if (!is_array($this->items)) {
            $this->items = [];
        }

        $this->items[$object['id']] = $object;

        $this->updateTotal();
    }

    /**
     * @param array<string, mixed> $object
     */
    #[On('order::item::updated')]
    public function update(array $items): void
    {
        foreach ($items as $id => $item) {
            $this->items[$id] = $item;
        }

        $this->updateTotal();
    }

    #[On('order::item::deleted')]
    public function delete(int $key): void
    {
        unset($this->items[$key]);
        $this->updateTotal();
    }
}
