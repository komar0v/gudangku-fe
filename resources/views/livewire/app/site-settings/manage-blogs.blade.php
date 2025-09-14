<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Kelola Konten Blog</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Site Settings</li>
                    <li class="breadcrumb-item active">Blog</li>
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
                <div class="col-lg-4">

                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Published Content</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$siteBlogsCount['published']}}</h6>
                                    <span class="text-muted small pt-2 ps-1">Konten blog diterbitkan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">

                    <div class="card info-card customers-card">

                        <div class="card-body">
                            <h5 class="card-title">Drafted Content</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-save2-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$siteBlogsCount['draft']}}</h6>
                                    <span class="text-muted small pt-2 ps-1">Draft konten blog</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card info-card">

                        <div class="card-body">
                            <h5 class="card-title">Total Konten</h5>


                            <div class="row">
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center bg-success text-white justify-content-center">
                                            <i class="bi bi-stack"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$siteBlogsCount['total_content']}}</h6>
                                            <span class="text-muted small pt-2 ps-1">Konten</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center">

                                        <a href="{{route('appCreateBlogPage')}}" class="btn btn-success"><i class="bi bi-journal-plus me-1"></i>Buat Konten Blog Baru</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="section">

            <div class="row">

                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Konten Blog</h5>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>
                                            Judul
                                        </th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Waktu Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siteBlogsData as $blog)
                                    <tr>
                                        <td>{{$blog['title']}}</td>
                                        <td>{{$blog['author']}}</td>
                                        <td> @if($blog['is_published'])
                                            <span class="badge bg-success">Published</span>
                                            @else
                                            <span class="badge bg-warning text-dark">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{$blog['created_at']}}</td>
                                        <td>

                                            <a href="{{ route('appEditBlogPage', ['blogId' => $blog['id']]) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye me-1"></i>Detail
                                            </a>
                                        </td>
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