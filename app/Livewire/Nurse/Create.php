<?php

namespace App\Livewire\Nurse;

use App\Livewire\Forms\NurseForm;
use App\Models\Nurse;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{

    use Toast;

    public NurseForm $form;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.nurse.create');
    }


    #[On('nurse::create')] 
    public function load(): void
    {
        $this->modal = true;
    }
    
    public function submit(): void
    {
        
        $this->form->store();
        $this->success('Novo enfermeiro criado com sucesso!');
        $this->redirect('/nurses');
    }
}
