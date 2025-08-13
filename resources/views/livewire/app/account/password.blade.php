<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Ubah Password</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Account</li>
                    <li class="breadcrumb-item active">Password</li>
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
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">

                            <!-- Multi Columns Form -->
                            <form class="row g-3 mt-2" wire:submit.prevent="updatePassword">
                                <div class="col-md-6">
                                    <label class="form-label">Password sekarang</label>
                                    <div class="input-group">
                                        <input type="password" wire:model="current_password" class="form-control" id="currentPassword">
                                        <button type="button" class="btn btn-outline-secondary" onclick="intipPassword('currentPassword')">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </button>
                                    </div>

                                    @error('current_password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" wire:model="new_password" id="newPassword">
                                        <button type="button" class="btn btn-outline-secondary" onclick="intipPassword('newPassword')">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </button>
                                    </div>

                                    @error('new_password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
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

    <script>
        function intipPassword(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>

    <livewire:PartialView.App.Footer />
</div>