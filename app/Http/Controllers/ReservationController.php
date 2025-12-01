<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Ride;

class ReservationController extends Controller
{
     /**
     * Reservar ride (equivalente a book_ride)
     */
    public function book(Request $request)
    {
        $data = $request->validate([
            'ride_id'       => 'required|integer',
        ]);

        //dd($data);

        // Crear reserva (tabla reservations)
        Reservation::create([
            'ride_id'  => $data['ride_id'],
            'passenger_id' => auth()->id(),
            'status'   => 'pending',
        ]);

        Ride::where('id', $data['ride_id'])->decrement('seats_offered');
        
        return redirect()->back()->with('success', 'Viaje reservado correctamente.');
    }

    /**
     * Aceptar una reservación (accept_reservation)
     */
    public function accept(Request $request)    
    {
        $request ->validate([
            'id' => 'required|integer',
        ]);

        Reservation::where('id', $request->id)->update([
            'status'=> 'accepted',
        ]);

        return redirect()->back()->with('success', 'Reservación denegada.');
    }

    /**
     * Rechazar una reservación (reject_reservation)
     */
    public function reject(Request $request)
    {
        $request ->validate([
            'id' => 'required|integer',
        ]);

        Reservation::where('id', $request->id)->update([
            'status'=> 'rejected',
        ]);

        return redirect()->back()->with('success', 'Reservación denegada.');
    
    }

    /**
     * Cancelar una reservación (cancel_reservation)
     */
    public function cancel(Request $request)
    {
        $request ->validate([
            'id' => 'required|integer',
        ]);

        Reservation::where('id', $request->id)->update([
            'status'=> 'cancelled',
        ]);

        return redirect()->back()->with('success', 'Reservación cancelada.');
    }
}
