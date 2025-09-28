@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">{{ $expense->title }} - Details</h1>
        <div class="flex gap-2">
            <a href="{{ route('expenses.edit', $expense) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Edit Expense</a>
            <a href="{{ route('expenses.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Back to Expenses</a>
        </div>
    </div>

    <div class="bg-white rounded shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><strong>Title:</strong> {{ $expense->title }}</div>
            <div><strong>Amount:</strong> SAR {{ number_format($expense->amount,2) }}</div>
            <div><strong>Date:</strong> {{ $expense->date }}</div>
            <div><strong>Category:</strong> {{ $expense->category }}</div>
            <div class="md:col-span-2"><strong>Notes:</strong> {{ $expense->notes }}</div>
        </div>
    </div>
</div>
@endsection
