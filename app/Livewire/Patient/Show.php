<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;

class Show extends Component
{
    public ?Patient $object = null;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.patient.show');
    }

    public function mount(int $id): void
    {
        $this->object = Patient::find($id);
    }
}
