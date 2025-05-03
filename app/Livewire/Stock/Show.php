<?php

namespace App\Livewire\Stock;

use App\Models\StockMovement;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;

class Show extends Component
{
    public ?StockMovement $object = null;
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.stock.show');
    }

    public function mount(int $id): void
    {
        $this->object = StockMovement::find($id);
    }
}
