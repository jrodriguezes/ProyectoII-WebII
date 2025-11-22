<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('booking');
});

Route::get('/login', function () {
    return view('login');
});