@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">
  <h2 class="text-2xl font-bold mb-6">Add Rider</h2>

  <div class="bg-white rounded shadow p-6">
    <form action="{{ route('riders.store') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Name -->
      <div>
        <label class="block text-sm font-medium mb-1">Name</label>
        <input type="text" name="name" required
               class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
      </div>

      <!-- Phone -->
      <div>
        <label class="block text-sm font-medium mb-1">Phone</label>
        <input type="text" name="phone"
               class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
      </div>

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email"
               class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
      </div>

      <!-- Address -->
      <div>
        <label class="block text-sm font-medium mb-1">Address</label>
        <textarea name="address" rows="3"
                  class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
      </div>

      <!-- Buttons -->
      <div class="flex justify-end gap-2 mt-4">
        <a href="{{ route('riders.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</a>
        <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save Rider</button>
      </div>
    </form>
  </div>
</div>
@endsection
