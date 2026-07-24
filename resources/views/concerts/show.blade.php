@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm mb-3">&larr; Back to Catalog</a>
        
        <div class="card shadow-sm border-0 mb-4">
            @if($concert->image)
                <img src="{{ $concert->image }}" class="card-img-top" alt="{{ $concert->title }}" style="height: 350px; object-fit: cover;">
            @endif
            <div class="card-body p-4">
                <span class="badge bg-primary mb-2">{{ $concert->venue->city }}</span>
                <h1 class="fw-bold text-dark">{{ $concert->title }}</h1>
                <p class="text-muted mb-4">
                    <strong>Venue:</strong> {{ $concert->venue->name }} ({{ $concert->venue->address }})<br>
                    <strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($concert->date_time)->format('F d, Y - h:i A') }}<br>
                    <strong>Available Tickets:</strong> <span class="badge bg-{{ $concert->total_tickets > 0 ? 'success' : 'danger' }}">{{ $concert->total_tickets }} left</span>
                </p>

                <hr>

                <h5 class="fw-bold mb-3">About the Concert</h5>
                <p class="text-secondary">{{ $concert->description }}</p>

                <div class="bg-light p-4 rounded mt-4">
                    <h4 class="fw-bold text-success mb-3">Rs. {{ number_format($concert->ticket_price, 2) }} <span class="text-muted fs-6 fw-normal">per ticket</span></h4>

                    @auth
                        @if($concert->total_tickets > 0)
<form action="{{ route('concerts.checkout', $concert->id) }}" method="GET">
    <div class="mb-3 row align-items-center">
        <label for="ticket_qty" class="col-sm-4 col-form-label fw-bold">Number of Tickets:</label>
        <div class="col-sm-4">
            <input type="number" name="ticket_qty" id="ticket_qty" class="form-control" value="1" min="1" max="{{ min(10, $concert->total_tickets) }}" required>
        </div>
    </div>
    <button type="submit" class="btn btn-dark btn-lg w-100">Proceed to Checkout</button>
</form>
                        @else
                            <div class="alert alert-danger mb-0">Sold Out! No tickets available for this event.</div>
                        @endif
                    @else
                        <div class="text-center py-2">
                            <p class="text-muted mb-2">Please login or register to book tickets for this concert.</p>
                            <a href="{{ route('login') }}" class="btn btn-dark me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-dark">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection