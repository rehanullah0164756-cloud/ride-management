@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4 max-w-lg">
  <h1 class="text-xl mb-4">Edit Ride</h1>

  <form action="{{ route('rides.update', $ride) }}" method="POST" class="bg-white p-4 rounded shadow">
    @csrf
    @method('PUT')

    <label class="block mb-2">Rider</label>
    <select name="rider_id" required class="w-full border p-2 mb-3">
      @foreach($riders as $id => $name)
        <option value="{{ $id }}" {{ $ride->rider_id == $id ? 'selected' : '' }}>{{ $name }}</option>
      @endforeach
    </select>

    <label class="block mb-2">Pickup</label>
    <input name="pickup_location" value="{{ $ride->pickup_location }}" required class="w-full border p-2 mb-3" />

    <label class="block mb-2">Drop</label>
    <input name="drop_location" value="{{ $ride->drop_location }}" required class="w-full border p-2 mb-3" />

    <label class="block mb-2">Fare</label>
    <input name="fare" type="number" step="0.01" value="{{ $ride->fare }}" required class="w-full border p-2 mb-3" />

    <label class="block mb-2">Payment Status</label>
    <select name="payment_status" class="w-full border p-2 mb-3">
      <option value="unpaid" {{ $ride->payment_status=='unpaid' ? 'selected':'' }}>Unpaid</option>
      <option value="paid" {{ $ride->payment_status=='paid' ? 'selected':'' }}>Paid</option>
    </select>

    <label class="block mb-2">Ride Date & Time</label>
    <input name="ride_date" type="datetime-local" value="{{ date('Y-m-d\TH:i', strtotime($ride->ride_date)) }}" class="w-full border p-2 mb-3" />

    <button class="px-4 py-2 bg-green-600 text-white rounded">Update Ride</button>
  </form>
</div>
@endsection
