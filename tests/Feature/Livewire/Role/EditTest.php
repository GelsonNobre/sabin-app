<?php

use App\Livewire\Role\Edit;
use App\Models\ACL\{Permission, Role};
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas};

beforeEach(function () {
    $user = User::factory()->support()->create();
    actingAs($user);
});

it('renders successfully', function () {
    Livewire::test(Edit::class)
        ->assertStatus(200);
});

it('exists in the index component', function () {
    Livewire::test(\App\Livewire\Role\Index::class)->assertSeeLivewire(Edit::class);
});

it('should be able to update a role', function () {
    $permission = Permission::factory()->create();
    $role       = Role::factory()->create();
    $role->permissions()->attach($permission->id);

    /** @var \App\Models\ACL\Permission $other_permission */
    $other_permission = Permission::factory()->create();

    Livewire::test(Edit::class)
        ->call('load', $role->id)
        ->set('form.name', $role->name)
        ->set('form.permissions', [$permission->id => true, $other_permission->id = true])
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('role::updated');

    assertDatabaseHas('roles', [
        'name' => $role->name,
    ]);

    assertDatabaseHas('permission_role', [
        'role_id'       => $role->id,
        'permission_id' => $permission->id,
    ]);

    assertDatabaseHas('permission_role', [
        'role_id'       => $role->id,
        'permission_id' => $other_permission->id,
    ]);

    assertDatabaseCount('roles', 2);
});

it('validation rules', function ($f) {
    $user = User::factory()->support()->create();
    actingAs($user);

    if ($f->rule == 'unique') {
        Role::factory()->create(['name' => $f->value]);
    }

    $livewire = Livewire::test(Edit::class)
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
