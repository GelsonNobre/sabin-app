<?php

namespace App\Livewire\Stock;

use App\Models\StockMovement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    /** @var array|string[] */
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public int $perPage = 20;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.stock.index');
    }

    /**
     * @return LengthAwarePaginator<StockMovement>
     */
    #[Computed]
    public function stockMovements(): LengthAwarePaginator
    {
        return StockMovement::query()
            ->join('medications', 'medications.id', '=', 'stock_movements.medication_id')
            ->select('stock_movements.*', 'medications.name as medication_name', 'medications.producer as medication_producer')
            ->with('medication')
            ->whereRaw('LOWER(medications.name) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }




    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'medication_name', 'label' => 'Nome'],
            ['key' => 'medication_producer', 'label' => 'Fabricante'],
            ['key' => 'batch', 'label' => 'Lote'],
            ['key' => 'quantity', 'label' => 'Quantidade'],
            ['key' => 'type', 'label' => 'Tipo'],
        ];
    }

    public function delete(int $id): void
    {
        $this->dispatch('stock::delete', id: $id);
    }
}
