<?php

namespace App\Livewire\Nurse;

use App\Models\Nurse;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public bool $modal = false;
    
    public ?Nurse $nurse = null;

    public function render()
    {
        return view('livewire.nurse.delete');
    }

    #[On('nurse::delete')]
    public function open(int $id): void
    {
        $this->nurse = Nurse::findOrFail($id);
        $this->modal = true;
    }

    public function destroy(): void
    {
        $this->nurse->delete();
        $this->reset('modal', 'nurse');
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Enfermeiro excluído com sucesso!'
        ]);
    }
}