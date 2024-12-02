<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\{On, Validate};
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public ?User $user;

    public bool $modal = false;

    #[Validate(['required', 'confirmed'], as: 'deleção')]
    public string $deletion = '';

    public ?string $deletion_confirmation = null;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.user.delete');
    }

    #[On('user::deletion')]
    public function openConfirmationFor(int $userId): void
    {
        $this->clearValidation();
        $this->user     = User::select('id', 'name', 'email')->findOrFail($userId);
        $this->deletion = $this->user->email;
        $this->modal    = true;
    }

    public function destroy(): void
    {
        $this->authorize('write_users');
        $this->validate();

        if($this->user->is(auth()->user())) {
            $this->addError('deletion', 'Não é possível deletar o usuário logado!');

            return;
        }

        $this->user->delete();
        $this->user->deleted_by = auth()->user()->id;
        $this->user->save();

        $this->success('Usuário deletado com sucesso!');
        $this->dispatch('user::deleted');
        $this->reset();
    }
}
