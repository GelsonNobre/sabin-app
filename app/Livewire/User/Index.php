<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\{Attributes\On, Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public bool $search_trashed = false;

    /** @var array|string[] */
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public int $perPage = 5;

    #[On('user::created')]
    #[On('user::updated')]
    #[On('user::deleted')]
    #[On('user::restored')]
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.user.index');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * @return LengthAwarePaginator<User>
     */
    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->when($this->search, function (Builder $query) {
                $query->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($this->search) . '%')
                    ->orWhere(DB::raw('LOWER(email)'), 'like', '%' . strtolower($this->search) . '%');
            })
            ->when($this->search_trashed, function (Builder $query) {
                $query->onlyTrashed();
            })
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
            ['key' => 'email', 'label' => 'E-mail', 'sortable' => false],
        ];
    }

    public function create(): void
    {
        $this->dispatch('user::create')->to('user.create');
    }

    public function edit(int $id): void
    {
        $this->dispatch('user::edit', $id)->to('user.edit');
    }

    public function delete(string $id): void
    {
        $this->dispatch('user::deletion', userId: $id)->to('user.delete');
    }

    public function restore(string $id): void
    {
        $this->dispatch('user::restoration', userId: $id)->to('user.restore');
    }

    public function show(int $id): void
    {
        $this->dispatch('user::show', id: $id);
    }
}
