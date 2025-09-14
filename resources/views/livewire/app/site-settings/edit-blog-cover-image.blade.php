<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Konten Blog</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Site Settings</li>
                    <li class="breadcrumb-item active">Blog</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            @if(session('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ session('error_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <a href="{{route('appEditBlogPage', ['blogId'=>$blogsData['id']])}}" class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">

                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Ganti Gambar Cover Blog</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Gambar Cover Baru (Max 2MB)</label>
                                    <input wire:model="thumbnail" class="form-control" type="file" id="formFile">
                                    @error('thumbnail')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>

                                <div class="col-12">
                                    <label class="form-label">Gambar saat ini</label>
                                    <br>
                                    <img src="{{env('API_URL') . '/' . $blogsData['thumbnail']}}" class="img-fluid" width="400">
                                </div>

                                <div class="text-center">
                                    <button wire:click="saveChanges" class="btn btn-success"><i class="bi bi-upload me-1"></i>Simpan Perubahan</button>
                                    <div wire:loading wire:target="saveChanges">
                                        <img width="60" height="60" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>