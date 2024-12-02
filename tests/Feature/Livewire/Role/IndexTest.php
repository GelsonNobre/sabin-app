<?php

use App\Livewire\Role\Index;
use App\Models\ACL\Role;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('renders successfully', function () {
    Livewire::test(Index::class)
        ->assertStatus(200);
});

it('should be able to access route roles', function () {
    $user = User::factory()->support()->create();
    actingAs($user);

    get(route('roles'))->assertOk();
});

it('should be able to create a livewire component to list all roles in the page', function () {
    $user = User::factory()->support()->create();
    actingAs($user);

    $roles = Role::factory()->count(5)->create();

    $livewire = Livewire::test(Index::class);
    $livewire->assertSet('roles', function ($roles) {
        expect($roles)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(6);

        return true;
    });

    foreach ($roles as $role) {
        $livewire->assertSee($role->name);
    }
});

it('should be able to filter by name', function () {
    $user = User::factory()->support()->create();
    actingAs($user);

    Role::factory()->create(['name' => 'Usuário']);

    Livewire::test(Index::class)
        ->assertSet('roles', function ($roles) {
            expect($roles)->toHaveCount(2);

            return true;
        })->set('search', 'usuário')
    ->assertSet('roles', function ($roles) {
        expect($roles)->toHaveCount(1)->first()->name->toBe('Usuário');

        return true;
    });
});
