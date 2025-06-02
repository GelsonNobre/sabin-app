<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public ?Order $order = null;

    public bool $modal = false;
    public function render()
    {
        return view('livewire.order.delete');
    }

    #[On('order::delete')]
    public function open(int $id): void
    {
        $this->order = Order::findOrFail($id);
        $this->modal = true;
    }

    public function destroy(): void
    {
        $this->authorize('write_orders');

        $this->order->delete();
        $this->success('Ordem de serviço excluida com sucesso!');
        $this->dispatch('order::deleted');
        $this->reset();
        $this->redirect('/orders');
    }
}
