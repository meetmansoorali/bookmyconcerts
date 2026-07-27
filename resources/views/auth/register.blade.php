@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">

            <div class="text-center mb-5">
                <div class="mb-4">
                    <img src="{{ asset('build/assets/images/bookmyconcerts.png') }}" 
                         alt="Book My Concerts" 
                         class="mx-auto" 
                         style="width: 180px; height: auto; object-fit: contain;">
                </div>
                
                <h2 class="fw-bold" style="color:#1f2937;">Create Account</h2>
                <p class="text-muted">Join us and book your favorite concerts</p>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius:20px;">

                <div class="card-body p-5">

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-medium">Full Name</label>
                            <input id="name" type="text" name="name" 
                                   class="form-control form-control-lg" 
                                   value="{{ old('name') }}" 
                                   required autofocus autocomplete="name">
                            @error('name')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Email Address</label>
                            <input id="email" type="email" name="email" 
                                   class="form-control form-control-lg" 
                                   value="{{ old('email') }}" 
                                   required autocomplete="username">
                            @error('email')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Password</label>
                            <input id="password" type="password" name="password" 
                                   class="form-control form-control-lg" 
                                   required autocomplete="new-password">
                            @error('password')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-medium">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" 
                                   class="form-control form-control-lg" 
                                   required autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{ route('login') }}" class="text-decoration-none text-muted small">
                                Already have an account?
                            </a>
                            <button type="submit" class="btn px-5 py-3 fw-semibold text-white" 
                                    style="background:#22c55e; border-radius:50px;">
                                Create
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection