<?php

namespace App\Livewire\Role;

use App\Models\ACL\Role;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\{On, Validate};
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public ?Role $role;

    public bool $modal = false;

    #[Validate(['required', 'confirmed'], as: 'deleção')]
    public string $deletion = '';

    public ?string $deletion_confirmation = null;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.role.delete');
    }

    #[On('role::deletion')]
    public function openConfirmationFor(int $id): void
    {
        $this->clearValidation();
        $this->role     = Role::select('id', 'name')->findOrFail($id);
        $this->deletion = $this->role->name;
        $this->modal    = true;
    }

    public function destroy(): void
    {
        $this->authorize('write_roles');
        $this->validate();

        if($this->role->users()->exists()) {
            $this->addError('deletion', 'Não é possível deletar um perfil que contém usuários!');

            return;
        }

        $this->role->delete();

        $this->success('Perfil deletado com sucesso!');
        $this->dispatch('role::deleted');
        $this->reset();
    }
}
