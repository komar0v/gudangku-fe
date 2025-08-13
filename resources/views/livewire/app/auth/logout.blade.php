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
                                        <h5 class="card-title pb-0 fs-4">Logging out...</h5>
                                        <p class="small">Sampai jumpa :)</p>
                                        <img width="80" height="80" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}">
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <script>
        window.setTimeout(function() {
            window.location.href = "{{ route('appLoginPage') }}";
        }, 4000);
    </script>

</div>