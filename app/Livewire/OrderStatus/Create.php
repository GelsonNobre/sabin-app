<?php

namespace App\Livewire\OrderStatus;

use App\Livewire\Forms\StatusForm;
use App\Models\OrderStatus;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\On;

class Create extends Component

{

    use Toast;

    public StatusForm $form;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.order-status.create');
    }


    #[On('orderStatus::create')] 
    public function load(): void
    {
        $this->modal = true;
    }
    
    public function submit(): void
    {
        
        $this->form->store();
        $this->success('Novo Status criado com sucesso!');
        $this->redirect('/order-status');
    }
}
