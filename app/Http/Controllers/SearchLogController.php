<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchLog;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SearchLogController extends Controller
{

    public function store(Request $request)
    {

        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string'
        ]);


        SearchLog::create([
            'user_id' => auth()->id(),
            'from_location' => $request->origin,
            'to_location' => $request->destination,
            'searched_at' => now()
        ]);

        return redirect()->back()->with('success', 'Search saved successfully.');
    }


    public function report(Request $request)
    {
        $currentUser = auth()->user();

        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $query = SearchLog::with('user');

        if ($request->start_date) {
            $query->whereDate('searched_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('searched_at', '<=', $request->end_date);
        }


        $logs = $query->orderBy('searched_at', 'desc')->get();

        //dd($logs);

        $userList = User::all();

        return view('home', [
            'currentUser' => $currentUser,
            'vehiclesList' => collect(),
            'vehicles' => collect(),
            'ridesList' => collect(),
            'reservationList' => collect(),
            'reservedRideIds' => [],
            'userList' => $userList,
            'allRidesList' => collect(),
            'logs' => $logs,
        ]);
    }
}
