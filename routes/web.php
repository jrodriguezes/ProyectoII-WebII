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