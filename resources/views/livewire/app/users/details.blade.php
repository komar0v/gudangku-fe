<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Akun {{ $fullname }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Details</li>
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

            <a href="{{route('appManageUserPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data akun</h5>

                    <!-- Floating Labels Form -->
                    <form class="row g-3" wire:submit.prevent="saveChanges">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingName" placeholder="Nama Lengkap" wire:model="fullname">
                                <label for="floatingName">Nama Lengkap</label>
                            </div>
                            @error('fullname')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="floatingEmail" placeholder="E-Mail" wire:model="email">
                                <label for="floatingEmail">E-Mail</label>
                            </div>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#resetPassMdl" class="btn btn-warning form-control"><i class="bi bi-key me-1"></i>Reset Password</button>
                        </div>
                        <div class="col-md-6">

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">+62</span>
                                <input type="text" placeholder="Nomer WhatsApp" class="form-control form-control-lg" id="inputWA" wire:model="nomer_wa">
                            </div>
                            @error('nomer_wa')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select required class="form-select" id="floatingSelect" aria-label="State" wire:model="role_code">
                                    @foreach ($roleList['data'] as $role)
                                    <option value="{{ $role['role_code'] }}">{{ $role['role_name'] }}</option>
                                    @endforeach

                                </select>
                                <label for="floatingSelect">Tipe Akun</label>
                                @error('role_code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Bergabung</label>
                            <input readonly type="text" wire:model="created_at" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Perubahan Terakhir</label>
                            <input readonly type="text" wire:model="updated_at" class="form-control">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form><!-- End floating Labels Form -->

                    <div class="modal fade" id="resetPassMdl" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Reset Password Akun {{ $fullname }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Reset password akun {{ $fullname }}? Akun akan otomatis logout dan perlu login ulang setelah reset</p>

                                    <p>Password Default</p>
                                    <div class="input-group">
                                        <input type="text" id="defaultPass" class="form-control" readonly value="#semangatselalu">
                                        <button type="button" class="btn btn-outline-secondary" onclick="copyToClipboard()">
                                            <i class="bi bi-files"></i>
                                        </button>
                                    </div>

                                    <div class="text-center">
                                        <div wire:loading>
                                            <img width="80" height="80" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" wire:click="resetPassword" class="btn btn-primary">Reset Password</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </section>

    </main><!-- End #main -->

    <script>
        function copyToClipboard() {
            const input = document.getElementById("defaultPass");
            input.select();
            input.setSelectionRange(0, 99999); // Untuk mobile
            document.execCommand("copy");

            // Optional: Beri feedback
            alert("Text (" + input.value + ") disalin");
        }
    </script>

    <livewire:PartialView.App.Footer />
</div>