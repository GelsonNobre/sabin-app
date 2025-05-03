<?php
namespace App\Livewire\Nurse;

use App\Models\Nurse;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\Attributes\On;

class Show extends Component
{
    public ?Nurse $object = null;

    public bool $modal = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.nurse.show');
    }

    #[On('nurse::show')]
    public function load(int $id): void
    {
     
        $this->object = Nurse::find($id);

        $this->modal = true;
    }

}
