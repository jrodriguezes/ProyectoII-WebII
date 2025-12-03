<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservation;

class BookingController extends Controller
{
    public function index()
    {

        $currentUser = auth()->user();

        if ($currentUser->user_type == "passenger") {


            $reservationsAsPassenger = Reservation::with([
                'ride.vehicle.driver', // ride -> vehicle -> driver
                'ride.driver',         // driver directo del ride
            ])
                ->where('passenger_id', $currentUser->id)
                ->get();

            //dd($reservationsAsPassenger);

            return view('booking', compact('currentUser', 'reservationsAsPassenger'));
        }

        if ($currentUser->user_type == 'driver') {
            $reservationsAsDriver = Reservation::with([
                'ride.vehicle.driver',
                'passenger',
            ])
                ->whereHas('ride', function ($q) use ($currentUser) {
                    $q->where('driver_id', $currentUser->id);
                })
                ->get();

            //dd($reservationsAsDriver);      

            return view('booking', compact('currentUser', 'reservationsAsDriver'));
        }


        //dd($currentUser);

        return view('booking', compact('currentUser'));
    }
}
