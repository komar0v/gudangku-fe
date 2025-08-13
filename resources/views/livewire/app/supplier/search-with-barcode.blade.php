<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Cari Supplier dengan Barcode</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Search by Barcode</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <a href="{{route('appSupplierIndexPage')}}" class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body" wire:ignore>
                            <h5 class="card-title">Arahkan barcode ke kamera</h5>
                            <div id="camera-loading" style="text-align: center;">
                                <img width="80" height="80" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                <p>Memuat kamera...</p>
                            </div>

                            <div id="reader" style="width: 100%; visibility: hidden; height: 0;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <input wire:model="qrResult" type="hidden" id="qrResult">

                        <div class="card-body" wire:poll="fetchResult">
                            <h5 class="card-title">Result</h5>

                            @if(!empty($supplierData) && $supplierData['is_found'])

                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                                <img width="200" height="200"
                                    src="{{$logo_img}}"
                                    alt="Profile" class="img-fluid">
                                <h3>{{ $supplierData['nama_supplier'] }}</h3>
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route('appSupplierDetailPage', ['supplierId' => $supplierData['id']]) }}" class="btn btn-info">Detail</a>
                                    </div>
                                    
                                </div>
                            </div>

                            @elseif(!empty($supplierData))
                            <p>Tolong arahkan barcode ke kamera</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

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
                    const cameraId = devices[0].id;

                    html5QrCode.start(
                        cameraId, {
                            fps: 10,
                            qrbox: 250
                        },
                        qrCodeMessage => {
                            // alert("Scan berhasil: " + qrCodeMessage);
                            document.getElementById('qrResult').value = qrCodeMessage;
                            document.getElementById('qrResult').dispatchEvent(new Event('input'));
                        },
                        errorMessage => {
                            // optional error
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