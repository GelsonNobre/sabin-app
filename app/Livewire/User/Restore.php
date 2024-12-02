<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\{On, Validate};
use Livewire\Component;
use Mary\Traits\Toast;

class Restore extends Component
{
    use Toast;

    public ?User $user;

    public bool $modal = false;

    #[Validate(['required', 'confirmed'], as: 'restauração')]
    public string $restoration = '';

    public ?string $restoration_confirmation = null;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.user.restore');
    }

    #[On('user::restoration')]
    public function openConfirmationFor(int $userId): void
    {
        $this->clearValidation();
        $this->user        = User::select('id', 'name', 'email')->withTrashed()->findOrFail($userId);
        $this->restoration = $this->user->email;
        $this->modal       = true;
    }

    public function restore(): void
    {
        $this->authorize('write_users');

        $this->validate();

        if($this->user->is(auth()->user())) {
            $this->addError('restoration', 'Não é possível restaurar o usuário logado!');

            return;
        }

        $this->user->restore();
        $this->user->restored_at = now();
        $this->user->restored_by = auth()->user()->id;
        $this->user->save();

        $this->success('Usuário restaurado com sucesso!');
        $this->dispatch('user::restored');
        $this->reset();
    }
}
