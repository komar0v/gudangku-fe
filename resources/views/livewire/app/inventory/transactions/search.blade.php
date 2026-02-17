<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Cari Transaksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Transaction</li>
                    <li class="breadcrumb-item active">Search</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            @if(session('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ session('error_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-12">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Cari Data Transaksi</h5>
                            <p>Mencari data transaksi pengrajin dengan TRX ID</p>
                            <form>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <input wire:model="trx_id" type="text" class="form-control" placeholder="TRX ID">
                                        </div>
                                        @error('trx_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col text-center">
                                        <button wire:click.prevent="showData" class="btn btn-primary"><i class="bi bi-search me-1"></i>Cari</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                @if(!empty($searchResult))
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">TRX ID</th>
                                        <th scope="col">Pengrajin</th>
                                        <th scope="col">Tanggal Pengambilan</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($searchResult as $data)
                                    <tr>
                                        <th scope="row">{{ explode('-', $data['id'])[1] }}</th>
                                        <td>{{ $data['pengrajin']['nama_pengrajin'] ?? '-' }}</td>
                                        <td>{{$data['timestamp_pengambilan']}}</td>
                                        <td><a wire:navigate href="{{ route('appTransactionDetails', ['transactionId' => $data['id']]) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Detail</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                @endif

            </div>

        </section>


    </main><!-- End #main -->


    <livewire:PartialView.App.Footer />
</div>