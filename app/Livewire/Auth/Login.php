<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public ?string $email = null;

    public ?string $password = null;

    #[Layout('components.layouts.guest')]
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.auth.login');
    }

    public function tryToLogin(): void
    {
        if ($this->ensureIsNotRateLimiting()) {
            return;
        }

        if(!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            $this->addError('invalidCredentials', trans('auth.failed'));

            return;
        }

        $this->redirect(route('dashboard'));
    }

    /**
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::transliterate(strtolower($this->email) . '|' . request()->ip());
    }

    /**
     * @return bool
     */
    public function ensureIsNotRateLimiting(): bool
    {
        if(RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            $this->addError('rateLimiter', trans('auth.throttle', [
                'seconds' => RateLimiter::availableIn($this->throttleKey()),
            ]));

            return true;
        }

        return false;

    }
}
