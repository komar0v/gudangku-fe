<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Kunjungan <span class="text-muted">xxx</span></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Supplier Master</li>
                    <li class="breadcrumb-item">Detail</li>
                    <li class="breadcrumb-item active">Visit Log</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <a href="{{route('appSupplierDetailPage', ['supplierId'=> $suppId])}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Waktu Kunjungan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($visitLogs as $log)
                                    <tr>
                                        <td>{{$log['visited_at']}}</td>
                                    </tr>
                                    @endforeach



                                </tbody>

                            </table>


                        </div>
                    </div>
                </div>
            </div>


        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>