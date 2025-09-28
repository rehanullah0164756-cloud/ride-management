@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

    <!-- Filter Form -->
    <form method="GET" class="mb-6 flex gap-2">
        <select name="month" class="border p-2 rounded">
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                </option>
            @endfor
        </select>

        <select name="year" class="border p-2 rounded">
            @for($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
    </form>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Riders -->
        <div class="p-4 bg-white rounded shadow flex flex-col justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Total Riders</div>
                <div class="text-xl font-semibold">{{ $totalRiders }}</div>
            </div>
            <div class="mt-2 flex gap-2">
                <a href="{{ route('riders.create') }}" class="px-2 py-1 bg-green-600 text-white rounded text-sm">Add Rider</a>
                <a href="{{ route('riders.index') }}" class="px-2 py-1 bg-blue-600 text-white rounded text-sm">View/Edit</a>
            </div>
        </div>

        <!-- Total Rides -->
        <div class="p-4 bg-white rounded shadow flex flex-col justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Total Rides</div>
                <div class="text-xl font-semibold">{{ $totalRides }}</div>
            </div>
            <div class="mt-2 flex gap-2">
                <a href="{{ route('rides.create') }}" class="px-2 py-1 bg-green-600 text-white rounded text-sm">Add Ride</a>
                <a href="{{ route('rides.index') }}" class="px-2 py-1 bg-blue-600 text-white rounded text-sm">View/Edit</a>
            </div>
        </div>

        <!-- Total Income -->
        <div class="p-4 bg-white rounded shadow flex flex-col justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Total Income</div>
                <div class="text-xl font-semibold">SAR {{ number_format($totalIncome,2) }}</div>
            </div>
            <div class="mt-2 flex gap-2">
                <a href="{{ route('rides.index') }}" class="px-2 py-1 bg-blue-600 text-white rounded text-sm">View Paid Rides</a>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="p-4 bg-white rounded shadow flex flex-col justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Total Expenses</div>
                <div class="text-xl font-semibold">SAR {{ number_format($totalExpenses,2) }}</div>
            </div>
            <div class="mt-2 flex gap-2">
                <a href="{{ route('expenses.create') }}" class="px-2 py-1 bg-green-600 text-white rounded text-sm">Add Expense</a>
                <a href="{{ route('expenses.index') }}" class="px-2 py-1 bg-blue-600 text-white rounded text-sm">View/Edit</a>
            </div>
        </div>
    </div>

    <!-- Monthly Savings / Income -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow flex flex-col justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Monthly Savings</div>
                <div class="text-2xl font-bold">SAR {{ number_format($monthlySavings,2) }}</div>
            </div>
        </div>

        <div class="p-4 bg-white rounded shadow flex flex-col justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Monthly Income</div>
                <div class="text-2xl font-bold">SAR {{ number_format($monthlyIncome,2) }}</div>
            </div>
        </div>
    </div>

    <!-- Latest Records (10) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Latest Riders -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Latest Riders</h3>
            <ul class="list-disc list-inside">
                @forelse($latestRiders as $rider)
                    <li>{{ $rider->name }}</li>
                @empty
                    <li>No riders found</li>
                @endforelse
            </ul>
        </div>

        <!-- Latest Rides -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Latest Rides</h3>
            <ul class="list-disc list-inside">
                @forelse($latestRides as $ride)
                    <li>{{ $ride->rider->name ?? '-' }}: {{ $ride->pickup_location }} → {{ $ride->drop_location }} (SAR {{ number_format($ride->fare,2) }})</li>
                @empty
                    <li>No rides found</li>
                @endforelse
            </ul>
        </div>

        <!-- Latest Expenses -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Latest Expenses</h3>
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-1 text-left">Title</th>
                        <th class="px-2 py-1 text-left">Amount</th>
                        <th class="px-2 py-1 text-left">Date</th>
                        <th class="px-2 py-1 text-left">Category</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestExpenses as $expense)
                        <tr class="border-t">
                            <td class="px-2 py-1">{{ $expense->title }}</td>
                            <td class="px-2 py-1">SAR {{ number_format($expense->amount, 2) }}</td>
                            <td class="px-2 py-1">{{ $expense->date ? \Carbon\Carbon::parse($expense->date)->format('Y-m-d') : '-' }}</td>
                            <td class="px-2 py-1">{{ $expense->category ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-2 py-1 text-center">No expenses found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
