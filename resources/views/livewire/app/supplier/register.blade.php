<div>

    <link href="{{ url(env('APP_ASSET_URL') . '/css/wizard.css') }}" rel="stylesheet">

    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Register Supplier Baru</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Suppliers</li>
                    <li class="breadcrumb-item active">Register</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            <a href="{{route('appSupplierIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tambah Supplier Baru</h5>

                            <div class="border">

                                <!-- Step Indicators -->
                                <div class="step-indicator-container d-flex justify-content-around align-items-center">
                                    <div class="step-indicator-item active" data-step-target="1">
                                        <div class="step-circle">1</div>
                                        <div class="step-label">Informasi Supplier</div>
                                    </div>
                                    <div class="step-indicator-line"></div>
                                    <div class="step-indicator-item" data-step-target="2">
                                        <div class="step-circle">2</div>
                                        <div class="step-label">Data Supplier</div>
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
                                        <h5 class="mb-4 text-primary">Detail informasi supplier</h5>
                                        <div class="form-floating mb-3">
                                            <input wire:model="nama_supplier" type="text" class="form-control" id="namaSupplier" placeholder="cth: UD. Berkah" required>
                                            <label for="namaSupplier">Nama Supplier</label>
                                            <div class="invalid-feedback">Nama supplier tidak boleh kosong.</div>
                                        </div>
                                        <label for="nomerWa" class="form-label">Nomer WhatsApp</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">+62</span>
                                            <input wire:model="nomer_telepon_kantor" type="text" class="form-control form-control-lg" id="nomerWa" placeholder="821..." required>
                                            <div class="invalid-feedback">Nomer WhatsApp tidak valid.</div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input wire:model="email_kantor" type="email" class="form-control" id="email" placeholder="cth: email@example.com" required>
                                            <label for="email">Email</label>
                                            <div class="invalid-feedback">Email tidak valid.</div>
                                        </div>
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

                                    <!-- Step 2 -->
                                    <div class="form-step" id="step2">
                                        <h5 class="mb-4 text-primary">Data akun supplier</h5>
                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="floatingSelectAkun">Pilih akun supplier</label>
                                            <div class="col">
                                                <select style="width: 100%;" class="form-select select2" id="floatingSelectAkun" required>
                                                    <option value="">-Pilih Akun-</option>
                                                    @foreach ($userList as $akun)
                                                    <option value="{{ $akun['id'] }}">{{ $akun['fullname'] }} | {{ $akun['email'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="invalid-feedback">Akun supplier harus dipilih.</div>
                                        </div>

                                        <div class="row mb-3">

                                            <label class="col-sm-2 col-form-label" for="floatingSelectKategori">Pilih kategori supplier</label>
                                            <div class="col">
                                                <select style="width: 100%;" class="form-select select2" id="floatingSelectKategori" required>
                                                    <option value="">-Pilih Kategori-</option>
                                                    @foreach ($kategoriSupplierList['data'] as $kategori)
                                                    <option value="{{ $kategori['id'] }}">{{ $kategori['nama_kategori'] }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="invalid-feedback">Kategori supplier harus dipilih.</div>
                                        </div>

                                    </div>

                                    <!-- Step 3 -->
                                    <div class="form-step" id="step3">
                                        <h5 class="mb-4 text-primary">Konfirmasi detail supplier</h5>
                                        <div id="summaryData" class="mb-3 p-3 bg-light rounded border">
                                            <p><strong>Nama Supplier:</strong> <span id="summaryNamaSupplier">-</span></p>
                                            <p><strong>No. WhatsApp:</strong> <span id="summaryNomerWa">-</span></p>
                                            <p><strong>Email:</strong> <span id="summaryEmail">-</span></p>
                                            <p><strong>Alamat:</strong> <span id="summaryAlamat">-</span></p>
                                            <p><strong>Tentang:</strong> <span id="summaryTentang">-</span></p>
                                            <p><strong>Akun Supplier:</strong> <span id="summaryAkunSupplier">-</span></p>
                                            <p><strong>Kategori Supplier:</strong> <span id="summaryKategoriSupplier">-</span></p>
                                        </div>
                                    </div>
                                    <input type="hidden" id="user_id" wire:model="user_id">
                                    <input type="hidden" id="kategori_supplier" wire:model="kategori_supplier">

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
        </section>

    </main><!-- End #main -->

    <script src="{{ url(env('APP_ASSET_URL') . '/js/wizard.js') }}"></script>

    <script>
        (function() {
            document.getElementById('submitBtn')?.addEventListener('click', function() {
                const userId = document.getElementById('floatingSelectAkun').value;
                const kategori = document.getElementById('floatingSelectKategori').value;

                document.getElementById('user_id').value = userId;
                document.getElementById('user_id').dispatchEvent(new Event('input'));

                document.getElementById('kategori_supplier').value = kategori;
                document.getElementById('kategori_supplier').dispatchEvent(new Event('input'));
            });
        })();
    </script>

    <livewire:PartialView.App.Footer />
</div>