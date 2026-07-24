<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concert;
use App\Models\Booking;

class BookingController extends Controller
{
    public function store(Request $request, $concertId)
    {
        $request->validate([
            'ticket_qty' => 'required|integer|min:1|max:10',
        ]);

        $concert = Concert::findOrFail($concertId);

        if ($concert->total_tickets < $request->ticket_qty) {
            return back()->with('error', 'Sorry! Not enough tickets available.');
        }

        $totalAmount = $concert->ticket_price * $request->ticket_qty;

        Booking::create([
            'user_id' => auth()->id(),
            'concert_id' => $concert->id,
            'ticket_qty' => $request->ticket_qty,
            'total_amount' => $totalAmount,
            'status' => 'confirmed'
        ]);

        $concert->decrement('total_tickets', $request->ticket_qty);

        return redirect()->route('my.tickets')->with('success', 'Tickets booked successfully!');
    }

    public function index()
    {
        $bookings = Booking::with('concert.venue')->where('user_id', auth()->id())->latest()->get();
        return view('bookings.index', compact('bookings'));
    }
}