<?php

use App\Livewire\Auth\Login;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Login::class)
        ->assertOk();
});

it('should be able to login', function () {
    $user = \App\Models\User::factory()->create([
        'email'    => 'john@example.com',
        'password' => 'password',
    ]);

    Livewire::test(Login::class)
        ->set('email', 'john@example.com')
        ->set('password', 'password')
        ->call('tryToLogin')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);
});

it('should make sure to inform  the user as error when email and password doesnt work', function () {
    Livewire::test(Login::class)
        ->set('email', 'john@example.com')
        ->set('password', 'password')
        ->call('tryToLogin')
        ->assertHasErrors(['invalidCredentials'])
        ->assertSee(trans('auth.failed'));
});

it('should make sure that the rate limiting is blocking after 5 attempts', function () {
    $user = \App\Models\User::factory()->create();

    for ($i = 0; $i < 5; $i++) {
        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('tryToLogin')
            ->assertHasErrors(['invalidCredentials']);
    }

    Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('tryToLogin')
        ->assertHasErrors(['rateLimiter']);
});
