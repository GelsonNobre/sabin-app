<?php

namespace App\Livewire\Medication;

use App\Models\Medication;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;

class Show extends Component
{
    public ?Medication $object = null;
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.medication.show');
    }

    public function mount(int $id): void
    {
        $this->object = Medication::find($id);
    }
}
