<?php

use App\Livewire\User\Show;
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

it('should be able to show all the details of user in the component', function () {
    $user = \App\Models\User::factory()->deleted()->create();
    $role = \App\Models\ACL\Role::factory()->create();
    $user->roles()->attach($role->id);

    Livewire::test(Show::class)
        ->call('load', $user->id)
        ->assertSet('object.id', $user->id)
        ->assertSet('modal', true)
        ->assertSee($user->name)
        ->assertSee($user->email)
        ->assertSee($role->name)
        ->assertSee($user->created_at->format('d/m/Y H:i'))
        ->assertSee($user->updated_at->format('d/m/Y H:i'))
        ->assertSee($user->deleted_at->format('d/m/Y H:i'))
        ->assertSee($user->deletedBy->name);

});

it('should open the modal when the event is dispatched', function () {
    $user = \App\Models\User::factory()->deleted()->create();

    Livewire::test(\App\Livewire\User\Index::class)
        ->call('show', $user->id)
        ->assertDispatched('user::show', id: $user->id);
});

it('making sure that the method load has the attribute On', function () {
    $reflection = new ReflectionClass(new Show());
    $attributes = $reflection->getMethod('load')->getAttributes();
    expect($attributes)->toHaveCount(1);

    $attribute = $attributes[0];
    expect($attribute)->getName()->toBe('Livewire\Attributes\On')
        ->and($attribute)->getArguments()->toHaveCount(1);

    $argument = $attribute->getArguments()[0];
    expect($argument)->toBe('user::show');
});
