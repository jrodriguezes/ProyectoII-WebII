<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('booking');
});

Route::get('/booking', function () {
    return view('booking');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/user-register', function () {
    return view('user-register');
});

Route::post('/register', [UserController::class, 'register'])->name('users.register');

// Modificar usuario
Route::post('/users/{id}/modify', [UserController::class, 'modify'])->name('users.modify');

// Eliminar usuario
Route::post('/users/{id}/delete', [UserController::class, 'delete'])->name('users.delete');

// Activar usuario
Route::post('/users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');