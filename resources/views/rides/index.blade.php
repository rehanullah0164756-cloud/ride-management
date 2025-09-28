@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-bold">Rides</h1>
    <a href="{{ route('rides.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Add Ride</a>
  </div>

  @if(session('success'))
    <div class="mb-3 text-green-600">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">Rider</th>
          <th class="px-4 py-2">Pickup</th>
          <th class="px-4 py-2">Drop</th>
          <th class="px-4 py-2">Fare</th>
          <th class="px-4 py-2 text-center">Payment Status</th>
          <th class="px-4 py-2 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rides as $ride)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $ride->rider->name }}</td>
          <td class="px-4 py-2">{{ $ride->pickup_location }}</td>
          <td class="px-4 py-2">{{ $ride->drop_location }}</td>

          <!-- Fare -->
          <td class="px-4 py-2 text-center">SAR {{ number_format($ride->fare, 2) }}</td>

          <!-- Payment Status clickable -->
          <td class="px-4 py-2 text-center">
            <span
              class="cursor-pointer text-xl font-bold {{ $ride->payment_status == 'paid' ? 'text-green-600' : 'text-red-600' }}"
              onclick="togglePaymentStatus({{ $ride->id }}, '{{ $ride->payment_status }}')">
              {{ $ride->payment_status == 'paid' ? '✅' : '❌' }}
            </span>
          </td>

          <td class="px-4 py-2 text-center">
            <a href="{{ route('rides.edit', $ride) }}" class="text-yellow-600">Edit</a> |
            <form action="{{ route('rides.destroy', $ride) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('Delete ride?')" class="text-red-600">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $rides->links() }}</div>
</div>

<script>
function togglePaymentStatus(rideId, currentStatus) {
    let newStatus = currentStatus === 'paid' ? 'unpaid' : 'paid';
    if(confirm(`Are you sure you want to mark this ride as ${newStatus}?`)) {
        fetch(`/rides/${rideId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const span = document.querySelector(`span[onclick="togglePaymentStatus(${rideId}, '${currentStatus}')"]`);
                span.textContent = newStatus === 'paid' ? '✅' : '❌';
                span.classList.remove('text-green-600','text-red-600');
                span.classList.add(newStatus === 'paid' ? 'text-green-600' : 'text-red-600');
            } else {
                alert('Failed to update status');
            }
        });
    }
}
</script>
@endsection
