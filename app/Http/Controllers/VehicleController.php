<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    /**
     * Registrar vehículo (INSERT)
     */
    public function store(Request $request)
    {
        $request->validate([
            'plate_id'        => 'required|string|max:20|unique:vehicles,plate_id',
            'driver_id'       => 'required|string|max:20', // ajusta según tipo real
            'color'           => 'required|string|max:30',
            'brand'           => 'required|string|max:50',
            'model'           => 'required|string|max:50',
            'year'            => 'required|integer|min:1900|max:2100',
            'seats'           => 'required|integer|min:1|max:99',
            'status'          => 'required|string|max:20',
            'vehicle_picture' => 'nullable|image|max:2048',
        ]);

        $vehicle = new Vehicle();
        $vehicle->plate_id  = $request->plate_id;
        $vehicle->driver_id = $request->driver_id;
        $vehicle->color     = $request->color;
        $vehicle->brand     = $request->brand;
        $vehicle->model     = $request->model;
        $vehicle->year      = $request->year;
        $vehicle->seats     = $request->seats;
        $vehicle->status    = $request->status;

        if ($request->hasFile('vehicle_picture')) {
            $vehicle->vehicle_picture = $request->file('vehicle_picture')
                                             ->store('vehicles', 'public');
        }

        $vehicle->save();

        return redirect()->back()->with('success', 'Vehículo registrado correctamente.');
    }

    /**
     * Modificar vehículo (UPDATE)
     */
    public function update(Request $request, string $plate_id)
    {
        $vehicle = Vehicle::findOrFail($plate_id);

        $request->validate([
            // ignorar la placa actual en la validación de unique
            'plate_id'        => 'required|string|max:20|unique:vehicles,plate_id,' . $vehicle->plate_id . ',plate_id',
            'driver_id'       => 'required|string|max:20',
            'color'           => 'required|string|max:30',
            'brand'           => 'required|string|max:50',
            'model'           => 'required|string|max:50',
            'year'            => 'required|integer|min:1900|max:2100',
            'seats'           => 'required|integer|min:1|max:99',
            'status'          => 'required|string|max:20',
            'vehicle_picture' => 'nullable|image|max:2048',
        ]);

        $vehicle->plate_id  = $request->plate_id;  // si permites cambiar placa
        $vehicle->driver_id = $request->driver_id;
        $vehicle->color     = $request->color;
        $vehicle->brand     = $request->brand;
        $vehicle->model     = $request->model;
        $vehicle->year      = $request->year;
        $vehicle->seats     = $request->seats;
        $vehicle->status    = $request->status;

        if ($request->hasFile('vehicle_picture')) {
            $vehicle->vehicle_picture = $request->file('vehicle_picture')
                                               ->store('vehicles', 'public');
        }

        $vehicle->save();

        return redirect()->back()->with('success', 'Vehículo actualizado correctamente.');
    }

    /**
     * Eliminar vehículo (DELETE)
     */
    public function destroy(string $plate_id)
    {
        $vehicle = Vehicle::findOrFail($plate_id);
        $vehicle->delete();

        return redirect()->back()->with('success', 'Vehículo eliminado.');
    }

    
}
