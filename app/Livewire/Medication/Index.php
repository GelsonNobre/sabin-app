<?php

namespace App\Livewire\Medication;

use App\Models\Medication;
use App\Traits\HandlesAuthorizationFeedback;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class Index extends Component
{
    use WithPagination;

    use HandlesAuthorizationFeedback;
    public bool $showAuthorizationModal = false;

    public ?string $search = null;

    /** @var array|string[] */
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public int $perPage = 20;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.medication.index');
    }

    public function mount(): void
    {
        if (!$this->authorizeWithMessage('read_medications')) {
            return;
        }
    }
    /**
     * @return LengthAwarePaginator<Medication>
     */
    #[Computed]
    public function medications(): LengthAwarePaginator
    {
        // return Medication::query()
        //     ->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($this->search) . '%')
        //     ->orderBy(...array_values($this->sortBy))
        //     ->paginate($this->perPage);
        return Medication::query()
            ->withSum('stockMovements as stock_quantity', 'quantity')
            ->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($this->search) . '%')
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    /**
     * Table headers
     * @return array<int, array<string,string|bool>>
     */
    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'producer', 'label' => 'Fabricante'],
            ['key' => 'age_type', 'label' => 'Faixa etária'],
            ['key' => 'stock_quantity', 'label' => 'Quantidade em Estoque'],
        ];
    }


    public function delete(int $id): void
    {
        $this->dispatch('medication::delete', id: $id);
    }
}
