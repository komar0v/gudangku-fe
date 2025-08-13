<div>
    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ url(env('APP_ASSET_URL') . '/img/noun-inventory-management-2825346.png') }}" alt="">
                                    <span class="d-none d-lg-block">GudangKu</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2 text-center">
                                        <h5 class="card-title pb-0 fs-4">Login</h5>
                                        <p class="small">Enter your email & password to login</p>
                                        <div wire:loading>
                                            <img width="80" height="80" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}">
                                        </div>
                                    </div>

                                    @if(session('error_message'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error_message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <form class="row g-3 needs-validation" novalidate wire:submit.prevent="loginUser">
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <input
                                                type="email"
                                                wire:model="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="email"
                                                required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input
                                                type="password"
                                                wire:model="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="yourPassword"
                                                required>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

</div>
