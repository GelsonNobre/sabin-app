<?php

namespace App\Livewire\Nurse;

use Livewire\Component;

class Show extends Component
{
    public bool $modal = false;
    public function render()
    {
        return view('livewire.nurse.show');
    }
}
