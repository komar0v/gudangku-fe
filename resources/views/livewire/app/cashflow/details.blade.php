<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Keuangan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Cashflow</li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            <a href="{{route('appCashflowIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Detail catatan cashflow</h5>
                            <form class="row g-3" wire:submit.prevent="saveData">
                                <div class="col-12">
                                    <label class="form-label">Tipe Catatan Keuangan</label>
                                    <select wire:model="type" class="form-control form-control-lg">
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="in">Pemasukan</option>
                                        <option value="out">Pengeluaran</option>
                                    </select>
                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Kategori</label>
                                    <select wire:model="category_id" class="form-control form-control-lg">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoriCashflow as $kategori)
                                        <option value="{{$kategori['id']}}">{{$kategori['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Tanggal Transaksi</label>
                                    <input wire:model="transaction_date" type="date" class="form-control">
                                    @error('transaction_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nominal</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        <input wire:model="amount" type="text" class="form-control">
                                    </div>
                                    @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Deskripsi</label>
                                    <input wire:model="description" type="text" class="form-control" placeholder="Deksripsi catatan keuangan">
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Deskripsi Kategori</label>
                                <div class="col-sm-10 pt-3">
                                    {{$cashflowData['category']['description']}}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Pembuat Catatan</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" value="{{$cashflowData['creator']['fullname']}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tanggal Catatan Dibuat</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" value="{{$createdAt}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Perubahan Terakhir</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" value="{{$updatedAt}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>