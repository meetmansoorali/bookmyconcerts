@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('my.tickets') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            
        </a>
        
    </div>
    <div class="ticket-container mx-auto" style="max-width: 720px;">
        <div class="ticket" style="background: white; border: 3px solid #1f2937; border-radius: 12px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.15); position: relative;">
            <div class="bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center" 
                 style="border-bottom: 4px dashed #22c55e;">
                <div>
                    <span class="badge px-3 py-1" style="background:#22c55e; color:white;">E-TICKET</span>
                    <h4 class="fw-bold mb-0 mt-1">Book My Concerts</h4>
                </div>
                <div class="text-end">
                    <small>Booking ID</small><br>
                    <strong class="font-monospace">#BMC-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong>
                </div>
            </div>

            <div class="p-5">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-3 text-dark">{{ $booking->concert->title }}</h2>
                        
                        <div class="mb-4">
                            <strong>Venue:</strong> {{ $booking->concert->venue->name }}<br>
                            <span class="text-muted">{{ $booking->concert->venue->address }}, {{ $booking->concert->venue->city }}</span>
                        </div>

                        <div class="row g-4">
                            <div class="col-6">
                                <small class="text-muted">DATE & TIME</small><br>
                                <strong>{{ \Carbon\Carbon::parse($booking->concert->date_time)->format('F d, Y') }}</strong><br>
                                <span class="text-muted">{{ \Carbon\Carbon::parse($booking->concert->date_time)->format('h:i A') }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">TICKET HOLDER</small><br>
                                <strong>{{ $booking->user->name }}</strong>
                            </div>
                        </div>

                        <div class="mt-5 d-flex gap-5">
                            <div>
                                <small class="text-muted">QUANTITY</small><br>
                                <span class="fs-4 fw-bold">{{ $booking->ticket_qty }} Ticket(s)</span>
                            </div>
                            <div>
                                <small class="text-muted">TOTAL PAID</small><br>
                                <span class="fs-4 fw-bold text-success">Rs. {{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mt-4 mt-md-0">
                        <div class="border p-3 bg-white rounded-3 shadow-sm mx-auto" style="width: 140px;">
                            <svg width="110" height="110" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zM14 2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4z" fill="#000"/>
                                <path d="M14 14h3v3h-3v-3zM17 17h3v3h-3v-3zM14 20h3v2h-3v-2zM20 14h2v3h-2v-3zM20 20h2v2h-2v-2z" fill="#000"/>
                            </svg>
                        </div>
                        <small class="text-muted d-block mt-3">SCAN AT ENTRY GATE</small>
                        <span class="badge bg-success px-4 py-2 mt-3 text-uppercase">{{ $booking->status }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-light py-3 text-center text-muted small" 
                 style="border-top: 4px dashed #22c55e;">
                Present this ticket with valid ID at the venue. Non-transferable. Enjoy the show!
            </div>
        </div>
    </div>

</div>

<style>
    @media print {
        .ticket { box-shadow: none; }
        nav, .btn { display: none !important; }
    }
</style>
@endsection