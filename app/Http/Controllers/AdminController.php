<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Concert;
use App\Models\Venue;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $concerts = Concert::with('venue', 'user')->latest()->get();
        $bookings = Booking::with('user', 'concert.venue')->latest()->get();
        $venues = Venue::all();
        $users = User::all();

        $totalRevenue = $bookings->where('status', 'confirmed')->sum('total_amount');
        $totalTicketsSold = $bookings->where('status', 'confirmed')->sum('ticket_qty');

        return view('admin.index', compact('concerts', 'bookings', 'venues', 'users', 'totalRevenue', 'totalTicketsSold'));
    }

    public function storeConcert(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'venue_id' => 'required|exists:venues,id',
            'date_time' => 'required|date',
            'ticket_price' => 'required|numeric|min:0',
            'total_tickets' => 'required|integer|min:1',
            'image' => 'nullable|url',
        ]);

        Concert::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'venue_id' => $request->venue_id,
            'description' => $request->description,
            'date_time' => $request->date_time,
            'ticket_price' => $request->ticket_price,
            'total_tickets' => $request->total_tickets,
            'image' => $request->image,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Concert & ticket pool created successfully!');
    }

    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->is_admin = !$user->is_admin;
        $user->save();

        return redirect()->back()->with('success', 'Team member access updated successfully!');
    }

    public function destroyConcert($id)
{
    $concert = Concert::findOrFail($id);
    
    $concert->bookings()->delete();
    
    $concert->delete();

    return redirect()->back()->with('success', 'Concert and its associated bookings deleted successfully.');
}
}