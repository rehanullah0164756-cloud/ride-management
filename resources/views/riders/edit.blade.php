@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Edit Rider</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('riders.update', $rider) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-medium">Name</label>
        <input type="text" name="name" value="{{ old('name', $rider->name) }}" required class="w-full border p-2 mb-4 rounded" />

        <label class="block mb-2 font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email', $rider->email) }}" required class="w-full border p-2 mb-4 rounded" />

        <label class="block mb-2 font-medium">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $rider->phone) }}" required class="w-full border p-2 mb-4 rounded" />

        <label class="block mb-2 font-medium">Address</label>
        <textarea name="address" class="w-full border p-2 mb-4 rounded">{{ old('address', $rider->address) }}</textarea>

        <div class="flex justify-between">
            <a href="{{ route('riders.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Back</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Update Rider</button>
        </div>
    </form>
</div>
@endsection
