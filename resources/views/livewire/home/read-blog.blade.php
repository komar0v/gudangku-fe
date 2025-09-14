<div>
    <style>
        /* === SunEditor Image Styling === */

        /* Default image wrapper */
        .se-image-container {
            display: inline-block;
            margin: 10px 0;
            max-width: 100%;
        }

        .se-image-container img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* Align Center */
        .se-image-container.__se__float-center {
            display: flex;
            justify-content: center;
            clear: both;
        }

        /* Align Left */
        .se-image-container.__se__float-left {
            float: left;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        /* Align Right */
        .se-image-container.__se__float-right {
            float: right;
            margin-left: 10px;
            margin-bottom: 10px;
        }

        /* Full Width Image (kalau user pilih width 100%) */
        .se-image-container.__se__float-none {
            display: block;
            width: 100%;
            text-align: center;
        }

        .se-image-container.__se__float-none img {
            width: 100% !important;
            height: auto;
        }
    </style>
    <livewire:PartialView.HomeIndex.Header />

    <main class="main">

        <div class="page-title dark-background">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1>{{$blogContent['title']}}</h1>
                            <p class="mb-0">{{$blogContent['excerpt']}}</p>
                            <img src="{{env('API_URL') . '/' . $blogContent['thumbnail']}}" class="img-fluid img-thumbnail mt-2" width="250">
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a wire:navigate href="{{ route('layananPage') }}">Blog</a></li>
                        <li class="current">{{$blogContent['title']}}</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Starter Section Section -->
        <section id="starter-section" class="starter-section section">

            <div class="container">
                {!! $blogContent['content'] !!}
            </div>

            <div class="container mt-4">
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Ditulis oleh:</strong> {{ $blogContent['author']['fullname'] ?? 'Anonim' }}
                    </div>
                    <div>
                        <strong>Dibuat pada:</strong>
                        {{ $createdAt }}
                    </div>
                </div>
            </div>


        </section>

    </main>
    <livewire:PartialView.HomeIndex.Footer />
</div>