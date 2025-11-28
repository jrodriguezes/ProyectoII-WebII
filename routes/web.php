<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/email-verified', function () {
    return view('email-verified');
});

Route::get('/user-register', function () {
    return view('user-register');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/edit-profile', function () {
    return view('edit-profile');
});

Route::get('/check-email', function () {
    return view('check-your-email');
})->name('check-email');
;

Route::get('/booking', function () {
    return view('booking');
});

// Usuario
Route::post('/user-register', [UserController::class, 'store'])->name('user.register');

// Login & Verification de email 
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/verify-email', [UserController::class, 'verify'])
    ->name('verify.email');

// Vehiculo

// Viajes

// Reservaciones

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