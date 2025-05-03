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
        $this->total = array_sum(array_column($this->items, 'total'));
        // dump(array_column($this->products, 'total'));
        $this->dispatch('order::value::updated', total: $this->total);
    }

    #[On('order::item::created')]
    public function store(array $object): void
    {
        if (in_array($object['id'], array_keys($this->items))) {
            unset($this->items[$object['id']]);
        }
        $this->items[$object['id']] = $object;
        $this->updateTotal();
    }

    /**
     * @param array<string, mixed> $object
     */
    #[On('order::item::updated')]
    public function update(array $object): void
    {
        unset($this->items[$object['id']]);
        $this->items[$object['id']] = $object;
        $this->updateTotal();
    }


    #[On('order::item::deleted')]
    public function delete(int $key): void
    {
        unset($this->items[$key]);
        $this->updateTotal();
    }
}
