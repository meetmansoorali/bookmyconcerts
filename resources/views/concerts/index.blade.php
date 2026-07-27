@extends("layouts.app")

@section("content")
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold display-4 mb-3" style="color:#1f2937;">
            Discover <span class="brand-green">Live Music</span>
        </h1>
        <div class="overflow-hidden" style="height: 60px;">
            <p id="animated-text" class="lead text-muted fw-medium" 
               style="transition: all 0.6s ease;">
            </p>
        </div>
    </div>
    <div class="mb-5">
        <form action="{{ route("home") }}" method="GET" 
              class="d-flex shadow-lg border rounded-4 overflow-hidden bg-white mx-auto" 
              style="max-width: 720px;">
            
            <div class="flex-grow-1 position-relative">
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-5 text-muted fs-4"></i>
                <input type="text" name="search" 
                       class="form-control form-control-lg border-0 ps-5 py-4 fs-5"
                       placeholder="        Search artists, concerts, venues or cities..." 
                       value="{{ request("search") }}">
            </div>

            <button class="btn px-5 fw-semibold" 
                    style="background:#22c55e; color:white; border-radius: 0 14px 14px 0;" 
                    type="submit">
                Search
            </button>
        </form>
    </div>
    <div class="row g-3">
        @forelse($concerts as $concert)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 18px;">
                    
                    @if ($concert->image)
                        <img src="{{ $concert->image }}" 
                             class="card-img-top" 
                             alt="{{ $concert->title }}"
                             style="height: 180px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                            <i class="fas fa-music fa-3x text-secondary opacity-25"></i>
                        </div>
                    @endif

                    <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-map-marker-alt text-success"></i>
                            <small class="fw-medium text-success">{{ $concert->venue->city ?? 'Location' }}</small>
                        </div>

                        <h6 class="fw-bold mb-3 text-truncate" style="font-size: 1.05rem; line-height:1.3;">
                            {{ $concert->title }}
                        </h6>

                        <div class="small text-muted mb-3">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($concert->date_time)->format("d M, h:i A") }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-building"></i>
                                <span class="text-truncate">{{ $concert->venue->name ?? 'Venue' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-auto pt-2">
                            <div class="fw-bold fs-5" style="color:#22c55e;">
                                Rs. {{ number_format($concert->ticket_price, 0) }}
                            </div>
                            <a href="{{ route("concerts.show", $concert->id) }}" 
                               class="btn btn-sm px-4 py-2 text-white fw-semibold"
                               style="background:#1f2937; border-radius: 50px; font-size: 0.95rem;">
                                Book
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-4"></i>
                <h5 class="text-muted">No concerts found</h5>
                <a href="{{ route("home") }}" class="btn btn-dark mt-3 px-5 py-3 rounded-4">
                    View All
                </a>
            </div>
        @endforelse
    </div>
</div>

<style>
    .brand-green { color: #22c55e; }

    /* Search Bar Hover Effect */
    form:hover {
        box-shadow: 0 20px 40px rgba(34, 197, 94, 0.15) !important;
    }

    /* Animated Text */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    const texts = [
        "Experience the magic of live music",
        "Book tickets in seconds",
        "Unforgettable moments await"
    ];
    let index = 0;
    const animatedText = document.getElementById('animated-text');

    function changeText() {
        animatedText.style.opacity = 0;
        setTimeout(() => {
            animatedText.textContent = texts[index];
            animatedText.style.animation = 'fadeInUp 0.8s ease forwards';
            index = (index + 1) % texts.length;
        }, 400);
    }

    // Start animation
    setTimeout(() => {
        changeText();
        setInterval(changeText, 4000);
    }, 800);
</script>

@endsection