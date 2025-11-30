<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Reservation;
use Illuminate\Http\Request;

class RideController extends Controller
{
    //insertar ride
    public function store(Request $request)
    {

        //dd($request->all());

        $data = $request->validate([
            
            'vehicle_id'=> 'required|string|max:30',
            'name'=> 'required|string',
            'origin'   => 'required|string|max:100',
            'destination'  => 'required|string|max:100',
            'departure_date' => 'required|date_format:Y-m-d\TH:i',
            'seats_offered'=> 'required|integer|min:1',
            'price_per_seat' => 'required|numeric|min:0',
            
        ]);

        //dd($data);

        Ride::create([
            'driver_id' => auth()->id(),
            'vehicle_plate'=> $data['vehicle_id'],
            'name'=> $data['name'],
            'origin'=> $data['origin'],
            'destination'=> $data['destination'],
            'departure_date'=> $data['departure_date'],
            'seats_offered'=> $data['seats_offered'],
            'price_per_seat'=> $data['price_per_seat'],
            'status'=> 'active',
        ]);
       

        return redirect()->back()->with('success', 'Viaje creado correctamente.');
    }

    /**
     * Modificar ride (equivalente a modify_ride)
     */
    public function update(Request $request)
    {
        //dd($request->all());

        $data = $request->validate([
            'ride_id'=> 'required',
            'vehicle_id'=> 'required|string|max:30',
            'name'=> 'required|string',
            'origin'   => 'required|string|max:100',
            'destination'  => 'required|string|max:100',
            'departure_date' => 'required|date_format:Y-m-d\TH:i',
            'seats_offered'=> 'required|integer|min:1',
            'price_per_seat' => 'required|numeric|min:0',
        ]);

        //dd($data);

        Ride::where('id', $request->ride_id)->update([
            'vehicle_plate'=> $data['vehicle_id'],
            'name'=> $data['name'],
            'origin'=> $data['origin'],
            'destination'=> $data['destination'],
            'departure_date'=> $data['departure_date'],
            'seats_offered'=> $data['seats_offered'],
            'price_per_seat'=> $data['price_per_seat'],
        ]);

        return redirect()->back()->with('success', 'Viaje actualizado correctamente.');
    }

    /**
     * Eliminar ride (equivalente a delete_ride)
     */
    public function destroy(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'ride_id' => 'required|integer',
        ]);

        Ride::where('id', $request->ride_id)->update([
            'status' => 'inactive'
        ]);
        

        return redirect()->back()->with('success', 'Viaje eliminado.');
    }

    
}
