<?php

namespace App\Livewire\User;

use App\Livewire\Forms\UserForm;
use App\Models\ACL\Role;
use Illuminate\Contracts\Foundation\Application as ContractsApplication;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public UserForm $form;

    public bool $modal = false;

    public function render(): Factory|Application|View|ContractsApplication
    {
        return view('livewire.user.create');
    }

    #[On('user::create')]
    public function load(): void
    {
        $this->authorize('write_users');
        $this->modal = true;
    }

    /** @return Collection<int, Role> */
    #[Computed]
    public function roles()
    {
        return Role::select('id', 'name')->get();
    }

    public function submit(): void
    {
        $this->authorize('write_users');
        $this->form->store();

        $this->success('Usuário criado com sucesso!');
        $this->dispatch('user::created');
        $this->resetExcept('form');
    }
}
