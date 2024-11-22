<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipentController;

Route::get('/', function () {
    return view ('welcome');
});


Route::get('/', [ParticipentController::class, 'showListView'])->name('participent.list');
Route::get('/participents-data', [ParticipentController::class, 'index'])->name('participent.index');
Route::get('participent/create', [ParticipentController::class, 'create'])->name('participent.create');
Route::post('participent/store', [ParticipentController::class, 'store'])->name('participent.store');
Route::get('get-cities/{stateId}', [ParticipentController::class, 'getCities']);

Route::patch('/participent/{id}/status', [ParticipentController::class, 'updateStatus']);

Route::get('participent/{id}/edit', [ParticipentController::class, 'edit'])->name('participent.edit');

Route::put('participent/{id}', [ParticipentController::class, 'update'])->name('participent.update');
Route::post('/participent/{id}', [ParticipentController::class, 'destroy'])->name('participent.delete');

