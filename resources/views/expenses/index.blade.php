@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-bold">Expenses</h1>
    <a href="{{ route('expenses.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Add Expense</a>
  </div>

  @if(session('success')) <div class="mb-3 text-green-600">{{ session('success') }}</div> @endif

  <div class="bg-white rounded shadow overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Amount</th>
          <th class="px-4 py-2">Date</th>
          <th class="px-4 py-2">Category</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($expenses as $expense)
        <tr class="border-t">
          <td class="px-4 py-2">{{ $expense->title }}</td>
          <td class="px-4 py-2">{{ $expense->amount }}</td>
          <td class="px-4 py-2">{{ $expense->date }}</td>
          <td class="px-4 py-2">{{ $expense->category }}</td>
          <td class="px-4 py-2">
            <a href="{{ route('expenses.edit', $expense) }}" class="text-yellow-600">Edit</a> |
            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('Delete expense?')" class="text-red-600">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $expenses->links() }}</div>
</div>
@endsection
