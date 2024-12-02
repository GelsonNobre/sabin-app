<?php

namespace App\Livewire\User;

use App\Livewire\Forms\UserForm;
use App\Models\ACL\Role;
use App\Models\User;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public UserForm $form;

    public bool $modal = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.user.edit');
    }

    /** @return Collection<int, Role> */
    #[Computed()]
    public function roles()
    {
        return Role::select('id', 'name')->get();
    }

    #[On('user::edit')]
    public function load(int $id): void
    {
        $this->authorize('write_users');

        $user = User::find($id);
        $this->form->setObject($user);

        $this->modal = true;
    }

    public function submit(): void
    {
        $this->authorize('write_users');

        $this->form->store();

        $this->success('Usuário atualizado com sucesso!');
        $this->dispatch('user::updated');
        $this->resetExcept('form');
    }
}
