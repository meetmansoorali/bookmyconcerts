@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h2 class="fw-bold mb-5 text-center" style="color:#1f2937;">My Booked Tickets</h2>

    @if($bookings->count() > 0)
        <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow:hidden;">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead style="background:#1f2937; color:white;">
                        <tr>
                            <th class="py-4">Concert</th>
                            <th class="py-4 text-center">Tickets</th>
                            <th class="py-4">Total Amount</th>
                            <th class="pe-5 py-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td class="fw-semibold">{{ $booking->concert->title }}</td>
                         
                                
                                <td class="text-center">
                                    <span class="badge px-3 py-2" style="background:#22c55e; color:white;">
                                        {{ $booking->ticket_qty }}
                                    </span>
                                </td>
                                <td class="fw-bold" style="color:#22c55e;">
                                    Rs. {{ number_format($booking->total_amount, 2) }}
                                </td>
                               
                                <td class="pe-5 text-end">
                                    <a href="{{ route('my.tickets.show', $booking->id) }}" 
                                       class="btn btn-dark px-4 py-2">
                                        View
                                    </a>
                                </td>

                                <td>
                                    <form action="{{ route('my.tickets.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold">
        <i class="fas fa-trash-alt me-1"></i> Cancel Booking
    </button>
</form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm border">
            <div class="mb-4">
                <i class="fas fa-ticket-alt fa-5x text-muted opacity-25"></i>
            </div>
            <h4 class="text-muted mb-2">You haven't booked any tickets yet!</h4>
            <p class="text-secondary">Explore our upcoming concerts and secure your spots today.</p>
            <a href="{{ route('home') }}" class="btn btn-dark mt-4 px-5 py-3">
                Browse Concerts
            </a>
        </div>
    @endif

</div>
@endsection