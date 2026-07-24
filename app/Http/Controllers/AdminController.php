<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Concert;
use App\Models\Venue;

class AdminController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'concert.venue')->latest()->get();
        $concerts = Concert::with('venue')->latest()->get();
        $venues = Venue::all();
        
        return view('admin.index', compact('bookings', 'concerts', 'venues'));
    }

    public function storeConcert(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_time' => 'required|date',
            'ticket_price' => 'required|numeric|min:0',
            'total_tickets' => 'required|integer|min:1',
            'image' => 'nullable|url',
        ]);

        Concert::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Concert added successfully!');
    }
}