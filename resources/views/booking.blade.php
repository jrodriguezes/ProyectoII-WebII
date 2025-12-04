@extends('layouts.app')

@section('title', 'Home')

@section('content')


    <div class="min-h-full w-full">
        <div>
            @include('layouts.navbar');
        </div>
        <div class="ml-8">
            <div class="flex items-center">
                @include('components.theme-toggle')
            </div>
            <div>
                <h1 class="text-2xl font-bold">Bienvenido, {{ $currentUser->first_name }} 👋</h1>
                <p class="text-gray-500">Tu rol actual es: <strong> {{ $currentUser->user_type }} </strong></p>
            </div>
        </div>

        @if ($currentUser->user_type == 'passenger')
            <div class="w-full overflow-x-auto pr-0 -mr-4 sm:-mr-6 md:-mr-8 lg:-mr-10">
                <table class="w-full table-fixed border-collapse divide-y-2 divide-gray-200 dark:divide-gray-700 text-center">
                    <thead class="sticky top-0 bg-white dark:bg-gray-900">
                        <tr class="font-medium text-gray-900 dark:text-white">
                            <th>Reservation ID</th>
                            <th>Ride</th>
                            <th>Driver ID</th>
                            <th>Driver</th>
                            <th>Vehicle</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th class="w-[160px] text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                        @foreach ($reservationsAsPassenger as $reservation)
                            <tr class="*:text-gray-900 *:first:font-medium dark:*:text-white">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $reservation->id }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $reservation->ride->name }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $reservation->ride->driver->id }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $reservation->ride->driver->first_name }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{$reservation->ride->vehicle->plate_id . ' ' . $reservation->ride->vehicle->brand . ' ' . $reservation->ride->vehicle->model}}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $reservation->status }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $reservation->created_at }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @if ($reservation->status == 'pending')
                                        <form action=" {{ route('reservation.cancel') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{ $reservation->id }}">
                                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @elseif($currentUser->user_type == 'driver')
            <div class="w-full overflow-x-auto pr-0 -mr-4 sm:-mr-6 md:-mr-8 lg:-mr-10">
                <div class="p-8">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full border-collapse divide-y-2 divide-gray-200 dark:divide-gray-700 text-center">
                            <thead class="sticky top-0 bg-white dark:bg-gray-900">
                                <tr class="font-medium text-gray-900 dark:text-white">
                                    <th>Reservation ID</th>
                                    <th>Plate vehicle</th>
                                    <th>Ride</th>
                                    <th>Passenger ID</th>
                                    <th>Passenger</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                                @foreach ($reservationsAsDriver as $reservation)
                                    <tr class="*:text-gray-900 *:first:font-medium dark:*:text-white">
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ $reservation->id }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ $reservation->ride->vehicle->plate_id }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ $reservation->ride->name }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ $reservation->passenger_id }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ $reservation->passenger->first_name . ' ' . $reservation->passenger->last_name }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ $reservation->status }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap">
                                            {{ $reservation->created_at }}
                                        </td>
                                    @if ($reservation->status == 'pending')
                                        <td class="px-3 py-2 whitespace-nowrap flex justify-center">
                                            <form action=" {{ route('reservation.accept') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" id="id" value="{{ $reservation->id }}">
                                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded">
                                                    Accept
                                                </button>
                                            </form>

                                            <form action=" {{ route('reservation.reject') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" id="id" value="{{ $reservation->id }}">
                                                <button class="bg-orange-600 hover:bg-orange-700 text-white px-3 py-2 rounded">
                                                    Reject
                                                </button>
                                            </form>

                                            <form action=" {{ route('reservation.cancel') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" id="id" value="{{ $reservation->id }}">
                                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">
                                                    Cancel
                                                </button>
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection