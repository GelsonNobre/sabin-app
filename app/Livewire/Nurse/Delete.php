<?php

namespace App\Livewire\Nurse;

use App\Models\Nurse;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;
    
    public ?Nurse $nurse = null;
    
    public bool $modal = false;

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
        $this->authorize('write_nurse');

        $this->nurse->delete();
        $this->success('Cadastro de enfermeiro excluido com sucesso!');
        $this->dispatch('nurse::deleted');
        $this->reset();
        $this->redirect('/nurses');
    }

}