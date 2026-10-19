<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/dang-tin', [PropertyController::class, 'create'])->name('properties.create');
Route::post('/dang-tin', [PropertyController::class, 'store'])->name('properties.store')->middleware('throttle:10,1');
Route::get('/tin/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::post('/tin/{property}/lien-he', [ContactController::class, 'store'])->name('contacts.store')->middleware('throttle:5,1');
