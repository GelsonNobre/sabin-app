<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public ?User $object = null;

    public bool $modal = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.user.show');
    }

    #[On('user::show')]
    public function load(int $id): void
    {
        $this->authorize('read_users');

        $this->object = User::withTrashed()->with(['roles'])->find($id);
        $this->modal  = true;
    }
}
