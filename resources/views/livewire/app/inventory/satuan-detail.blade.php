<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail satuan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Inventory Master</li>
                    <li class="breadcrumb-item active">Unit Detail</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ session('error_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <a href="{{route('appInventoryIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data satuan</h5>

                            <!-- Floating Labels Form -->
                            <form class="row g-3" wire:submit.prevent="saveChanges">
                                <div class="col-12">

                                    <div class="col-12">
                                        <label for="namasatuan" class="form-label">Nama Satuan</label>
                                        <input type="text" class="form-control" id="namasatuan" wire:model="nama_satuan" placeholder="kilogram, gram, ...">
                                    </div>
                                    @error('nama_satuan')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="col-12">
                                        <label for="kodesatuan" class="form-label">Kode Satuan</label>
                                        <input type="text" class="form-control" id="kodesatuan" wire:model="kode_satuan" placeholder="KG, G, ...">
                                    </div>
                                    @error('kode_satuan')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form><!-- End floating Labels Form -->

                        </div>
                    </div>
                </div>
            </div>


        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>