<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Logout extends Component
{
    public ?string $class = null;

    public function render(): string
    {
        return <<<'HTML'
            <a wire:click="logout" class="{{ $this->class }}">
                <x-icon name="o-power" />
                <span>Sair</span>
            </a>
        HTML;
    }
    public function logout(): void
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('login'));
    }
}
