    <footer class="bg-white border-top mt-auto py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset('build/assets/images/bookmyconcerts.png') }}" 
                             alt="Book My Concerts" 
                             style="width: 160px; height: auto; object-fit: contain;">
                    </div>
                    <p class="text-muted"> platform for booking live concerts and unforgettable music experiences.</p>
                </div>

                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Upcoming Concerts</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Cities</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Company</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Contact</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Careers</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold mb-3 text-dark">Stay Connected</h6>
                    <p class="text-muted small mb-3">Get updates on new concerts and offers.</p>
                    <div class="input-group input-group-sm">
                        <input type="email" class="form-control" placeholder="Your email address">
                        <button class="btn btn-dark">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="border-top pt-4 mt-5 text-center text-muted small">
                &copy; {{ date('Y') }} Book My Concerts. All Rights Reserved.
            </div>
        </div>
    </footer>