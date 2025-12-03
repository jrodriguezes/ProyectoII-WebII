<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\VehicleController;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/email-verified', function () {
    return view('email-verified');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/edit-profile', function () {
    return view('edit-profile');
});

Route::get('/check-email', function () {
    return view('check-your-email');
})->name('check-email');
;



// Usuario
Route::post('/user-register', [UserController::class, 'store'])->name('user.register');

// Login & Verification de email 
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/verify-email', [UserController::class, 'verify'])
    ->name('verify.email');

// Vehiculo

//registrar vehiculos
Route::post('/home/vehicle/register', [VehicleController::class, 'store'])
    ->name('vehicle.register');

// Editar vehículo
Route::post('/home/vehicle/edit', [VehicleController::class, 'update'])

    ->name('vehicle.edit');
//Desactivar vehiculo
Route::post('/home/vehicle/delete', [VehicleController::class, 'destroy'])
    ->name('vehicle.delete'); 

// Viajes
// insertar ride
Route::post('/home/ride/register', [RideController::class, 'store'])
    ->name('ride.register'); 

// actualizar ride
Route::post('/home/ride/edit', [RideController::class, 'update'])
    ->name('ride.edit'); 

//desactivar ride
Route::post('/home/ride/delete', [RideController::class, 'destroy'])
    ->name('ride.delete');

// Reservaciones
// registar serservacion
Route::post('/home/reservation/register', [ReservationController::class, 'book'])
    ->name('reservation.register');

//cancelar reservacion
Route::post('/home/reservation/cancel', [ReservationController::class, 'cancel'])
    ->name('reservation.cancel');  

//accept reservaciom
Route::post('/home/reservation/accept', [ReservationController::class, 'accept'])
    ->name('reservation.accept');  

//accept reservaciom
Route::post('/home/reservation/reject', [ReservationController::class, 'reject'])
    ->name('reservation.reject');  


//no se que hace esta ruta pero bueno no la toco mejor por si acaso
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

// booking
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');