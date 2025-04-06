<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public ?Patient $patient;

    public bool $modal = false;
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.patient.delete');
    }

    #[On('patient::delete')]
    public function openConfirmationFor(int $id): void
    {
        $this->patient = Patient::find($id);
        $this->modal   = true;
    }

    public function destroy(): void
    {
        $this->authorize('write_patients');

        $this->patient->delete();
        $this->success('Paciente excluido(a) com sucesso!');
        $this->dispatch('patient::deleted');
        $this->reset();
        $this->redirect('/patients');
    }
}
