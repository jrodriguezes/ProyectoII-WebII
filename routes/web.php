<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\SearchLogController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MagicLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/user-register', function () {
    return view('user-register');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/email-verified', function () {
    return view('email-verified');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

//buscar rides
Route::post('/home/ride', [HomeController::class, 'searchRides'])->name('search.ride');

//report admin
Route::post('/home/report', [SearchLogController::class, 'report'])->name('report.admin');

Route::get('/edit-profile', function () {
    return view('edit-profile');
});

Route::get('/check-email', function () {
    return view('check-your-email');
})->name('check-email');

Route::get('/edit-profile', [EditProfileController::class, 'index'])->name('edit-profile');

// Usuario
Route::post('/user-register', [UserController::class, 'store'])->name('user.register');

// Modificar usuario
Route::post('/users/{id}/modify', [UserController::class, 'update'])->name('users.modify');

Route::post('/home/user/deactivate',[UserController::class, 'deactivateUser'])->name('user.deactivate');

Route::post('/home/user/activate',[UserController::class, 'activateUser'])->name('user.activate');
// Login & Verification de email 
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/verify-email', [UserController::class, 'verify'])->name('verify.email');

// formulario de enviar link de login
Route::post('/login/magic-link', [MagicLoginController::class, 'sendLink'])->name('login.magic.send')->middleware('guest');

// el enlace que viene en el correo
Route::get('/login/magic-link/{token}', [MagicLoginController::class, 'loginWithLink'])->name('magic.login')->middleware('guest');

Route::get('/login-magic-link', function () {
    return view('login-magic');
})->name('login-magic-link');


Route::post('/home', [UserController::class, 'activateUser'])->name('user.activate');

Route::post('/home', [UserController::class, 'desactivateUser'])->name('user.desactivate');


// Vehiculo
Route::middleware('auth')->group(function () {
    Route::post('/home/vehicle/register', [VehicleController::class, 'store'])->name('vehicle.register');
    Route::post('/home/vehicle/edit', [VehicleController::class, 'update'])->name('vehicle.edit');
    Route::post('/home/vehicle/delete', [VehicleController::class, 'destroy'])->name('vehicle.delete');
});

// Viajes
Route::post('/home/ride/register', [RideController::class, 'store'])->name('ride.register');

Route::post('/home/ride/edit', [RideController::class, 'update'])->name('ride.edit');

Route::post('/home/ride/delete', [RideController::class, 'destroy'])->name('ride.delete');

// Reservaciones

Route::post('/home/reservation/register', [ReservationController::class, 'book'])->name('reservation.register');

Route::post('/home/reservation/cancel', [ReservationController::class, 'cancel'])->name('reservation.cancel');

Route::post('/home/reservation/accept', [ReservationController::class, 'accept'])->name('reservation.accept');

Route::post('/home/reservation/reject', [ReservationController::class, 'reject'])->name('reservation.reject');

// booking
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');