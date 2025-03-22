<?php

namespace App\Livewire\Medication;

use Livewire\Component;
use App\Models\Medication;
use Livewire\Attributes\On;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;
    public Medication $medication;

    public bool $modal = false;

    public function render()

    {
        return view('livewire.medication.delete');
    }
    #[On('medication::delete')]
    public function openConfirmationFor(int $id): void
    {
        $this->medication = Medication::find($id);
        $this->modal      = true;
    }

    public function destroy(): void
    {
        $this->autorize('write_medications');

        $this->medication->delete();
        $this->success('Medicação excluida com sucesso!');
        $this->dispatch('medication::deleted');
        $this->reset();
    }
}
