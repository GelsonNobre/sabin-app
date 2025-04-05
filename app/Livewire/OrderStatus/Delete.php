<?php

namespace App\Livewire\OrderStatus;

use App\Models\Order;
use App\Models\OrderStatus;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{

    use Toast;

    public ?OrderStatus $orderStatus;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.order-status.delete');
    }


    #[On('orderStatus::delete')]
    public function openConfirmationFor(int $id): void
    {
        $this->orderStatus = OrderStatus::find($id);
        $this->modal      = true;
    }

    public function destroy(): void
    {
        $this->authorize('write_orderStatus');

        $this->orderStatus->delete();
        $this->success('Status excluido com sucesso!');
        $this->dispatch('orderStatus::deleted');
        $this->reset();
        $this->redirect('/order-status');
    }

}
