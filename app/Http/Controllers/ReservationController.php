<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
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
