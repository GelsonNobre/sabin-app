<?php

namespace App\Livewire\Nurse;

use App\Models\Nurse;
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
        return view('livewire.nurse.index');
    }

    public function mount(): void
    {
        if (!$this->authorizeWithMessage('read_nurses')) {
            return;
        }
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
            ['key' => 'birth', 'label' => 'Data de Nascimento'],
            ['key' => 'phone', 'label' => 'Telefone'],
            ['key' => 'email', 'label' => 'email'],
            ['key' => 'coren', 'label' => 'COREN'],
        ];
    }


    public function create(): void
    {
        $this->dispatch('nurse::create');
    }

    public function edit(int $id): void
    {
        $this->dispatch('nurse::edit', id: $id);
    }

    public function delete(int $id): void
    {
        $this->dispatch('nurse::delete', id: $id);
    }

    public function show(int $id): void
    {
        $this->dispatch('nurse::show', id: $id);
    }
}
