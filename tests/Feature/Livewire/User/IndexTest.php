<?php

use App\Livewire\User\Index;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('renders successfully', function () {
    Livewire::test(Index::class)
        ->assertStatus(200);
});

it('should be able to access route users', function () {
    $user = User::factory()->support()->create();
    actingAs($user);

    get(route('users'))
    ->assertOk();
});

test('let´s create a livewire component to list all users in the page', function () {
    $users = User::factory()->count(5)->create();

    $livewire = Livewire::test(Index::class);
    $livewire->assertSet('users', function ($users) {
        expect($users)
            ->toBeInstanceOf(LengthAwarePaginator::class)
            ->toHaveCount(5);

        return true;
    });

    foreach($users as $user) {
        $livewire->assertSee($user->name);
    }
});

test('check the table format', function () {
    Livewire::test(Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'email', 'label' => 'E-mail', 'sortable' => false],
        ]);
});

it('should be able to filter by name and email', function () {
    User::factory()->create(['name' => 'jon Doe', 'email' => 'manager@doe.com']);
    User::factory()->create(['name' => 'Jane Doe', 'email' => 'owner@doe.com']);

    Livewire::test(Index::class)
        ->assertSet('users', function ($users) {
            expect($users)->toHaveCount(2);

            return true;
        })->set('search', 'jane')
    ->assertSet('users', function ($users) {
        expect($users)->toHaveCount(1)->first()->name->toBe('Jane Doe');

        return true;
    });
});

it('should be able to list deleted users', function () {
    User::factory()->create(['name' => 'jon Doe', 'email' => 'manager@doe.com']);
    User::factory()->count(2)->create(['deleted_at' => now()]);

    Livewire::test(Index::class)
        ->assertSet('users', function ($users) {
            expect($users)->toHaveCount(1);

            return true;
        })->set('search_trashed', true)
        ->assertSet('users', function ($users) {
            expect($users)->toHaveCount(2);

            return true;
        });
});

it('should be able to sort by name', function () {
    User::factory()->create(['name' => 'Jon Doe', 'email' => 'manager@doe.com']);
    User::factory()->create(['name' => 'Mary Doe', 'email' => 'owner@doe.com']);

    Livewire::test(Index::class)
        ->set('sortBy', ['column' => 'name', 'direction' => 'asc'])
        ->assertSet('users', function ($users) {
            expect($users)->first()->name->toBe('Jon Doe')
                ->and($users)->last()->name->toBe('Mary Doe');

            return true;
        })
        ->set('sortBy', ['column' => 'id', 'direction' => 'desc'])
            ->assertSet('users', function ($users) {
                expect($users)->first()->name->toBe('Mary Doe')
                    ->and($users)->last()->name->toBe('Jon Doe');

                return true;
            });
});

it('should be able to paginate the result', function () {
    User::factory()->create(['name' => 'Jon Doe', 'email' => 'manager@doe.com']);
    User::factory()->count(10)->create();

    Livewire::test(Index::class)
        ->set('perPage', 5)
        ->assertSet('users', function ($users) {
            expect($users)->toHaveCount(5);

            return true;
        });
});
