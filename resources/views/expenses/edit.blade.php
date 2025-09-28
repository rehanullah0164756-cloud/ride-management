@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Edit Expense</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expenses.update', $expense) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-medium">Title</label>
        <input type="text" name="title" value="{{ old('title', $expense->title) }}" required class="w-full border p-2 mb-4 rounded" />

        <label class="block mb-2 font-medium">Amount</label>
        <input type="number" name="amount" step="0.01" value="{{ old('amount', $expense->amount) }}" required class="w-full border p-2 mb-4 rounded" />

        <label class="block mb-2 font-medium">Date</label>
        <input type="date" name="date" value="{{ old('date', $expense->date) }}" class="w-full border p-2 mb-4 rounded" />

        <label class="block mb-2 font-medium">Category</label>
        <input type="text" name="category" value="{{ old('category', $expense->category) }}" class="w-full border p-2 mb-4 rounded" />

        <label class="block mb-2 font-medium">Notes</label>
        <textarea name="notes" class="w-full border p-2 mb-4 rounded">{{ old('notes', $expense->notes) }}</textarea>

        <div class="flex justify-between">
            <a href="{{ route('expenses.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Back</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Update Expense</button>
        </div>
    </form>
</div>
@endsection
