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

        $allRidesList = Ride::with(['vehicle', 'driver'])->get();
        //dd($allRidesList);

        // si el usuario no esta logeado lo que haces mandar al home sin llenar el resto de datos por que da problema
        // por que da problemas que no pueda traer las listas
        if (!$currentUser) {
            return view('home', [
                'currentUser' => null,
                'vehiclesList' => collect(),
                'vehicles' => collect(),
                'ridesList' => collect(),
                'reservationList' => collect(),
                'reservedRideIds' => [],
                'usersList' => collect(),
                'allRidesList' => $allRidesList,
            ]);
        }

        $vehiclesList = Vehicle::where('driver_id', $currentUser->id)->get();

        $ridesList = Ride::where('driver_id', $currentUser->id)->get();

        //dd($ridesList);

        $reservationList = Reservation::all();

        //dd($reservationList);

        $userList = User::where('id')->get();

        $reservedRideIds = Reservation::where('passenger_id', $currentUser->id)
            ->pluck('ride_id')
            ->toArray();

        return view('home', compact('currentUser', 'vehiclesList', 'ridesList', 'reservationList', 'userList', 'allRidesList', 'reservedRideIds'));
    }
}

?>