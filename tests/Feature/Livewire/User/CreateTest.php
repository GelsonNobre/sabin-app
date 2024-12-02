<?php

use App\Livewire\User\Create;
use App\Models\ACL\Role;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas};

it('renders successfully', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

it('should be able to create a new user', function () {
    $user = User::factory()->support()->create();
    actingAs($user);

    $role = Role::factory()->create();

    Livewire::test(Create::class)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'johnd@example.com')
        ->set('form.email_confirmation', 'johnd@example.com')
        ->set('form.password', 'password')
        ->set('form.password_confirmation', 'password')
        ->set('form.selectedRoles', [$role->id])
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('user::created');

    assertDatabaseHas('users', [
        'name'  => 'John Doe',
        'email' => 'johnd@example.com',
    ]);

    assertDatabaseCount('users', 2);
});

test('validation rules', function ($f) {
    $user = User::factory()->support()->create();
    actingAs($user);

    $livewire = Livewire::test(Create::class)
        ->set($f->field, $f->value);

    if($f->rule == 'unique') {
        User::factory()->create(['email' => $f->value]);
        $livewire->set('form.email_confirmation', $f->value);
    }

    if($f->field == 'form.password' && $f->rule == 'min') {
        $livewire->call('submit')
            ->assertHasErrors($f->field);
    } else {
        $livewire->call('submit')
            ->assertHasErrors([$f->field => $f->rule]);
    }
})->with([
    'name::required'          => (object) ['field' => 'form.name', 'value' => '', 'rule' => 'required'],
    'name::max'               => (object) ['field' => 'form.name', 'value' => str_repeat('*', 256), 'rule' => 'max'],
    'email::required'         => (object) ['field' => 'form.email', 'value' => '', 'rule' => 'required'],
    'email::email'            => (object) ['field' => 'form.email', 'value' => 'not-an-email', 'rule' => 'email'],
    'email::max'              => (object) ['field' => 'form.email', 'value' => str_repeat('*' . '@doe.com', 256), 'rule' => 'max'],
    'email::confirmed'        => (object) ['field' => 'form.email', 'value' => 'john.doe1@example.com', 'rule' => 'confirmed'],
    'email::unique'           => (object) ['field' => 'form.email', 'value' => 'john.doe@example.com', 'rule' => 'unique'],
    'password::required'      => (object) ['field' => 'form.password', 'value' => '', 'rule' => 'required'],
    'password::max'           => (object) ['field' => 'form.password', 'value' => str_repeat('*', 256), 'rule' => 'max'],
    'password::mim'           => (object) ['field' => 'form.password', 'value' => '***', 'rule' => 'min'],
    'password::confirmed'     => (object) ['field' => 'form.password', 'value' => 'password', 'rule' => 'confirmed'],
    'selectedRoles::required' => (object) ['field' => 'form.selectedRoles', 'value' => [], 'rule' => 'required'],
]);
