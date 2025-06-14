<?php

namespace App\Livewire\Order;

use Livewire\Component;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use App\Livewire\Forms\OrderForm;
use App\Models\{Person, Nurse, Order, OrderStatus, Patient};
use App\Traits\HandlesAuthorizationFeedback;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    use HandlesAuthorizationFeedback;

    public OrderForm $form;

    public bool $showAuthorizationModal = false;

    public ?Order $object = null;

    /** @var EloquentCollection<int, Person> */
    public ?EloquentCollection $patientsSearchable = null;

    /** @var EloquentCollection<int, Person> */
    public ?EloquentCollection $nursesSearchable = null;

    public $medications;

    public array $orderStatuses = [];
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.order.edit');
    }

    public function mount(int $id): void
    {
        $order = Order::find($id);
        $this->object = Order::with('medications')->findOrFail($id);
        $this->form->setObject($order);

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
