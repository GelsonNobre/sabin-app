<?php

namespace App\Livewire\OrderStatus;

use App\Models\OrderStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    /** @var array<string,string> */
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public int $perPage = 20;

    public function render(): View|Application|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.order-status.index');
    }

    /**
     * @return LengthAwarePaginator<OrderStatus>
     */
    #[Computed]
    public function statuses(): LengthAwarePaginator
    {
        return OrderStatus::query()
            ->when($this->search, fn($query) =>
                $query->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($this->search) . '%')
            )
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    /**
     * Table headers
     * @return array<int, array<string,string>>
     */
    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome do Status'],
        ];
    }

    public function create(): void
    {
        $this->dispatch('orderStatus::create');
    }


    public function delete(int $id): void
    {
        $this->dispatch('orderStatus::delete', id: $id);
    }


    public function edit(int $id): void
    {
        $this->dispatch('orderStatus::edit', id: $id);
    }
}

