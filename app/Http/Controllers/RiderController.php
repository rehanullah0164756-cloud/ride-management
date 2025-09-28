<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use Illuminate\Http\Request;

class RiderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // ensure only logged-in users can access
    }

    // List all riders for the logged-in user
    public function index()
    {
        $riders = auth()->user()->riders()->latest()->paginate(12);
        return view('riders.index', compact('riders'));
    }

    // Show form to create a new rider
    public function create()
    {
        return view('riders.create');
    }

    // Store new rider
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'nullable|email|max:255',
            'phone'=> 'nullable|string|max:50',
            'address'=>'nullable|string',
        ]);

        $data['user_id'] = auth()->id(); // associate rider with current user
        Rider::create($data);

        return redirect()->route('riders.index')->with('success','Rider added.');
    }

    // Show a single rider and its rides
    public function show(Rider $rider)
    {
        // Removed $this->authorize() to fix 403 issue
        $rides = $rider->rides()->latest()->get();
        return view('riders.show', compact('rider','rides'));
    }

    // Show form to edit a rider
    public function edit(Rider $rider)
    {
        return view('riders.edit', compact('rider'));
    }

    // Update rider details
    public function update(Request $request, Rider $rider)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'nullable|email',
            'phone'=>'nullable|string',
            'address'=>'nullable|string'
        ]);

        $rider->update($data);

        return redirect()->route('riders.index')->with('success','Rider updated.');
    }

    // Delete a rider
    public function destroy(Rider $rider)
    {
        $rider->delete();
        return back()->with('success','Rider deleted.');
    }
}
