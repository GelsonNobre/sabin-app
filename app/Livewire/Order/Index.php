<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public string $sortBy = 'id';


    public function getOrdersProperty()
    {
        return Order::with(['patient', 'medication', 'ordersStatus', 'nurse']) // ou o relacionamento que tiver
            ->whereHas('patient', fn ($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orWhere('doctor', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy)
            ->paginate(10);
    }


    public function render()
    {
        return view('livewire.order.index');
    }
}
