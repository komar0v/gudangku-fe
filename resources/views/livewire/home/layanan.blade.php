<div>
    <livewire:PartialView.HomeIndex.Header />

    <main class="main">
        <!-- Services Section -->
        <section id="services" class="services section dark-background">

            <!-- Section Title -->
            <div class="container section-title">
                <h2>Blog</h2>
                <div><span>Informasi Menarik</span> <span class="description-title">Dari Kami</span></div>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">

                    @foreach($blogLists as $blog)
                    <div class="col-lg-4 col-md-6">
                        <a wire:navigate href="{{ route('readBlogPage', ['slug'=>$blog['slug']]) }}">
                        <div class="service-card">
                            <img src="{{env('API_URL') . '/' . $blog['thumbnail']}}" class="img-fluid img-thumbnail mb-4" width="400">

                            <h3>{{$blog['title']}}</h3>
                            <p>{{$blog['excerpt']}}</p>

                        </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

        </section><!-- /Services Section -->
    </main>
    <livewire:PartialView.HomeIndex.Footer />
</div>