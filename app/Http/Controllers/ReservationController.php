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
    public function accept(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->status = 'accepted'; // ajusta al valor que uses en la BD
        $reservation->save();

        return redirect()->back()->with('success', 'Reservación aceptada correctamente.');
    }

    /**
     * Rechazar una reservación (reject_reservation)
     */
    public function reject(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->status = 'rejected'; // ajusta al valor que uses
        $reservation->save();

        return redirect()->back()->with('success', 'Reservación rechazada.');
    }

    /**
     * Cancelar una reservación (cancel_reservation)
     */
    public function cancel(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->status = 'cancelled'; // o 'canceled', según tu tabla
        $reservation->save();

        return redirect()->back()->with('success', 'Reservación cancelada.');
    }
}
