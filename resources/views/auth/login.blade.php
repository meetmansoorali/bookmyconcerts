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
                
                <h2 class="fw-bold" style="color:#1f2937;">Welcome Back</h2>
                <p class="text-muted">Sign in to enjoy concerts</p>
            </div>
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card border-0 shadow-sm" style="border-radius:20px;">

                <div class="card-body p-5">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-medium">Email Address</label>
                            <input id="email" type="email" name="email" 
                                   class="form-control form-control-lg" 
                                   value="{{ old('email') }}" 
                                   required autofocus autocomplete="username">
                            @error('email')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Password</label>
                            <input id="password" type="password" name="password" 
                                   class="form-control form-control-lg" 
                                   required autocomplete="current-password">
                            @error('password')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" id="remember" 
                                   class="form-check-input">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none text-muted small">
                                    Forgot your password?
                                </a>
                            @endif

                            <button type="submit" class="btn px-5 py-3 fw-semibold text-white" 
                                    style="background:#22c55e; border-radius:50px;">
                                Log In
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="text-center mt-4">
                <span class="text-muted">Don't have an account?</span> 
                <a href="{{ route('register') }}" class="text-decoration-none fw-medium">Register now</a>
            </div>

        </div>
    </div>
</div>
@endsection