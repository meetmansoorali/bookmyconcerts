<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3 border-bottom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-3" href="{{ url('/') }}">
            <img src="{{ asset('build/assets/images/bookmyconcerts.png') }}" 
                 alt="Logo" class="rounded" style="width:150px; object-fit:contain;">
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                @auth
                    @if(Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3 text-success d-flex align-items-center gap-1" href="{{ route('admin.dashboard') }}">
                                Command Center
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3 text-dark" href="{{ route('my.tickets') }}">My Tickets</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-medium text-dark px-3" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                            @if(Auth::user()->is_admin)
                                <span class="badge bg-success ms-1" style="font-size: 0.65rem;">Founder</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2" style="border-radius:16px;">
                            @if(Auth::user()->is_admin)
                                <li>
                                    <a class="dropdown-item py-2 text-success fw-semibold" href="{{ route('admin.dashboard') }}">
                                        Admin Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-dark fw-medium px-4 me-3" href="{{ route('login') }}" style="background:#1f2937; color:white; border-radius:50px;">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn text-white fw-medium px-5 py-2" 
                           style="background:#22c55e; border-radius:50px;" 
                           href="{{ route('register') }}">Register</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>