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

    public function checkout(Request $request, $concertId)
    {
        $request->validate([
            'ticket_qty' => 'required|integer|min:1|max:10',
        ]);

        $concert = Concert::with('venue')->findOrFail($concertId);
        $qty = $request->ticket_qty;
        
        if ($concert->total_tickets < $qty) {
            return back()->with('error', 'Sorry! Not enough tickets available.');
        }

        $totalAmount = $concert->ticket_price * $qty;

        return view('bookings.checkout', compact('concert', 'qty', 'totalAmount'));
    }

    public function processPayment(Request $request, $concertId)
    {
        $request->validate([
            'ticket_qty' => 'required|integer|min:1',
            'card_name' => 'required|string|max:255',
            'card_number' => 'required|string|size:16',
        ]);

        $concert = Concert::findOrFail($concertId);
        $qty = $request->ticket_qty;

        if ($concert->total_tickets < $qty) {
            return redirect()->route('home')->with('error', 'Sorry, tickets sold out while you were checking out!');
        }

        $totalAmount = $concert->ticket_price * $qty;

        Booking::create([
            'user_id' => auth()->id(),
            'concert_id' => $concert->id,
            'ticket_qty' => $qty,
            'total_amount' => $totalAmount,
            'status' => 'confirmed'
        ]);

        $concert->decrement('total_tickets', $qty);

        return redirect()->route('my.tickets')->with('success', 'Fictional payment successful! Tickets booked.');
    }
}