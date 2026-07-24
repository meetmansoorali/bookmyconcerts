@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <h2 class="fw-bold mb-4">Secure Checkout (Fictional Payment)</h2>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Order Summary</h5>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Concert: <span class="fw-bold">{{ $concert->title }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Venue: <span>{{ $concert->venue->name }} ({{ $concert->venue->city }})</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Ticket Price: <span>Rs. {{ number_format($concert->ticket_price, 2) }} × {{ $qty }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 fw-bold fs-5 text-success">
                        Total Amount: <span>Rs. {{ number_format($totalAmount, 2) }}</span>
                    </li>
                </ul>

                <hr>

                <form action="{{ route('concerts.pay', $concert->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="ticket_qty" value="{{ $qty }}">

                    <h5 class="fw-bold mb-3">Mock Payment Details</h5>
                    <div class="mb-3">
                        <label class="form-label">Cardholder Name</label>
                        <input type="text" name="card_name" class="form-control" placeholder="John Doe" value="Test User" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Card Number (16 digits)</label>
                        <input type="text" name="card_number" class="form-control" placeholder="1234567812345678" value="4242424242424242" maxlength="16" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="text" class="form-control" placeholder="MM/YY" value="12/28" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CVV</label>
                            <input type="password" class="form-control" placeholder="123" value="123" maxlength="3" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 mt-3">Pay Rs. {{ number_format($totalAmount, 2) }} & Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection