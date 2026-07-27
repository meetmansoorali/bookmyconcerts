@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Concerts
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                @if($concert->image)
                    <img src="{{ $concert->image }}" 
                         class="card-img-top w-100" 
                         alt="{{ $concert->title }}" 
                         style="height: 380px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 380px;">
                        <i class="fas fa-music fa-5x text-secondary opacity-25"></i>
                    </div>
                @endif

                <div class="card-body p-5">
                    <span class="badge px-4 py-2 mb-3" style="background:#22c55e; color:white; font-size:1rem;">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        {{ $concert->venue->city ?? 'Location' }}
                    </span>
                    <h1 class="fw-bold display-5 mb-4" style="color:#1f2937;">{{ $concert->title }}</h1>

                    <div class="row g-4 text-muted mb-5">
                        <div class="col-sm-4">
                            <div class="d-flex align-items-start gap-3">
                                <i class="fas fa-building fs-4 mt-1" style="color:#22c55e;"></i>
                                <div>
                                    <div class="fw-semibold text-dark">Venue</div>
                                    <div>{{ $concert->venue->name }}</div>
                                    <small>{{ $concert->venue->address ?? '' }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-start gap-3">
                                <i class="fas fa-calendar-alt fs-4 mt-1" style="color:#22c55e;"></i>
                                <div>
                                    <div class="fw-semibold text-dark">Date & Time</div>
                                    <div>{{ \Carbon\Carbon::parse($concert->date_time)->format('F d, Y - h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-start gap-3">
                                <i class="fas fa-ticket-alt fs-4 mt-1" style="color:#22c55e;"></i>
                                <div>
                                    <div class="fw-semibold text-dark">Tickets Left</div>
                                    <span class="badge fs-6 {{ $concert->total_tickets > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $concert->total_tickets }} Available
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5">

                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-info-circle text-success"></i>
                        About the Concert
                    </h5>
                    <p class="text-secondary lead" style="line-height: 1.7;">
                        {{ $concert->description }}
                    </p>

                    <div class="mt-5 bg-light p-5 rounded-4">
                        <div class="d-flex flex-wrap align-items-end gap-4 mb-4">
                            <div>
                                <small class="text-muted">Ticket Price</small>
                                <h2 class="fw-bold mb-0" style="color:#22c55e;">
                                    Rs. {{ number_format($concert->ticket_price, 0) }}
                                </h2>
                            </div>
                            <small class="text-muted">per ticket</small>
                        </div>

                        @auth
                            @if($concert->total_tickets > 0)
                                <form action="{{ route('concerts.checkout', $concert->id) }}" method="GET">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-sm-5">
                                            <label class="fw-bold mb-2 d-block">Number of Tickets</label>
                                            <input type="number" name="ticket_qty" 
                                                   class="form-control form-control-lg" 
                                                   value="1" min="1" 
                                                   max="{{$concert->total_tickets}}" required>
                                            <small class="text-muted mt-1 d-block">Max available: {{ $concert->total_tickets }}</small>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-dark btn-lg w-100 py-3 fw-semibold">
                                        <i class="fas fa-ticket-alt me-2"></i>
                                        Proceed to Checkout
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-danger text-center py-4 fs-5">
                                    <i class="fas fa-times-circle fa-2x d-block mb-3"></i>
                                    Sorry, this event is sold out!
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-4">Login or register to book tickets</p>
                                <a href="{{ route('login') }}" class="btn btn-dark btn-lg me-3 px-5">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-dark btn-lg px-5">Register</a>
                            </div>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection