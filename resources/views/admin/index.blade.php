@extends('layouts.app')
@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold mb-1" style="color:#1f2937;">Founder & Team Command Center</h2>
            <p class="text-muted mb-0">Manage platform events, allocate tickets, and monitor global sales.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <button class="btn px-5 py-3 fw-semibold text-white" 
                    style="background:#22c55e; border-radius:50px;" 
                    data-bs-toggle="modal" data-bs-target="#addConcertModal">
                + Add Concert and Allot Tickets
            </button>
        </div>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <small class="text-muted fw-semibold">Total Revenue</small>
                <h3 class="fw-bold mb-0 mt-2" style="color:#22c55e;">
                    Rs. {{ number_format($totalRevenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <small class="text-muted fw-semibold">Tickets Allotted & Sold</small>
                <h3 class="fw-bold text-dark mb-0 mt-2">
                    {{ $totalTicketsSold ?? 0 }} Tickets
                </h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <small class="text-muted fw-semibold">Active Concerts</small>
                <h3 class="fw-bold text-dark mb-0 mt-2">
                    {{ count($concerts) }} Events
                </h3>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">Manage Concerts & Inventory</h5>
                <small class="text-muted">View active concert listings and remove events when necessary.</small>
            </div>
           
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light text-uppercase small text-muted">
                        <tr>
                            <th class="py-3 ps-4">#</th>
                            <th class="py-3">Concert Title</th>
                            <th class="py-3">Venue</th>
                            <th class="py-3">Date & Time</th>
                            <th class="py-3">Price</th>
                            <th class="py-3">Tickets Left</th>
                            <th class="py-3 pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($concerts as $index => $concert)
                            <tr>
                                <td class="ps-4 fw-medium">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $concert->title }}</td>
                                <td class="text-muted">{{ $concert->venue->name ?? 'N/A' }}</td>
                                <td class="text-muted">{{ \Carbon\Carbon::parse($concert->date_time)->format('M d, Y - h:i A') }}</td>
                                <td class="fw-bold" style="color:#22c55e;">
                                    Rs. {{ number_format($concert->ticket_price, 2) }}
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 {{ $concert->total_tickets > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $concert->total_tickets }} Available
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <form action="{{ route('admin.concerts.destroy', $concert->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this concert? All associated bookings will also be removed.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    No concerts found. Create one using the button above.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-dark text-white py-4 px-4">
            <h5 class="mb-0 fw-bold">Global Platform Bookings</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>User</th>
                            <th>Concert</th>
                            <th>Venue</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th class="pe-4 text-end">Status / Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr>
                                <td class="ps-4">{{ $index + 1 }}</td>
                                <td>
                                    {{ $booking->user->name }}
                                    <br><small class="text-muted">{{ $booking->user->email }}</small>
                                </td>
                                <td class="fw-bold">{{ $booking->concert->title }}</td>
                                <td>{{ $booking->concert->venue->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $booking->ticket_qty }}</span>
                                </td>
                                <td class="fw-bold" style="color:#22c55e;">
                                    Rs. {{ number_format($booking->total_amount, 2) }}
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <span class="badge bg-success text-uppercase px-3 py-2">
                                            {{ $booking->status }}
                                        </span>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this booking permanently? Tickets will be restocked.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2" title="Delete Booking">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    No bookings recorded on the platform yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-dark text-white py-4 px-4">
            <h5 class="mb-0 fw-bold">Team & Founder Access Control</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Access Level</th>
                            <th class="pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                            <tr>
                                <td class="ps-4">{{ $index + 1 }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    @if($u->is_admin)
                                        <span class="badge bg-success">Founder / Team Admin</span>
                                    @else
                                        <span class="badge bg-secondary">Standard User</span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm {{ $u->is_admin ? 'btn-outline-danger' : 'btn-outline-success' }} rounded-pill px-3">
                                            {{ $u->is_admin ? 'Revoke Access' : 'Grant Founder Access' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="addConcertModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0" style="border-radius:20px;">
            <form action="{{ route('admin.concerts.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-dark text-white px-4 border-0">
                    <h5 class="modal-title fw-bold">Create Concert & Allot Ticket Pool</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-5">
                    <div class="mb-4">
                        <label class="form-label fw-medium">Concert Title</label>
                        <input type="text" name="title" class="form-control form-control-lg" 
                               value="{{ old('title') }}" placeholder="e.g., Summer Rock Festival" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Venue Location</label>
                        <select name="venue_id" class="form-select form-select-lg" required>
                            <option value="">Select Venue</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->name }} ({{ $venue->city }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Date & Time</label>
                            <input type="datetime-local" name="date_time" class="form-control form-control-lg" 
                                   value="{{ old('date_time') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Ticket Price (Rs.)</label>
                            <input type="number" step="0.01" name="ticket_price" class="form-control form-control-lg" 
                                   value="{{ old('ticket_price') }}" placeholder="1500" required>
                        </div>
                    </div>

                    <div class="row g-4 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Total Tickets to Allot</label>
                            <input type="number" name="total_tickets" class="form-control form-control-lg" 
                                   value="{{ old('total_tickets') }}" placeholder="500" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Cover Image URL</label>
                            <input type="url" name="image" class="form-control form-control-lg" 
                                   value="{{ old('image') }}" placeholder="https://images.unsplash.com/...">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="form-label fw-medium">Event Description</label>
                        <textarea name="description" rows="4" class="form-control form-control-lg" 
                                  placeholder="Provide details about the line-up, gates open time, etc.">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-5 fw-semibold text-white" style="background:#22c55e;">
                        Publish & Allot Tickets
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection