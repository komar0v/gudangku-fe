<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Informasi Akun</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Account</li>
                    <li class="breadcrumb-item active">Info</li>
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

            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Detail Akun Anda</h5>

                            <!-- Multi Columns Form -->
                            <form class="row g-3" wire:submit.prevent="updateMyAccount">
                                <div class="col-md-12">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" wire:model="fullname" class="form-control">
                                    @error('fullname')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" wire:model="email">
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <p for="changepassbutton" class="form-label">Password</p>
                                    <a wire:navigate href="{{route('accountPasswordPage')}}" class="btn btn-outline-primary">Ganti Password</a>
                                </div>

                                <div class="col-md-6">

                                    <label for="inputWA" class="form-label">Nomer WhatsApp</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">+62</span>
                                        <input type="text" class="form-control" id="inputWA" wire:model="nomer_wa">
                                    </div>
                                    @error('nomer_wa')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Bergabung</label>
                                    <input readonly type="text" wire:model="created_at" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Jenis Akun</label>
                                    <input readonly type="text" wire:model="role" class="form-control">
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form><!-- End Multi Columns Form -->

                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>