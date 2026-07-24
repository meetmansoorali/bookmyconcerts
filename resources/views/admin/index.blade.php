@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2 class="fw-bold">Admin Dashboard</h2>
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addConcertModal">+ Add New Concert</button>
    </div>
</div>

<!-- All Bookings Table Section -->
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-dark text-white py-3">
        <h5 class="mb-0 fw-bold">All User Bookings</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Concert</th>
                        <th>Venue</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $booking->user->name }} <br><small class="text-muted">{{ $booking->user->email }}</small></td>
                            <td class="fw-bold">{{ $booking->concert->title }}</td>
                            <td>{{ $booking->concert->venue->name }}</td>
                            <td><span class="badge bg-secondary">{{ $booking->ticket_qty }}</span></td>
                            <td class="fw-bold text-success">Rs. {{ number_format($booking->total_amount, 2) }}</td>
                            <td><span class="badge bg-success text-uppercase">{{ $booking->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No bookings found in the system yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Concert Modal -->
<div class="modal fade" id="addConcertModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.concerts.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Add New Concert</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Concert Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Venue</label>
                        <select name="venue_id" class="form-select" required>
                            <option value="">Select Venue</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}">{{ $venue->name }} ({{ $venue->city }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date & Time</label>
                            <input type="datetime-local" name="date_time" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ticket Price (Rs.)</label>
                            <input type="number" step="0.01" name="ticket_price" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Tickets Available</label>
                            <input type="number" name="total_tickets" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image URL (Unsplash or direct link)</label>
                            <input type="url" name="image" class="form-control" placeholder="https://...">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Save Concert</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection