@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Riders List</h1>
        <a href="{{ route('riders.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Add New Rider</a>
    </div>

    @if(session('success'))
        <div class="mb-3 text-green-600">{{ session('success') }}</div>
    @endif

    <!-- Search -->
    <div class="mb-4">
        <form method="GET" action="{{ route('riders.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search rider..." class="border p-2 rounded w-full md:w-1/3" />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>
        </form>
    </div>

    <!-- Riders Table -->
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Phone</th>
                    <th class="px-4 py-2 text-left">Address</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($riders as $rider)
                    <tr>
                        <td class="px-4 py-2">{{ $rider->name }}</td>
                        <td class="px-4 py-2">{{ $rider->email }}</td>
                        <td class="px-4 py-2">{{ $rider->phone }}</td>
                        <td class="px-4 py-2">{{ $rider->address }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('riders.show', $rider) }}" class="px-2 py-1 bg-blue-600 text-white rounded text-sm">View</a>
                            <a href="{{ route('riders.edit', $rider) }}" class="px-2 py-1 bg-yellow-500 text-white rounded text-sm">Edit</a>
                            <form action="{{ route('riders.destroy', $rider) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded text-sm">Delete</button>
                            </form>
                            <a href="{{ route('rides.create') }}?rider_id={{ $rider->id }}" class="px-2 py-1 bg-green-600 text-white rounded text-sm">Add Ride</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No riders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $riders->withQueryString()->links() }}
    </div>
</div>
@endsection
