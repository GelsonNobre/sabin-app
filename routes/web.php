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
    Route::get('/medications/{id}/edit', \App\Livewire\Medication\Edit::class)->name('medications.edit');
    Route::get('/medications/{id}', \App\Livewire\Medication\Show::class)->name('medications.show');

    Route::get('/stock', \App\Livewire\Stock\Index::class)->name('stock');
    Route::get('/stock/create', \App\Livewire\Stock\Create::class)->name('stock.create');
    Route::get('/stock/{id}/edit', \App\Livewire\Stock\Edit::class)->name('stock.edit');
    Route::get('/stock/{id}', \App\Livewire\Stock\Show::class)->name('stock.show');

    Route::get('/patients', \App\Livewire\Patient\Index::class)->name('patients');
    Route::get('/patients/create', \App\Livewire\Patient\Create::class)->name('patients.create');
    Route::get('/patients/{id}/edit', \App\Livewire\Patient\Edit::class)->name('patients.edit');
    Route::get('/patients/{id}', \App\Livewire\Patient\Show::class)->name('patients.show');
    
    Route::get('/order-status', \App\Livewire\OrderStatus\Index::class)->name('order-status');
    
    
    Route::get('/nurses', \App\Livewire\Nurse\Index::class)->name('nurses');
});
