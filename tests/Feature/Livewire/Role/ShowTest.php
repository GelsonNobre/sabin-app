<?php

use App\Livewire\Role\{Index, Show};
use App\Models\ACL\{Permission, Role};
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $user = User::factory()->support()->create();
    actingAs($user);
});

it('renders successfully', function () {
    Livewire::test(Show::class)
        ->assertStatus(200);
});

it('exists in the index component', function () {
    Livewire::test(\App\Livewire\Role\Index::class)->assertSeeLivewire(Show::class);
});

it('should be able to show all the details of role in the component', function () {
    $role       = Role::factory()->create();
    $permission = Permission::factory()->create();
    $role->permissions()->attach($permission->id);

    Livewire::test(Show::class)
        ->call('load', $role->id)
        ->assertSet('object.id', $role->id)
        ->assertSet('modal', true)
        ->assertSee($role->name)
        ->assertSee($permission->module->name)
        ->assertSee($permission->name);

});

it('should open the modal when the event is dispatched', function () {
    $role       = Role::factory()->create();
    $permission = Permission::factory()->create();
    $role->permissions()->attach($permission->id);

    Livewire::test(Index::class)
        ->call('show', $role->id)
        ->assertDispatched('role::show', id: $role->id);
});

it('making sure that the method load has the attribute On', function () {
    $reflection = new ReflectionClass(new Show());
    $attributes = $reflection->getMethod('load')->getAttributes();
    expect($attributes)->toHaveCount(1);

    $attribute = $attributes[0];
    expect($attribute)->getName()->toBe('Livewire\Attributes\On')
        ->and($attribute)->getArguments()->toHaveCount(1);

    $argument = $attribute->getArguments()[0];
    expect($argument)->toBe('role::show');
});
