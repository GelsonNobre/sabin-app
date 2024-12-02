<?php

namespace App\Livewire\Role;

use App\Livewire\Forms\RoleForm;
use App\Models\ACL\Module;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public RoleForm $form;

    public bool $modal = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.role.create');
    }

    #[On('role::create')]
    public function load(): void
    {
        $this->authorize('write_roles');
        $this->modal = true;
    }

    /** @return Collection<int, Module> */
    #[Computed]
    public function modules()
    {
        return Module::query()->with('permissions')->get();
    }

    public function submit(): void
    {
        $this->authorize('write_roles');
        $this->form->store();

        $this->success('Perfil criado com sucesso!');
        $this->redirect('/roles');
        $this->dispatch('role::created');
        $this->resetExcept('form');
    }
}
