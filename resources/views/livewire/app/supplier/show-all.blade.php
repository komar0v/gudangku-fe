<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Master Data Supplier</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Supplier Master</li>
                    <li class="breadcrumb-item active">All Supplier</li>
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

        </section>

        <section class="section">
            <a href="{{route('appSupplierIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Semua Supplier</h5>
                            <p>Menampilkan daftar supplier yang ada dalam sistem.</p>

                            <hr>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Supplier</th>
                                        <th scope="col">Nomer Telepon</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Tanggal Bergabung</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($supplierList as $index => $supplier)
                                    <tr>
                                        <td>{{$supplier['nama_supplier']}}</td>
                                        <td>+62{{$supplier['nomer_telepon_kantor']}}</td>
                                        <td>{{$supplier['email_kantor']}}</td>
                                        <td>{{$supplier['category']['nama_kategori']}}</td>
                                        <td>{{substr($supplier['created_at'], 0, 10)}}</td>
                                        <td><a wire:navigate href="{{ route('appSupplierDetailPage', ['supplierId' => $supplier['id']]) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Detail</a></td>
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