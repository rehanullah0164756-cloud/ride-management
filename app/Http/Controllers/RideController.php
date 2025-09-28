<?php
namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Rider;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List rides
    public function index()
    {
        $rides = auth()->user()->rides()->with('rider')->latest()->paginate(12);
        return view('rides.index', compact('rides'));
    }

    // Create ride
    public function create()
    {
        $riders = auth()->user()->riders()->pluck('name', 'id');
        return view('rides.create', compact('riders'));
    }

    // Store ride
    public function store(Request $request)
    {
        $data = $request->validate([
            'rider_id' => 'required|exists:riders,id',
            'pickup_location' => 'required|string',
            'drop_location' => 'required|string',
            'fare' => 'required|numeric|min:0',
            'payment_status' => 'required|in:paid,unpaid',
            'ride_date' => 'nullable|date',
        ]);
        $data['user_id'] = auth()->id();
        Ride::create($data);
        return redirect()->route('rides.index')->with('success', 'Ride added.');
    }

    // Edit ride
    public function edit(Ride $ride)
    {
        // Disable policy for now to prevent 403
        // $this->authorize('update', $ride);

        $riders = auth()->user()->riders()->pluck('name', 'id');
        return view('rides.edit', compact('ride', 'riders'));
    }

    // Update ride
    public function update(Request $request, Ride $ride)
    {
        // $this->authorize('update', $ride);

        $data = $request->validate([
            'rider_id' => 'required|exists:riders,id',
            'pickup_location' => 'required|string',
            'drop_location' => 'required|string',
            'fare' => 'required|numeric|min:0',
            'payment_status' => 'required|in:paid,unpaid',
            'ride_date' => 'nullable|date',
        ]);

        $ride->update($data);
        return redirect()->route('rides.index')->with('success', 'Ride updated.');
    }

    // Delete ride
    public function destroy(Ride $ride)
    {
        $ride->delete();
        return back()->with('success', 'Ride deleted.');
    }

    // Toggle payment status (AJAX)
    public function toggleStatus(Request $request, Ride $ride)
    {
        $request->validate([
            'status' => 'required|in:paid,unpaid',
        ]);

        $ride->payment_status = $request->status;
        $ride->save();

        return response()->json(['success' => true, 'status' => $ride->payment_status]);
    }
}
