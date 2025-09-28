@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">{{ $rider->name }} - Details</h1>
        <div class="flex gap-2">
            <a href="{{ route('riders.edit', $rider) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Edit Rider</a>
            <a href="{{ route('riders.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Back to Riders</a>
        </div>
    </div>

    <!-- Rider Details -->
    <div class="bg-white rounded shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><strong>Name:</strong> {{ $rider->name }}</div>
            <div><strong>Email:</strong> {{ $rider->email }}</div>
            <div><strong>Phone:</strong> {{ $rider->phone }}</div>
            <div><strong>Address:</strong> {{ $rider->address }}</div>
        </div>
    </div>

    <!-- Rider Rides -->
    <div class="bg-white rounded shadow p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Rides</h2>
            <a href="{{ route('rides.create') }}?rider_id={{ $rider->id }}" class="px-4 py-2 bg-green-600 text-white rounded">Add Ride</a>
        </div>

        @if($rider->rides->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Pickup</th>
                        <th class="px-4 py-2 text-left">Drop</th>
                        <th class="px-4 py-2 text-left">Faree</th>
                        <th class="px-4 py-2 text-left">Payment Status</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($rider->rides as $ride)
                        <tr>
                            <td class="px-4 py-2">{{ $ride->pickup_location }}</td>
                            <td class="px-4 py-2">{{ $ride->drop_location }}</td>
                            <td class="px-4 py-2">SAR {{ number_format($ride->fare,2) }}</td>
                            <td class="px-4 py-2 capitalize">{{ $ride->payment_status }}</td>
                            <td class="px-4 py-2">{{ $ride->ride_date }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('rides.edit', $ride) }}" class="px-2 py-1 bg-yellow-500 text-white rounded text-sm">Edit</a>
                                <form action="{{ route('rides.destroy', $ride) }}" method="POST" onsubmit="return confirm('Delete this ride?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Fare Summary -->
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-gray-100 rounded shadow text-center">
                    <div class="text-sm">Total Rides</div>
                    <div class="text-xl font-bold">{{ $rider->rides->count() }}</div>
                </div>
                <div class="p-4 bg-gray-100 rounded shadow text-center">
                    <div class="text-sm">Total Paid</div>
                    <div class="text-xl font-bold">SAR {{ number_format($rider->rides->where('payment_status','paid')->sum('fare'),2) }}</div>
                </div>
                <div class="p-4 bg-gray-100 rounded shadow text-center">
                    <div class="text-sm">Total Unpaid</div>
                    <div class="text-xl font-bold">SAR {{ number_format($rider->rides->where('payment_status','unpaid')->sum('fare'),2) }}</div>
                </div>
            </div>

        @else
            <p class="text-gray-500">No rides found for this rider.</p>
        @endif
    </div>
</div>
@endsection
