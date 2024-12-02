<?php

use App\Livewire\User\Restore;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted};

beforeEach(function () {
    $this->user = User::factory()->support()->create();
    actingAs($this->user);
});

it('renders successfully', function () {
    Livewire::test(Restore::class)
        ->assertStatus(200);
});

it('should be able to delete user', function () {
    $forRestore = User::factory()->create(['email' => 'john@doe.com', 'deleted_at' => now()]);

    Livewire::test(Restore::class, ['user' => $forRestore])
        ->set('restoration', $forRestore->email)
        ->set('restoration_confirmation', 'john@doe.com')
        ->call('restore')
        ->assertDispatched('user::restored');

    assertNotSoftDeleted('users', ['id' => $forRestore->id]);

    $forRestore->refresh();
    expect($forRestore)->restored_at->not->toBeNull()->restoredBy->id->toBe($this->user->id);
});

it('should have a confirmation before restoration', function () {
    $forRestore = \App\Models\User::factory()->create(['email' => 'john@doe.com', 'deleted_at' => now()]);

    Livewire::test(Restore::class, ['user' => $forRestore])
        ->set('restoration', $forRestore->email)
        ->call('restore')
        ->assertHasErrors('restoration', 'confirmed')
        ->assertNotDispatched('user::restored');

    assertSoftDeleted('users', ['id' => $forRestore->id]);
});
