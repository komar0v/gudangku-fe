<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Register Akun Baru</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Register</li>
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
                    <h5 class="card-title">Data akun baru</h5>

                    <!-- Floating Labels Form -->
                    <form class="row g-3" wire:submit.prevent="createNewUser">
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
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" wire:model="password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
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
                                    <option>-- Pilih --</option>
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

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>

                        </div>
                    </form><!-- End floating Labels Form -->

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Import Akun dari Excel <i style="color:#008000" class="h5 bi bi-file-earmark-spreadsheet-fill"></i></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Pastikan format file sesuai dengan template</h6>
                    <!-- Floating Labels Form -->
                    <form class="row g-3" wire:submit.prevent="uploadFile" enctype="multipart/form-data">

                        <div class="col-md-6">
                            <label for="formFile" class="col-sm-2 col-form-label">File Upload</label>
                            <div class="col-sm-10">
                                <input wire:model="excel_file" class="form-control form-control-lg" type="file" id="formFile">
                            </div>
                            @error('excel_file')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <p>Gunakan Template/format file Excel berikut untuk melakukan bulk upload. Unduh dan isi template berikut sebelum upload.</p>

                            <a wire:click="downloadTemplate" class="btn btn-dark"><i class="bi bi-download me-1"></i> Download file template</a>
                        </div>

                        <div class="text-center">
                            <button {{ !$excel_file ? 'disabled' : '' }} type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">Upload</button>

                            <div class="modal fade" id="basicModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <div wire:loading wire:target="uploadFile">
                                                <img width="120" height="120" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </form><!-- End floating Labels Form -->
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>