<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Scan Barcode Pengrajin</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Hutang Piutang</li>
                    <li class="breadcrumb-item active">Scan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            @if($successMessage)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ $successMessage }}
                <button type="button" class="btn-close" wire:click="clearAlert" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errorMessage)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ $errorMessage }}
                <button type="button" class="btn-close" wire:click="clearAlert" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <a href="{{route('appHutangStatisticsPage')}}" class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body" wire:ignore>
                            <h5 class="card-title">Arahkan barcode pengrajin ke kamera</h5>
                            <div id="camera-loading" style="text-align: center;">
                                <img width="80" height="80" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                <p>Memuat kamera...</p>
                            </div>

                            <div id="reader" style="width: 100%; visibility: hidden; height: 0;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <input wire:model="qrResult" type="hidden" id="qrResult">

                        <div class="card-body" wire:poll="fetchResult">
                            <h5 class="card-title">Data Pengrajin</h5>
                            <div class="profile-card d-flex flex-column align-items-center">

                                @if(!empty($pengrajinData) && $pengrajinData['is_found'])

                                <div class="col-12 pt-2">
                                    <label class="form-label">Nama Pengrajin</label>
                                    <input type="text" readonly class="form-control" value="{{ $pengrajinData['nama_pengrajin'] }}">
                                </div>

                                @elseif(!empty($pengrajinData))
                                <div class="pt-2">
                                    <p>Tolong arahkan barcode ke kamera untuk melanjutkan</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Peminjaman</h5>

                            <div class="row g-2 text-center">

                                <div class="col-4">
                                    <div class="border rounded p-2 h-100">
                                        <div class="text-primary mb-1">
                                            <i class="bi bi-wallet2"></i>
                                        </div>
                                        <small class="text-muted d-block fw-semibold">
                                            Total
                                        </small>
                                        <div class="fw-semibold" style="font-size: 13px;">
                                            @if(!empty($pengrajinData) && $pengrajinData['is_found'])
                                            Rp {{ number_format($hutangDatas['data']['total_hutang_pengrajin'], 0, ',', '.') }}
                                            @else
                                            Rp 0
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="border rounded p-2 h-100">
                                        <div class="text-danger mb-1">
                                            <i class="bi bi-cash-stack"></i>
                                        </div>
                                        <small class="text-muted d-block fw-semibold">
                                            Sisa
                                        </small>
                                        <div class="fw-semibold" style="font-size: 13px;">
                                            @if(!empty($pengrajinData) && $pengrajinData['is_found'])
                                            Rp {{ number_format($hutangDatas['data']['total_sisa_hutang'], 0, ',', '.') }}
                                            @else
                                            Rp 0
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="border rounded p-2 h-100">
                                        <div class="text-warning mb-1">
                                            <i class="bi bi-receipt"></i>
                                        </div>
                                        <small class="text-muted d-block fw-semibold">
                                            Aktif
                                        </small>
                                        <div class="fw-semibold" style="font-size: 13px;">
                                            @if(!empty($pengrajinData) && $pengrajinData['is_found'])
                                            {{ $hutangDatas['data']['total_hutang_active'] }}
                                            @else
                                            0
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            @if(!empty($pengrajinData) && $pengrajinData['is_found'])
                            <div class="d-grid pt-3">
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('appHutangPengrajinPage', ['pengrajinId' => $pengrajinData['id']]) }}">
                                    <i class="bi bi-eye me-1"></i>
                                    Lihat Data Lengkap
                                </a>
                            </div>

                            <div class="d-grid pt-3">
                                <a class="btn btn-outline-success btn-sm" href="{{ route('appPeminjamanBaruPage', ['pengrajinId' => $pengrajinData['id']]) }}">
                                    <i class="bi bi-cash-coin me-1"></i>
                                    Pinjaman Baru
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($pengrajinData) && $pengrajinData['is_found'])
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Peminjaman pada Bulan {{$bulanIni}}</h5>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Total Hutang</th>
                                            <th>Sisa Hutang</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($listHutangBulanIni['data_hutang'] as $hutang)
                                        <tr>
                                            <td>
                                                Rp {{ number_format($hutang['total_hutang'], 0, ',', '.') }}
                                            </td>

                                            <td class="fw-semibold {{ (float)$hutang['sisa_hutang'] > 0 ? 'text-danger' : 'text-success' }}">
                                                @if((float)$hutang['sisa_hutang'] > 0)
                                                Rp {{ number_format($hutang['sisa_hutang'], 0, ',', '.') }}
                                                @else
                                                Lunas
                                                @endif
                                            </td>

                                            <td>
                                                @if($hutang['status'] == 'active')
                                                <span class="badge bg-danger">Active</span>
                                                @else
                                                <span class="badge bg-success">Lunas</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($hutang['created_at'])->format('d M Y') }}
                                            </td>

                                            <td>
                                                <a target="_blank" href="{{ route('appHutangDetails', ['hutangId' => $hutang['id']]) }}" class="btn btn-sm btn-outline-primary w-100">Detail Hutang</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                Tidak ada data hutang
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>

    </main><!-- End #main -->

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        (function() {
            const cameraLoading = document.getElementById("camera-loading");
            const readerDiv = document.getElementById("reader");

            const html5QrCode = new Html5Qrcode("reader");

            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    // cari kamera belakang
                    let backCamera = devices.find(d =>
                        d.label.toLowerCase().includes("back") ||
                        d.label.toLowerCase().includes("environment")
                    );

                    const cameraId = backCamera ? backCamera.id : devices[0].id;

                    html5QrCode.start(
                        cameraId, {
                            fps: 10,
                            qrbox: 250
                        },
                        qrCodeMessage => {
                            document.getElementById('qrResult').value = qrCodeMessage;
                            document.getElementById('qrResult').dispatchEvent(new Event('input'));
                        },
                        errorMessage => {
                            // optional error log
                        }
                    ).then(() => {
                        cameraLoading.style.display = "none";
                        readerDiv.style.visibility = "visible";
                        readerDiv.style.height = "auto";
                    }).catch(err => {
                        cameraLoading.innerHTML = "<p style='color:red'>Gagal mengakses kamera.</p>";
                    });
                }
            }).catch(err => {
                cameraLoading.innerHTML = "<p style='color:red'>Tidak ada kamera ditemukan.</p>";
            });
        })();
    </script>

    <livewire:PartialView.App.Footer />
</div>