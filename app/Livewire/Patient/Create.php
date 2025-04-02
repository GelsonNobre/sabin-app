<?php

namespace App\Livewire\Patient;

use App\Enums\States;
use App\Livewire\Forms\PatientForm;
use App\Traits\{HandlesAuthorizationFeedback};
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    use HandlesAuthorizationFeedback;

    public PatientForm $form;

    public array $states = [];

    public $genders = [];

    public bool $showAuthorizationModal = false;
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.patient.create');
    }

    public function mount(): void
    {
        $this->states  = States::objects();
        $this->genders = $this->genders();
    }

    public function genders()
    {
        return collect([
            (object) ['id' => 'NL', 'name' => 'Selecione'],
            (object) ['id' => 'feminino', 'name' => 'Feminino'],
            (object) ['id' => 'masculino', 'name' => 'Masculino'],
        ]);
    }

    public function submit(): void
    {
        if (!$this->authorizeWithMessage('write_patients')) {
            return;
        }

        $this->form->store();
        $this->success('Novo paciente criado com sucesso!');
        $this->redirect('/patients');
    }

}
