<?php

namespace App\Livewire\Order;

use App\Livewire\Forms\OrderForm;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use App\Models\Patient;
use App\Traits\HandlesAuthorizationFeedback;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
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


    /** @var EloquentCollection<int, Person> */
    public ?EloquentCollection $patientsSearchable = null;

    /** @var EloquentCollection<int, Person> */
    public ?EloquentCollection $nursesSearchable = null;

    public $medications;

    public array $orderStatuses = [];



    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.order.create');
    }


    public function mount(): void
    {
        $this->patients();
        $this->nurses();

        $this->orderStatuses = OrderStatus::all()->map(function ($status) {
            return (object)[
                'id'   => $status->id,
                'name' => $status->name,
            ];
        })->toArray();
    }


    public function nurses(string $value = ''): void
    {
        $this->nursesSearchable = Nurse::query()
            ->where('name', 'like', "%$value%")
            ->take(5)
            ->orderBy('name')
            ->get();
    }

    public function patients(string $value = ''): void
    {
        $this->patientsSearchable = Patient::query()
            ->where('name', 'like', "%$value%")
            ->take(5)
            ->orderBy('name')
            ->get();
    }


    public function submit(): void
    {
        //dd($this->form);
        if (!$this->authorizeWithMessage('write_orders')) {
            return;
        }

        //$this->form->store();
        //$this->success('Nova ordem criada com sucesso!');
        //$this->redirect('/orders');

        try {
            $this->form->store();
            $this->success('Nova ordem criada com sucesso!');
            $this->redirect('/orders');
        } catch (\Exception $e) {
            $this->error($e->getMessage(), timeout: 10000);
        }
    }
}
