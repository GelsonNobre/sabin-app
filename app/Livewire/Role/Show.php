<?php

namespace App\Livewire\Role;

use App\Models\ACL\{Module, Role};
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Show extends Component
{
    public ?Role $object = null;

    /** @var array<int> */
    public array $permissions = [];

    public bool $modal = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.role.show');
    }

    /** @return Collection<int, Module> */
    #[Computed()]
    public function modules(): Collection
    {
        return Module::query()->with('permissions')->get();
    }

    #[On('role::show')]
    public function load(int $id): void
    {
        $this->authorize('read_roles');

        $this->object = Role::find($id);

        $this->permissions = $this->object?->permissions->pluck('id')->toArray();

        $this->modal = true;
    }
}
