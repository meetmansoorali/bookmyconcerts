@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="fw-bold mb-4">My Booked Tickets</h2>

        @if($bookings->count() > 0)
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Concert</th>
                                    <th>Venue & City</th>
                                    <th>Date & Time</th>
                                    <th>Tickets</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $index => $booking)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-bold">{{ $booking->concert->title }}</td>
                                        <td>{{ $booking->concert->venue->name }} ({{ $booking->concert->venue->city }})</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->concert->date_time)->format('M d, Y - h:i A') }}</td>
                                        <td><span class="badge bg-secondary">{{ $booking->ticket_qty }}</span></td>
                                        <td class="fw-bold text-success">Rs. {{ number_format($booking->total_amount, 2) }}</td>
                                        <td><span class="badge bg-success text-uppercase">{{ $booking->status }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5 bg-white rounded shadow-sm">
                <h4 class="text-muted">You haven't booked any tickets yet!</h4>
                <p class="text-secondary small">Explore our upcoming concerts and secure your spots today.</p>
                <a href="{{ route('home') }}" class="btn btn-dark mt-2">Browse Concerts</a>
            </div>
        @endif
    </div>
</div>
@endsection