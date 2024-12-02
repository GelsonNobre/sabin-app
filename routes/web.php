<?php

use App\Livewire\Auth\{Login, Logout};
use App\Livewire\Welcome;
use Illuminate\Support\Facades\{Route};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', Welcome::class)->name('dashboard');
    Route::get('/logout', [Logout::class, 'logout'])->name('logout');

    Route::get('/users', \App\Livewire\User\Index::class)->name('users');

    Route::get('/roles', \App\Livewire\Role\Index::class)->name('roles');

    Route::get('/persons', \App\Livewire\Person\Index::class)->name('persons');
    Route::get('/persons/create', \App\Livewire\Person\Create::class)->name('persons.create');
    Route::get('/persons/{id}', \App\Livewire\Person\Show::class)->name('persons.show');
    Route::get('/persons/{id}/edit', \App\Livewire\Person\Edit::class)->name('persons.edit');
});
