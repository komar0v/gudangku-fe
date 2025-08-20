<div>

    <link href="{{ url(env('APP_ASSET_URL') . '/css/wizard.css') }}" rel="stylesheet">

    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Register Pengrajin Baru</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Pengrajin Master</li>
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

            <a href="{{route('appSupplierIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">
                <div class="col-lg-12">

                    <div class="card" wire:ignore>
                        <div class="card-body">
                            <h5 class="card-title">Tambah Pengrajin Baru</h5>

                            <div class="border">

                                <!-- Step Indicators -->
                                <div class="step-indicator-container d-flex justify-content-around align-items-center">
                                    <div class="step-indicator-item active" data-step-target="1">
                                        <div class="step-circle">1</div>
                                        <div class="step-label">Informasi Pengrajin</div>
                                    </div>
                                    <div class="step-indicator-line"></div>
                                    <div class="step-indicator-item" data-step-target="2">
                                        <div class="step-circle">2</div>
                                        <div class="step-label">Data Pengrajin</div>
                                    </div>
                                    <div class="step-indicator-line"></div>
                                    <div class="step-indicator-item" data-step-target="3">
                                        <div class="step-circle">3</div>
                                        <div class="step-label">Konfirmasi</div>
                                    </div>
                                </div>

                                <!-- Form Content -->
                                <form id="wizardForm" class="needs-validation" novalidate wire:submit.prevent="saveSupplierData">
                                    <!-- Step 1 -->
                                    <div class="form-step active" id="step1">
                                        <h5 class="mb-4 text-primary">Detail informasi pengrajin</h5>
                                        <div class="form-floating mb-3">
                                            <input wire:model="nama_pengrajin" type="text" class="form-control" id="namaSupplier" placeholder="cth: UD. Berkah" required>
                                            <label for="namaSupplier">Nama Pengrajin</label>
                                            <div class="invalid-feedback">Nama pengrajin tidak boleh kosong.</div>
                                        </div>
                                        <label for="nomerWa" class="form-label">Nomer WhatsApp</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">+62</span>
                                            <input wire:model="nomer_wa" type="text" class="form-control form-control-lg" id="nomerWa" placeholder="821..." required>
                                            <div class="invalid-feedback">Nomer WhatsApp tidak valid.</div>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="form-step" id="step2">
                                        <h5 class="mb-4 text-primary">Data pengrajin</h5>
                                        <div class="form-floating mb-3">
                                            <input wire:model="alamat" type="text" class="form-control" id="alamat" placeholder="cth: Jalan Bangau..." required>
                                            <label for="alamat">Alamat</label>
                                            <div class="invalid-feedback">Alamat tidak boleh kosong.</div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input wire:model="tentang" type="text" class="form-control" id="tentang" placeholder="cth: Supplier ini menyediakan ..." required>
                                            <label for="tentang">Tentang</label>
                                            <div class="invalid-feedback">Tentang tidak boleh kosong.</div>
                                        </div>

                                    </div>

                                    <!-- Step 3 -->
                                    <div class="form-step" id="step3">
                                        <h5 class="mb-4 text-primary">Konfirmasi detail pengrajin</h5>
                                        <div id="summaryData" class="mb-3 p-3 bg-light rounded border">
                                            <p><strong>Nama Pengrajin:</strong> <span id="summaryNamaSupplier">-</span></p>
                                            <p><strong>No. WhatsApp:</strong> <span id="summaryNomerWa">-</span></p>
                                            <p><strong>Alamat:</strong> <span id="summaryAlamat">-</span></p>
                                            <p><strong>Tentang:</strong> <span id="summaryTentang">-</span></p>
                                        </div>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="wizard-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" id="prevBtn" disabled>Previous</button>
                                        <div>
                                            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                                            <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Import dari Excel <i style="color:#008000" class="h5 bi bi-file-earmark-spreadsheet-fill"></i></h5>
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
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <script src="{{ url(env('APP_ASSET_URL') . '/js/wizard.js') }}"></script>

    <livewire:PartialView.App.Footer />
</div>