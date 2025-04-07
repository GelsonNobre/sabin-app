<?php

namespace App\Livewire\Nurse;

use App\Models\Nurse;
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

    public ?string $search = null;

    /** @var array|string[] */
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public int $perPage = 20;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.nurse.index');
    }

    /**
     * @return LengthAwarePaginator<Nurse>
     */
    #[Computed]
    public function nurses(): LengthAwarePaginator
    {
        return Nurse::query()
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
            ['key' => 'coren', 'label' => 'COREN'],
            ['key' => 'specialty', 'label' => 'Especialidade'],
            ['key' => 'shift', 'label' => 'Turno'],
        ];
    }

    public function delete(int $id): void
    {
        $this->dispatch('nurse::delete', id: $id);
    }
}