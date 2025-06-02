<?php

namespace App\Livewire\Stock;

use App\Livewire\Forms\StockForm;
use App\Models\StockMovement;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;

class Delete extends Component
{

    use Toast;

    public ?StockMovement $stock = null;

    public bool $modal = false;
    public function render()
    {
        return view('livewire.stock.delete');
    }

    #[On('stock::delete')]
    public function openConfirmationFor(int $id): void
    {
        $this->stock = StockMovement::find($id);
        $this->modal      = true;
    }

    public function destroy(): void
    {
        $this->authorize('write_stocks');

        $this->stock->delete();
        $this->success('Item do estoque excluido com sucesso!');
        $this->dispatch('stock::deleted');
        $this->reset();
        $this->redirect('/stock');
    }
}
