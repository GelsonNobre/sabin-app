<?php

namespace App\Livewire\Order;

use App\Livewire\Forms\OrderForm;
use App\Models\Medication;
use App\Models\Order;
use App\Models\Patient;
use App\Traits\HandlesAuthorizationFeedback;
use Illuminate\Auth\Access\HandlesAuthorization;
use Livewire\Component;
use Mary\Traits\Toast;
use App\Models\Nurse;
use App\Models\OrderStatus;

class Create extends Component
{

    use Toast;

    use HandlesAuthorizationFeedback;

    public OrderForm $form;

    public bool $showAuthorizationModal = false;


    public $patients;

    public $medications;

    public $orderStatus;

    public $nurse;

    public function render()
    {
        return view('livewire.order.create');
    }


    public function mount(): void
    {
        $this->patients = Patient::all(['id', 'name']);
        $this->medications = Medication::all(['id', 'name']);
        $this->orderStatus = OrderStatus::all(['id', 'name']);
        $this->nurse = Nurse::all(['id', 'name']);
    }


    public function nurse(): void    
    {
        
    }


    public function submit(): void
    {
        if (!$this->authorizeWithMessage('write_orders')) {
            return;
        }

        $this->form->store();
        $this->success('Nova ordem criada com sucesso!');
        $this->redirect('/orders');
    }



//Chamar a Função Quando a Ordem for Finalizada
//$this->finalizeOrder();
}
