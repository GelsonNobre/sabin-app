<?php

use App\Livewire\Role\Create;
use App\Models\ACL\{Permission, Role};
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas};

it('renders successfully', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

it('exists in the index component', function () {
    Livewire::test(\App\Livewire\Role\Index::class)->assertSeeLivewire(Create::class);
});

it('should be able to create a new role', function () {
    $user = User::factory()->support()->create();
    actingAs($user);

    $permission = Permission::factory()->create();

    Livewire::test(Create::class)
        ->set('form.name', 'Usuário')
        ->set('form.permissions', [$permission->id => true])
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('role::created');

    assertDatabaseHas('roles', [
        'name' => 'Usuário',
    ]);

    assertDatabaseHas('permission_role', [
        'permission_id' => $permission->id,
    ]);

    assertDatabaseCount('roles', 2);

});

it('validation rules', function ($f) {
    /** @var User $user */
    $user = User::factory()->support()->create();
    actingAs($user);

    if ($f->rule == 'unique') {
        Role::factory()->create(['name' => $f->value]);
    }

    $livewire = Livewire::test(Create::class)
        ->set($f->field, $f->value);

    $livewire->call('submit')
        ->assertHasErrors([$f->field => $f->rule]);
})->with([
    'name::required'        => (object) ['field' => 'form.name', 'value' => '', 'rule' => 'required'],
    'name::min'             => (object) ['field' => 'form.name', 'value' => 'a', 'rule' => 'min'],
    'name::max'             => (object) ['field' => 'form.name', 'value' => str_repeat('a', 256), 'rule' => 'max'],
    'name::unique'          => (object) ['field' => 'form.name', 'value' => 'new role', 'rule' => 'unique'],
    'permissions::required' => (object) ['field' => 'form.permissions', 'value' => [], 'rule' => 'required'],
]);
