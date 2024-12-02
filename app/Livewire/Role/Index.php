<?php

namespace App\Livewire\Role;

use App\Models\ACL\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\{Computed, On};
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    #[On('role::created')]
    #[On('role::updated')]
    #[On('role::deleted')]
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.role.index');
    }

    /**
     * @return LengthAwarePaginator<Role>
     */
    #[Computed]
    public function roles(): LengthAwarePaginator
    {
        if ($this->search) {
            $search = strtolower($this->search);

            return Role::where('name', 'like', "%{$search}%")
                ->paginate(10);
        }

        return Role::paginate(10);
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
        ];
    }

    public function create(): void
    {
        $this->dispatch('role::create')->to('role.create');
    }

    public function edit(int $id): void
    {
        $this->dispatch('role::edit', $id)->to('role.edit');
    }

    public function delete(int $id): void
    {
        $this->dispatch('role::deletion', $id)->to('role.delete');
    }

    public function show(int $id): void
    {
        $this->dispatch('role::show', id: $id)->to('role.show');
    }
}
