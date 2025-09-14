<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Pengaturan Website</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Site Settings</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            <div class="row">

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Blogs</h5>
                            <p class="card-text">Kelola konten blog website.</p>
                            <p class="card-text"><a wire:navigate href="{{route('appManageBlogsPage')}}" class="btn btn-primary">Kelola Konten Blog</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Footer Landing Page</h5>
                            <p class="card-text">Footer adalah bagian bawah dari suatu halaman website.</p>
                            <p class="card-text"><a wire:navigate href="{{route('appLandingPageFooterSettingsPage')}}" class="btn btn-primary">Ubah Footer</a></p>
                        </div>
                    </div>
                </div>

                

            </div>

        </section>


    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>