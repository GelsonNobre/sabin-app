<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\Order;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\OrderStatus;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class Show extends Component
{
    public ?Order $object = null;

    public array $patientsSearchable = [];
    public array $nursesSearchable = [];
    public array $orderStatuses = [];

    public function render(): Factory|View|Application
    {
        return view('livewire.order.show');
    }

    public function mount(int $id): void
    {
        $this->object = Order::with('medications')->findOrFail($id);

        $this->patientsSearchable = Patient::pluck('name', 'id')->toArray();
        $this->nursesSearchable = Nurse::pluck('name', 'id')->toArray();
        $this->orderStatuses = OrderStatus::pluck('name', 'id')->toArray();
    }

}
