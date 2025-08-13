<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Informasi Akun</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Supplier Master</li>
                    <li class="breadcrumb-item">Detail</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col">

                    <div class="card">

                        <div class="row">
                            <div class="col-4">
                                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                                    <img width="200" height="200"
                                        src="{{$logo_img}}"
                                        alt="Profile" class="img-fluid">

                                    <hr>

                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalChangeLogo" class="btn btn-primary btn-sm"><i class="bi bi-pencil me-1"></i>Ganti Logo</button>
                                    <hr>
                                    <h3>{{$supplierData['nama_supplier']}}</h3>
                                    <h4>{{$supplierData['category']['nama_kategori']}}</h4>

                                </div>
                            </div>

                            <div class="col-8">
                                <div class="card-body">
                                    <h5 class="card-title">Data Supplier</h5>
                                    <ul class="nav nav-tabs nav-tabs-bordered">

                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab"
                                                data-bs-target="#tab-overview">Overview</button>
                                        </li>

                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#tab-sistem">Sistem</button>
                                        </li>

                                    </ul>
                                    <div class="tab-content pt-2">

                                        <div class="tab-pane fade show active" id="tab-overview">
                                            <form wire:submit.prevent="saveSupplierData1">
                                                <h5 class="card-title">Tentang</h5>
                                                <input wire:model="tentang" type="text" class="form-control">
                                                @error('tentang')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                                <h5 class="card-title">Detail</h5>

                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Negara</label>
                                                    <div class="col-sm-10">
                                                        <input wire:model="negara" type="text" class="form-control">
                                                        @error('negara')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Nomer Telepon</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <span class="input-group-text" id="basic-addon1">+62</span>
                                                            <input type="text" class="form-control" wire:model="nomer_telepon_kantor">
                                                        </div>
                                                        @error('nomer_telepon_kantor')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Email Kantor</label>
                                                    <div class="col-sm-10">
                                                        <input wire:model="email_kantor" type="text" class="form-control">
                                                        @error('email_kantor')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Website</label>
                                                    <div class="col-sm-10">
                                                        <input wire:model="website" type="text" class="form-control">
                                                        @error('website')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">NPWP</label>
                                                    <div class="col-sm-10">
                                                        <input wire:model="npwp" type="text" class="form-control">
                                                        @error('npwp')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Alamat</label>
                                                    <div class="col-sm-10">
                                                        <input wire:model="alamat" type="text" class="form-control">
                                                        @error('alamat')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Tanggal bergabung</label>
                                                    <div class="col-sm-10">
                                                        <input readonly value="{{$created_at}}" type="text" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade pt-3" id="tab-sistem">
                                            <form wire:submit.prevent="saveSupplierData2">
                                                <h5 class="card-title">Supplier Data</h5>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Nama Supplier</label>
                                                    <div class="col-sm-10">
                                                        <input wire:model="nama_supplier" type="text" class="form-control">
                                                        @error('nama_supplier')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Kategori</label>
                                                    <div class="col-sm-10">
                                                        <select wire:model="kategori_supplier" class="form-select" required>
                                                            @foreach ($kategoriSupplierList['data'] as $kategori)
                                                            <option value="{{ $kategori['id'] }}">{{ $kategori['nama_kategori'] }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>

                                                <h5 class="card-title">Akun Supplier</h5>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Akun</label>
                                                    <div class="col-sm-10">
                                                        <select wire:model="user_id" style="width: 100%;" class="form-select" required>
                                                            @foreach ($userList as $akun)
                                                            <option value="{{ $akun['id'] }}">{{ $akun['fullname'] }} | {{ $akun['email'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </section>

        <div class="modal fade" id="modalChangeLogo" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ganti Logo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="changeLogo" enctype="multipart/form-data">
                        <div class="modal-body">

                            <label for="formFile" class="col-sm-4 col-form-label">File Upload</label>
                            <div class="col-sm-10">
                                <input wire:model="logo_file" class="form-control" type="file" id="formFile">
                                <div class="text-danger" id="fileError"></div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button id="submitBtn" type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main><!-- End #main -->

    <script>
        (function() {
            const fileInput = document.getElementById('formFile');
            const errorDiv = document.getElementById('fileError');

            if (!fileInput) return;

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.size > 1024 * 1024) {
                    errorDiv.textContent = 'Ukuran file terlalu besar, maksimal 1MB.';
                    this.value = '';
                } else {
                    errorDiv.textContent = '';
                }
            });
        })();
    </script>

    <livewire:PartialView.App.Footer />
</div>