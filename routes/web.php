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

    Route::get('/medications', \App\Livewire\Medication\Index::class)->name('medications');
    Route::get('/medications/create', \App\Livewire\Medication\Create::class)->name('medications.create');
    Route::get('/medications/{medication}/edit', \App\Livewire\Medication\Edit::class)->name('medications.edit');
    Route::get('/medications/{medication}', \App\Livewire\Medication\Show::class)->name('medications.show');

    Route::get('/stock', \App\Livewire\Stock\Index::class)->name('stock');
    Route::get('/stock/create', \App\Livewire\Stock\Create::class)->name('stock.create');
    Route::get('/stock/{stock}/edit', \App\Livewire\Stock\Edit::class)->name('stock.edit');
    Route::get('/stock/{stock}', \App\Livewire\Stock\Show::class)->name('stock.show');
});
