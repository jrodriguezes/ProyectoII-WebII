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
        $data = $request->validate([
            'plate_id' => 'string|max:20|unique:vehicles,plate_id',
            'driver_id' => 'string|max:20',
            'color' => 'string|max:30',
            'brand' => 'string|max:50',
            'model' => 'string|max:50',
            'year' => 'integer|min:1900|max:2100',
            'seats' => 'integer|min:1|max:99',
            'status' => 'string|max:20',
            'vehicle_picture' => 'nullable|image|max:2048',
        ]);

        //dd($request->file('vehicle_picture'));
                
        $photoPath = null;
        if ($request->hasFile('vehicle_picture')) {
            // guarda en storage/app/public/vehicles_photos
            $photoPath = $request->file('vehicle_picture')->store('vehicle_photos', 'public');
        }


        Vehicle::create([
            'plate_id'          => $data['plate_id'],
            'driver_id'         => auth()->id(),
            'color'             => $data['color'],
            'brand'             => $data['brand'],
            'model'             => $data['model'],
            'year'              => $data['year'],
            'seats'             => $data['seats'],
            'status'            => 'active',
            'vehicle_picture'   => $photoPath,
        ]);


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
            'plate_id' => 'required|string|max:20|unique:vehicles,plate_id,' . $vehicle->plate_id . ',plate_id',
            'driver_id' => 'required|string|max:20',
            'color' => 'required|string|max:30',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:2100',
            'seats' => 'required|integer|min:1|max:99',
            'status' => 'required|string|max:20',
            'vehicle_picture' => 'nullable|image|max:2048',
        ]);

        $vehicle->plate_id = $request->plate_id;  // si permites cambiar placa
        $vehicle->driver_id = $request->driver_id;
        $vehicle->color = $request->color;
        $vehicle->brand = $request->brand;
        $vehicle->model = $request->model;
        $vehicle->year = $request->year;
        $vehicle->seats = $request->seats;
        $vehicle->status = $request->status;

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
