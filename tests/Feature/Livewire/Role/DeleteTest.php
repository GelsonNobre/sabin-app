<?php

use App\Livewire\Role\Delete;
use App\Models\ACL\Role;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseMissing};

beforeEach(function () {
    $user = User::factory()->support()->create();
    actingAs($user);
});

it('renders successfully', function () {
    Livewire::test(Delete::class)
        ->assertStatus(200);
});

it('exists in the index component', function () {
    Livewire::test(\App\Livewire\Role\Index::class)->assertSeeLivewire(Delete::class);
});

it('should be able to delete role', function () {
    $forDelete = Role::factory()->create(['name' => 'Usuários']);

    Livewire::test(Delete::class, ['role' => $forDelete])
        ->set('deletion', $forDelete->name)
        ->set('deletion_confirmation', 'Usuários')
        ->call('destroy')
        ->assertDispatched('role::deleted');

    assertDatabaseMissing('roles', ['id' => $forDelete->id]);
});

it('should have a confirmation before deletion', function () {
    $forDelete = Role::factory()->create();

    Livewire::test(Delete::class, ['role' => $forDelete])
        ->call('destroy')
        ->assertHasErrors('deletion', 'confirmed')
        ->assertNotDispatched('role::deleted');

    assertDatabaseHas('roles', ['id' => $forDelete->id]);
});
