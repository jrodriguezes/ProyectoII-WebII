<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Reservation;
use Illuminate\Http\Request;

class RideController extends Controller
{
    /**
     * Registrar ride (equivalente a register_ride)
     */
    public function store(Request $request)
    {
        $request->validate([
            // AJUSTA ESTOS CAMPOS A TU TABLA "rides"
            'driver_id'      => 'required|integer',
            'origin'         => 'required|string|max:100',
            'destination'    => 'required|string|max:100',
            'date'           => 'required|date',
            'time'           => 'required',
            'available_seats'=> 'required|integer|min:1',
            'price'          => 'required|numeric|min:0',
            'status'         => 'required|string|max:20',
        ]);

        $ride = Ride::create([
            'driver_id'       => $request->driver_id,
            'origin'          => $request->origin,
            'destination'     => $request->destination,
            'date'            => $request->date,
            'time'            => $request->time,
            'available_seats' => $request->available_seats,
            'price'           => $request->price,
            'status'          => $request->status,
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

    /**
     * Reservar ride (equivalente a book_ride)
     */
    public function book(Request $request, Ride $ride)
    {
        $request->validate([
            // si usas login, podrías usar auth()->id() en vez de user_id
            'user_id'     => 'required|integer',
            'seats'       => 'required|integer|min:1',
        ]);

        // Verificar asientos disponibles
        if ($ride->available_seats < $request->seats) {
            return redirect()->back()
                ->withErrors(['seats' => 'No hay suficientes asientos disponibles.']);
        }

        // Crear reserva (tabla reservations)
        Reservation::create([
            'ride_id'  => $ride->id,
            'user_id'  => $request->user_id,
            'seats'    => $request->seats,
            'status'   => 'waiting', // ajusta a tus valores
        ]);

        // Actualizar asientos disponibles
        $ride->available_seats -= $request->seats;
        $ride->save();

        return redirect()->back()->with('success', 'Viaje reservado correctamente.');
    }
}
