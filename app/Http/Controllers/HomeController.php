<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Ride;
use App\Models\Reservation;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        $vehiclesList = Vehicle::where('driver_id', $currentUser->id)->get();

        $ridesList = Ride::where('driver_id', $currentUser->id)->get();

        $reservationList = Reservation::where('ride_id', $currentUser->id)->get();

        $userList = User::where('id')->get();

        return view('home', compact('currentUser', 'vehiclesList', 'ridesList', 'reservationList', 'userList'));
    }
}

?>