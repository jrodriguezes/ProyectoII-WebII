<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});
Route::get('/user-register', function () {
    return view('user-register');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/edit-profile', function () {
    return view('edit-profile');
});
Route::get('/check-your-email', function () {
    return view('check-your-email');
});
Route::get('/booking', function () {
    return view('booking');
});


