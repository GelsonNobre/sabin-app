<?php

namespace App\Livewire\OrderStatus;

use App\Livewire\Forms\StatusForm;
use App\Models\OrderStatus;
use Livewire\Component;
use Mary\Traits\Toast;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;

class Edit extends Component
{

    use Toast;

    public StatusForm $form;

    public bool $modal = false;

    public function render():Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.order-status.edit');
    }

    #[On('orderStatus::edit')] 
    public function load(int $id): void
    {
        $status = OrderStatus::find($id);
        $this->form->setObject($status);
        $this->modal = true;
    }

    public function submit(): void
    {
        $this->form->store();
        $this->success('Novo Status criado com sucesso!');
        $this->redirect('/order-status');
    }
}
