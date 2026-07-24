@extends("layouts.app")

@section("content")
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 text-center">
            <h1 class="fw-bold mb-3">Upcoming Live Concerts</h1>
            <p class="text-muted mb-4">Discover your favorite artists, book tickets instantly, and experience unforgettable
                live music.</p>

            <!-- Search Form -->
            <form action="{{ route("home") }}" method="GET" class="input-group shadow-sm">
                <input type="text" name="search" class="form-control form-control-lg"
                    placeholder="Search by concert title, city, or venue..." value="{{ request("search") }}">
                <button class="btn btn-dark px-4" type="submit">Search</button>
                @if (request("search"))
                    <a href="{{ route("home") }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($concerts as $concert)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if ($concert->image)
                        <img src="{{ $concert->image }}" class="card-img-top" alt="{{ $concert->title }}"
                            style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="height: 200px;">
                            <span>No Image Available</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <span
                            class="badge bg-primary mb-2 align-self-start">{{ $concert->venue->city ?? "Location" }}</span>
                        <h5 class="card-title fw-bold">{{ $concert->title }}</h5>
                        <p class="card-text text-muted small mb-2">
                            📍 {{ $concert->venue->name ?? "Venue" }} <br>
                            📅 {{ \Carbon\Carbon::parse($concert->date_time)->format("M d, Y - h:i A") }}
                        </p>
                        <p class="card-text fw-bold text-success fs-5 mt-auto">Rs.
                            {{ number_format($concert->ticket_price, 2) }}</p>
                        <a href="{{ route("concerts.show", $concert->id) }}" class="btn btn-outline-dark w-100 mt-2">View
                            Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">No concerts found matching your search.</h4>
                <a href="{{ route("home") }}" class="btn btn-dark mt-3">View All Concerts</a>
            </div>
        @endforelse
    </div>
@endsection
