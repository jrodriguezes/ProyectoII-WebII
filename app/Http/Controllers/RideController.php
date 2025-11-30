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
    public function update(Request $request, Ride $ride)
    {
        $request->validate([
            'driver_id'       => 'required|integer',
            'origin'          => 'required|string|max:100',
            'destination'     => 'required|string|max:100',
            'date'            => 'required|date',
            'time'            => 'required',
            'available_seats' => 'required|integer|min:1',
            'price'           => 'required|numeric|min:0',
            'status'          => 'required|string|max:20',
        ]);

        $ride->update([
            'driver_id'       => $request->driver_id,
            'origin'          => $request->origin,
            'destination'     => $request->destination,
            'date'            => $request->date,
            'time'            => $request->time,
            'available_seats' => $request->available_seats,
            'price'           => $request->price,
            'status'          => $request->status,
        ]);

        return redirect()->back()->with('success', 'Viaje actualizado correctamente.');
    }

    /**
     * Eliminar ride (equivalente a delete_ride)
     */
    public function destroy(Ride $ride)
    {
        $ride->delete();

        return redirect()->back()->with('success', 'Viaje eliminado.');
    }

    
}
