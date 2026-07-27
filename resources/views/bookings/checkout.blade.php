@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="fw-bold text-center mb-5" style="color:#1f2937;">Secure Checkout</h2>

            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow:hidden;">
                <div class="card-body p-5">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-receipt"></i> Order Summary
                    </h5>

                    <div class="bg-light p-4 rounded-3 mb-5">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Concert</span>
                            <span class="fw-semibold">{{ $concert->title }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Venue</span>
                            <span>{{ $concert->venue->name }} ({{ $concert->venue->city }})</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Ticket Price</span>
                            <span>Rs. {{ number_format($concert->ticket_price, 2) }} × {{ $qty }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-3 mt-2 fw-bold fs-5" style="color:#22c55e;">
                            <span>Total Amount</span>
                            <span>Rs. {{ number_format($totalAmount, 2) }}</span>
                        </div>
                    </div>
                    <form action="{{ route('concerts.pay', $concert->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="ticket_qty" value="{{ $qty }}">

                        <h5 class="fw-bold mb-4">Payment Details (Fictional)</h5>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Cardholder Name</label>
                            <input type="text" name="card_name" class="form-control form-control-lg" 
                                   placeholder="John Doe" value="Test User" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Card Number</label>
                            <input type="text" name="card_number" class="form-control form-control-lg" 
                                   placeholder="1234 5678 9012 3456" value="4242424242424242" maxlength="19" required>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Expiry Date</label>
                                <input type="text" class="form-control form-control-lg" 
                                       placeholder="MM/YY" value="12/28" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">CVV</label>
                                <input type="password" class="form-control form-control-lg" 
                                       placeholder="123" value="123" maxlength="4" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 mt-5 py-4 fw-bold" 
                                style="background:#22c55e; color:white; border-radius:16px;">
                            Pay Rs. {{ number_format($totalAmount, 2) }} & Confirm Booking
                        </button>
                    </form>

                    <div class="text-center text-muted small mt-4">
                         Secure Encrypted Payment
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection