<?php

use App\Livewire\User\Delete;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted};

it('renders successfully', function () {
    Livewire::test(Delete::class)
        ->assertStatus(200);
});

it('should be able to delete user', function () {
    $user = User::factory()->support()->create();
    actingAs($user);

    $forDelete = \App\Models\User::factory()->create(['email' => 'john@doe.com']);

    Livewire::test(Delete::class, ['user' => $forDelete])
        ->set('deletion', $forDelete->email)
        ->set('deletion_confirmation', 'john@doe.com')
        ->call('destroy')
        ->assertDispatched('user::deleted');

    assertSoftDeleted('users', ['id' => $forDelete->id]);
    $forDelete->refresh();
    expect($forDelete)->deletedBy->id->toBe($user->id);
});

it('should have a confirmation before deletion', function () {
    $user = User::factory()->support()->create();
    actingAs($user);

    $forDelete = \App\Models\User::factory()->create(['email' => 'john@doe.com']);

    Livewire::test(Delete::class, ['user' => $forDelete])
        ->call('destroy')
        ->assertHasErrors('deletion', 'confirmed')
        ->assertNotDispatched('user::deleted');

    assertNotSoftDeleted('users', ['id' => $forDelete->id]);
});
