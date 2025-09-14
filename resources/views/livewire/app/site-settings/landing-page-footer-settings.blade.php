<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <style>
        .icon-item {
            text-align: center;
            cursor: pointer;
            font-size: 20px;
            padding: 6px;
            border-radius: 5px;
            border: none;
            background: transparent;
        }

        .icon-item:hover {
            background-color: #f0f8ff;
            color: #0d6efd;
        }
    </style>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Pengaturan Landing Page Footer</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Site Settings</li>
                    <li class="breadcrumb-item active">Footer Settings</li>
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

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <a href="{{route('appSiteSettingsIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">
                <div class="col-lg-6">

                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Informasi</h5>
                            <form wire:submit.prevent="saveChanges" class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Email</label>
                                    <input wire:model="email" type="email" class="form-control">
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Telepon</label>
                                    <input wire:model="phone" type="text" class="form-control">
                                    @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat</label>
                                    <input wire:model="alamat" type="text" class="form-control" placeholder="Jalan ...">
                                    @error('alamat')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">

                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Media Sosial</h5>

                            <form wire:submit.prevent="addSosMed" class="row g-3">

                                <div class="col-md-4">
                                    <input type="text" class="form-control" wire:model="platform" placeholder="Platform">
                                    @error('platform')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2" wire:ignore>
                                    <div class="dropdown">
                                        <button id="iconDropdownBtn" class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i id="iconDropdownPreview" class="bi bi-plus"></i>
                                        </button>

                                        <div class="dropdown-menu p-2" aria-labelledby="iconDropdownBtn" style="min-width:220px; max-height:250px; overflow:auto;">
                                            <div id="iconGrid" class="d-grid" style="grid-template-columns: repeat(auto-fill, minmax(45px, 1fr)); gap:8px;"></div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="selectedIcon" wire:model.defer="selectedIcon" name="icon" />
                                    @error('selectedIcon')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="URL" wire:model="url">
                                    @error('url')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>

                            <hr>
                            @if(!empty($socMedData))
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Platform</th>
                                        <th scope="col">Ikon</th>
                                        <th scope="col">URL</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($socMedData as $socMed)
                                    <tr>
                                        <th scope="row">{{$socMed['platform']}}</th>
                                        <td><i class="bi {{$socMed['icon']}}"></i></td>
                                        <td>{{$socMed['url']}}</td>
                                        <td><btn wire:click="deleteSocMed('{{$socMed['id']}}')" class="btn btn-danger btn-sm mb-2"><i class="bi bi-trash me-1"></i>Hapus</btn></td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </section>


    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />

    <script>
        (function() {
            // daftar icon sosial media (ubah/tambah sesuai kebutuhan)
            const SOCIAL_ICONS = [
                "facebook", "twitter-x", "instagram", "linkedin",
                "tiktok", "youtube", "whatsapp", "telegram",
                "github", "reddit", "snapchat", "discord"
            ];

            function initIconPicker() {
                const grid = document.getElementById('iconGrid');
                const btn = document.getElementById('iconDropdownBtn');
                const preview = document.getElementById('iconDropdownPreview');
                const hidden = document.getElementById('selectedIcon');

                if (!grid || !btn || !preview) return;

                grid.innerHTML = '';

                SOCIAL_ICONS.forEach(name => {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className = 'icon-item';
                    item.innerHTML = `<i class="bi bi-${name}"></i>`;
                    item.addEventListener('click', function(ev) {
                        // update preview tombol (hanya icon)
                        preview.className = `bi bi-${name}`;

                        if (hidden) {
                            hidden.value = `bi-${name}`;
                            hidden.dispatchEvent(new Event('input', {
                                bubbles: true
                            }));
                        }


                        ev.stopPropagation();
                    });

                    grid.appendChild(item);
                });
            }

            document.addEventListener('DOMContentLoaded', initIconPicker);

            window.addEventListener('initIconPicker', () => {
                requestAnimationFrame(initIconPicker);
            });
        })();
    </script>
</div>