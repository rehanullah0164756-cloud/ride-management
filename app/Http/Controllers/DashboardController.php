<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rider;
use App\Models\Ride;
use App\Models\Expense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get month/year from filter, default to current month/year
        $month = $request->input('month', now()->month);
        $year  = $request->input('year', now()->year);

        // Total counts
        $totalRiders   = $user->riders()->count();
        $totalRides    = $user->rides()->count();
        $totalIncome   = $user->rides()->where('payment_status', 'paid')->sum('fare');
        $totalExpenses = $user->expenses()->sum('amount');
        $savings       = $totalIncome - $totalExpenses;

        // Monthly income/expenses based on selected month/year
        $monthlyIncome   = $user->rides()
            ->where('payment_status', 'paid')
            ->whereMonth('ride_date', $month)
            ->whereYear('ride_date', $year)
            ->sum('fare');

        $monthlyExpenses = $user->expenses()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        $monthlySavings = $monthlyIncome - $monthlyExpenses;

        // Latest 10 records (filtered by month/year)
        $latestRiders = $user->riders()
            ->latest()
            ->take(10)
            ->get();

        $latestRides = $user->rides()
            ->whereMonth('ride_date', $month)
            ->whereYear('ride_date', $year)
            ->latest()
            ->take(10)
            ->get();

        $latestExpenses = $user->expenses()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalRiders',
            'totalRides',
            'totalIncome',
            'totalExpenses',
            'savings',
            'monthlyIncome',
            'monthlyExpenses',
            'monthlySavings',
            'latestRiders',
            'latestRides',
            'latestExpenses',
            'month',
            'year'
        ));
    }
}
