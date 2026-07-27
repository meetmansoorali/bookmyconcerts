@extends('layouts.app')

@section('content')
<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="p-5 mb-4 bg-dark text-white rounded-4 shadow-sm d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <span class="badge bg-success mb-2 px-3 py-2 rounded-pill fw-semibold">Founder & Team Access</span>
            <h1 class="display-6 fw-bold mb-2">Command Center</h1>
            <p class="text-muted mb-0">Manage global platform concerts, allot ticket pools, and control team permissions.</p>
        </div>
        <div class="mt-4 mt-md-0">
            <button class="btn btn-success btn-lg px-4 rounded-pill shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#addConcertModal">
                <i class="fas fa-plus-circle me-2"></i> Add Concert & Allot Tickets
            </button>
        </div>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-semibold">Total Revenue</span>
                    <div class="bg-success bg-opacity-15 p-3 rounded-circle text-success">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-success mb-0">Rs. {{ number_format($totalRevenue ?? 0, 2) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-semibold">Tickets Allotted & Sold</span>
                    <div class="bg-primary bg-opacity-15 p-3 rounded-circle text-primary">
                        <i class="fas fa-ticket-alt fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $totalTicketsSold ?? 0 }} <span class="fs-6 fw-normal text-muted">Tickets</span></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-semibold">Active Events</span>
                    <div class="bg-warning bg-opacity-15 p-3 rounded-circle text-warning">
                        <i class="fas fa-music fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ count($concerts) }} <span class="fs-6 fw-normal text-muted">Concerts</span></h3>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-users-cog me-2 text-success"></i> Team & Founder Access Control</h5>
            <small class="text-muted">Promote registered users to founders so they can access this command center.</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light text-uppercase fs-7 text-muted">
                        <tr>
                            <th class="py-3 ps-4">#</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Access Level</th>
                            <th class="py-3 pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                            <tr>
                                <td class="ps-4 fw-medium">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $u->name }}</td>
                                <td class="text-muted">{{ $u->email }}</td>
                                <td>
                                    @if($u->is_admin)
                                        <span class="badge bg-success bg-opacity-15 text-success px-3 py-2 rounded-pill fw-semibold">Founder / Team Admin</span>
                                    @else
                                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-normal">Standard User</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm px-3 rounded-pill fw-semibold {{ $u->is_admin ? 'btn-outline-danger' : 'btn-outline-success' }}">
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

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-clipboard-list me-2 text-success"></i> Global Platform Bookings</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light text-uppercase fs-7 text-muted">
                        <tr>
                            <th class="py-3 ps-4">#</th>
                            <th class="py-3">User</th>
                            <th class="py-3">Concert</th>
                            <th class="py-3">Venue</th>
                            <th class="py-3">Qty</th>
                            <th class="py-3">Amount</th>
                            <th class="py-3 pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr>
                                <td class="ps-4 fw-medium">{{ $index + 1 }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $booking->user->name }}</span><br>
                                    <small class="text-muted">{{ $booking->user->email }}</small>
                                </td>
                                <td class="fw-bold text-dark">{{ $booking->concert->title }}</td>
                                <td class="text-muted">{{ $booking->concert->venue->name ?? 'N/A' }}</td>
                                <td><span class="badge bg-secondary px-2 py-1">{{ $booking->ticket_qty }}</span></td>
                                <td class="fw-bold text-success">Rs. {{ number_format($booking->total_amount, 2) }}</td>
                                <td class="pe-4"><span class="badge bg-success text-uppercase px-2 py-1">{{ $booking->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No platform bookings recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Add Concert & Allocate Tickets Modal -->
<div class="modal fade" id="addConcertModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('admin.concerts.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-dark text-white px-4 py-3">
                    <h5 class="modal-title fw-bold">Create Concert & Allot Ticket Pool</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Concert Title</label>
                        <input type="text" name="title" class="form-control form-control-lg fs-6" value="{{ old('title') }}" placeholder="e.g., Summer Rock Festival 2026" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Venue Location</label>
                        <select name="venue_id" class="form-select form-select-lg fs-6" required>
                            <option value="">Select Venue</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->name }} ({{ $venue->city }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date & Time</label>
                            <input type="datetime-local" name="date_time" class="form-control form-control-lg fs-6" value="{{ old('date_time') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Ticket Price (Rs.)</label>
                            <input type="number" step="0.01" name="ticket_price" class="form-control form-control-lg fs-6" value="{{ old('ticket_price') }}" placeholder="1500" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Total Tickets to Allot</label>
                            <input type="number" name="total_tickets" class="form-control form-control-lg fs-6" value="{{ old('total_tickets') }}" placeholder="500" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Cover Image URL</label>
                            <input type="url" name="image" class="form-control form-control-lg fs-6" value="{{ old('image') }}" placeholder="https://images.unsplash.com/...">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Event Description</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Provide details about line-up, gate opening times, rules, etc.">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 pb-4 border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-5 fw-semibold">Publish & Allot Tickets</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection