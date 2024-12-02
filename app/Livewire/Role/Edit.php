<?php

namespace App\Livewire\Role;

use App\Livewire\Forms\RoleForm;
use App\Models\ACL\{Module, Role};
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public RoleForm $form;

    public bool $modal = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.role.edit');
    }

    /** @return Collection<int, Module> */
    #[Computed()]
    public function modules(): Collection
    {
        return Module::query()->with('permissions')->get();
    }

    #[On('role::edit')]
    public function load(int $id): void
    {
        $this->authorize('write_roles');

        $role = Role::find($id);
        $this->form->setObject($role);

        $this->modal = true;
    }

    public function submit(): void
    {
        $this->authorize('write_roles');

        $this->form->store();

        $this->success('Usuário atualizado com sucesso!');
        $this->dispatch('role::updated');
        $this->resetExcept('form');
    }
}
