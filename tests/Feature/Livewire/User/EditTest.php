<?php

use App\Livewire\User\Edit;
use App\Models\ACL\Role;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas};

beforeEach(function () {
    // Artisan::call('migrate:fresh');

    // $user = User::find(1);
    // actingAs($user);
    $user = User::factory()->support()->create();
    actingAs($user);

    $this->user = User::factory()->create();
});

it('renders successfully', function () {
    Livewire::test(Edit::class)
        ->assertStatus(200);
});

it('exists in the index component', function () {
    Livewire::test(\App\Livewire\User\Index::class)->assertSeeLivewire(Edit::class);
});

it('should be able to update a user', function () {
    $first_role  = Role::factory()->create();
    $second_role = Role::factory()->create();

    Livewire::test(Edit::class)
        ->call('load', $this->user->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john.doe@example.com')
        ->set('form.email_confirmation', 'john.doe@example.com')
        ->set('form.password', 'password')
        ->set('form.password_confirmation', 'password')
        ->set('form.selectedRoles', [$first_role->id])
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('user::updated');

    // password may be empty on update
    Livewire::test(Edit::class)
        ->call('load', $this->user->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john.doe@example.com')
        ->set('form.email_confirmation', 'john.doe@example.com')
//        ->set('form.password', '')
//        ->set('form.password_confirmation', '')
        ->set('form.selectedRoles', [$first_role->id, $second_role->id])
        ->call('submit')
        ->assertHasNoErrors()
        ->assertDispatched('user::updated');

    assertDatabaseHas('users', [
        'name'  => 'John Doe',
        'email' => 'john.doe@example.com',
    ]);

    assertDatabaseHas('role_user', [
        'user_id' => $this->user->id,
        'role_id' => $first_role->id,
    ]);

    assertDatabaseHas('role_user', [
        'user_id' => $this->user->id,
        'role_id' => $second_role->id,
    ]);

    assertDatabaseCount('users', 2);
});

test('name validation rules', function ($f) {
    $livewire = Livewire::test(Edit::class)
        ->call('load', $this->user->id)
        ->set($f->field, $f->value);

    $livewire->call('submit')
        ->assertHasErrors([$f->field => $f->rule]);
})->with([
    'name::required' => (object) ['field' => 'form.name', 'value' => '', 'rule' => 'required'],
    'name::max'      => (object) ['field' => 'form.name', 'value' => str_repeat('*', 256), 'rule' => 'max'],
]);

test('password validation rules', function ($f) {
    $livewire = Livewire::test(Edit::class)
        ->call('load', $this->user->id)
        ->set($f->field, $f->value);

    if($f->rule != 'confirmed') {
        $livewire->set('form.password_confirmation', $f->value);
    }

    if($f->rule == 'nullable') {
        $livewire->call('submit')
            ->assertHasNoErrors($f->field);
    } else {
        if ($f->rule == 'min') {
            $livewire->call('submit')
                ->assertHasErrors($f->field);
        } else {
            $livewire->call('submit')
                ->assertHasErrors([$f->field => $f->rule]);
        }
    }
})->with([
    'password::nullable'  => (object) ['field' => 'form.password', 'value' => '', 'rule' => 'nullable'],
    'password::max'       => (object) ['field' => 'form.password', 'value' => str_repeat('*', 256), 'rule' => 'max'],
    'password::confirmed' => (object) ['field' => 'form.password', 'value' => 'password', 'rule' => 'confirmed'],
    'password::min'       => (object) ['field' => 'form.password', 'value' => '***', 'rule' => 'min'],
]);

describe('email validation rules', function () {
    test('email should be required', function () {
        Livewire::test(Edit::class)
            ->call('load', $this->user->id)
            ->set('form.email', '')
            ->call('submit')
            ->assertHasErrors(['form.email' => 'required']);
    });

    test('email should be valid', function () {
        Livewire::test(Edit::class)
            ->call('load', $this->user->id)
            ->set('form.email', 'not-an-email')
            ->set('form.email_confirmation', 'john.doe@example.com')
            ->call('submit')
            ->assertHasErrors(['form.email' => 'email']);
    });

    test('email should have a max 255 characters', function () {
        Livewire::test(Edit::class)
            ->call('load', $this->user->id)
            ->set('form.email', str_repeat('*' . '@doe.com', 256))
            ->call('submit')
            ->assertHasErrors(['form.email' => 'max:255']);
    });

    test('email should be confirmed', function () {
        Livewire::test(Edit::class)
            ->call('load', $this->user->id)
            ->set('form.email', 'john.doe@example.com')
            ->set('form.email_confirmation', '')
            ->call('submit')
            ->assertHasErrors(['form.email' => 'confirmed']);
    });

    test('email should be unique', function () {
        $user = User::factory()->create(['email' => 'john.doe@example.com']);
        Livewire::test(Edit::class)
            ->call('load', $this->user->id)
            ->set('form.email', 'john.doe@example.com')
            ->set('form.email_confirmation', 'john.doe@example.com')
            ->call('submit')
            ->assertHasErrors(['form.email' => 'unique']);

        Livewire::test(Edit::class)
            ->call('load', $user->id)
            ->set('form.email', 'john.doe@example.com')
            ->set('form.email_confirmation', 'john.doe@example.com')
            ->call('submit')
            ->assertHasNoErrors(['form.email' => 'unique']);
    });
});

describe('roles validation rules', function () {
    test('roles should be required', function () {
        Livewire::test(Edit::class)
            ->call('load', $this->user->id)
            ->set('form.selectedRoles', [])
            ->call('submit')
            ->assertHasErrors(['form.selectedRoles' => 'required']);
    });
});
