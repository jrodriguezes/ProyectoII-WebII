<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
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
            'plate_id' => $data['plate_id'],
            'driver_id' => auth()->id(),
            'color' => $data['color'],
            'brand' => $data['brand'],
            'model' => $data['model'],
            'year' => $data['year'],
            'seats' => $data['seats'],
            'status' => 'active',
            'vehicle_picture' => $photoPath,
        ]);

        return redirect()->back()->with('success', 'Vehículo registrado correctamente.');
    }

    public function update(Request $request)
    {
        //dd($request->all());

        $data = $request->validate([
            'plate_id' => 'required|exists:vehicles,plate_id',
            'color' => 'required|string|max:30',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:2100',
            'seats' => 'required|integer|min:1|max:99',
            'modify_vehicle_picture' => 'nullable|image|max:2048',
        ]);

        //dd($data);

        //hacer el mismo proseso que la consulta de create da problemas 
        //por lo que preferi hacerlo mas lavavel y dejarlo de estma manera 

        $vehicle = Vehicle::where('plate_id', $data['plate_id'])->firstOrFail();

        $vehicle->color = $data['color'];
        $vehicle->brand = $data['brand'];
        $vehicle->model = $data['model'];
        $vehicle->year = $data['year'];
        $vehicle->seats = $data['seats'];


        if ($request->hasFile('modify_vehicle_picture')) {
            $photoPath = $request->file('modify_vehicle_picture')
                ->store('vehicle_photos', 'public');
            $vehicle->vehicle_picture = $photoPath;
        }

        $vehicle->save();


        return redirect()->back()->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy(Request $request)
    {
        //dd($request->all());    

        $vehicle = Vehicle::findOrFail($request->plate_id);
        $vehicle->status = 'inactive';

        $vehicle->save();

        return redirect()->back()->with('success', 'Vehículo eliminado.');
    }


}
