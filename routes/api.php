<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/contacts', \App\Http\Controllers\Api\ContactController::class)->name('contacts');
Route::post('/contacts', \App\Http\Controllers\Api\ContactCreateController::class)->name('contacts.create');
Route::get('/contacts/{id}', \App\Http\Controllers\Api\ContactGetController::class)->name('contacts.get');
Route::put('/contacts/{id}', \App\Http\Controllers\Api\ContactUpdateController::class)->name('contacts.update');
Route::delete('/contacts/{id}', \App\Http\Controllers\Api\ContactDeleteController::class)->name('contacts.delete');
