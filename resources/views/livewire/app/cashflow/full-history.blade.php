<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Catatan Keuangan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Cashflow</li>
                    <li class="breadcrumb-item active">History</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ session('error_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col">
                    <a href="{{route('appCashflowIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                </div>
                <div class="col text-end">
                    @if(!empty($cashflowHistory['cashflows']))
                    <a wire:click="cetakPDF" class="btn btn-info btn-sm mb-2"><i class="bi bi-download me-1"></i>Download PDF</a>
                    <div wire:loading wire:target="cetakPDF">
                        <img width="60" height="60" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                    </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tampilkan Cashflow</h5>
                            <form wire:submit.prevent="showData">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <p>Tanggal Awal</p>
                                        @error('startDate') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-6 text-center">
                                        <p>Tanggal Akhir</p>
                                        @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <input wire:model="startDate" type="date" class="form-control" placeholder="Tanggal Awal">
                                            <span class="input-group-text">s/d</span>
                                            <input wire:model="endDate" type="date" class="form-control" placeholder="Tanggal Akhir">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group mb-3">
                                            <select wire:model="category_id" class="form-control">
                                                <option value="">-- Semua Kategori --</option>
                                                @foreach($kategoriCashflow as $kategori)
                                                <option value="{{$kategori['id']}}">{{$kategori['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="form-check">
                                            <input wire:model="checkBxUpah" class="form-check-input" type="checkbox">
                                            <label class="form-check-label">
                                                Termasuk upah ke pengrajin
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col text-end">
                                        <button class="btn btn-primary">Tampilkan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if(!empty($cashflowHistory))
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Cashflow</h5>
                            <p class="text-center">Pengeluaran : Rp. {{ number_format($cashflowHistory['total_out'], 0, ',', '.') }} | Pemasukan : Rp. {{ number_format($cashflowHistory['total_in'], 0, ',', '.') }}</p>
                            <hr>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tipe</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashflowHistory['cashflows'] as $data)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            @if ($data['type'] === 'in')
                                            <span class="badge" style="background-color:#4154F1;">Masuk</span>
                                            @else
                                            <span class="badge" style="background-color:#2ECA6A;">Keluar</span>
                                            @endif
                                        </td>
                                        <td>{{$data['category']}}</td>
                                        <td>Rp. {{ number_format($data['amount'], 0, ',', '.') }}</td>
                                        <td>
                                            @if ($data['category'] === 'Upah Pengrajin')
                                            <a href="{{route('appTransactionDetails', ['transactionId' => $data['id']])}}" type="button" class="btn btn-success btn-sm" target="_blank">
                                                <i class="bi bi-eye-fill"></i> Detail
                                            </a>
                                            @else
                                            <a href="{{route('appDetailCashflowPage', ['cashflowId' => $data['id']])}}" type="button" class="btn btn-success btn-sm" target="_blank">
                                                <i class="bi bi-eye-fill"></i> Detail
                                            </a>
                                            @endif

                                        </td>
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