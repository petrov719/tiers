<?php

use Illuminate\Support\Facades\Route;

// Добавьте этот маршрут для устранения ошибки Route [login] not defined
Route::get('/login', function () {
    return response()->json(['message' => 'anautherize']);
})->name('login');