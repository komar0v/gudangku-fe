<div>
    <livewire:PartialView.App.Header />
    <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js"></script>

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Konten Blog</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Site Settings</li>
                    <li class="breadcrumb-item active">Blog</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            <a href="{{route('appManageBlogsPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">

                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Edit Konten Blog</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label">Gambar Cover</label>
                                    <a wire:navigate href="{{route('appEditImageBlogCoverPage', ['blogId'=>$blogsData['id']])}}" class="btn btn-success"> Edit Gambar Cover</a>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Author</label>
                                    <input readonly type="text" class="form-control" value="{{$blogsData['author']['fullname']}}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Judul</label>
                                    <input wire:model="title" type="text" class="form-control" placeholder="Judul blog/artikel">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ringkasan</label>
                                    <input type="text" wire:model="ringkasan" class="form-control" placeholder="Ringkasan isi blog/artikel">
                                    @error('ringkasan')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Waktu Dibuat</label>
                                    <input readonly type="text" class="form-control" value="{{$createdAt}}">
                                </div>
                                <div class="col-12" wire:ignore>
                                    <label class="form-label">Konten Blog</label>
                                    <textarea style="width: 100%;" id="SEeditor">{{$content}}</textarea>
                                </div>
                                @error('content')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="text-center">
                                    <input type="hidden" id="content" wire:model="content">
                                    <button wire:click="saveAndPublish" class="btn btn-success"><i class="bi bi-upload me-1"></i>Publish Sekarang</button>
                                    <div wire:loading wire:target="saveAndPublish">
                                        <img width="60" height="60" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                    </div>

                                    <button wire:click="saveAsDraft" class="btn btn-primary"><i class="bi bi-archive-fill me-1"></i>Save as Draft</button>
                                    <div wire:loading wire:target="saveAsDraft">
                                        <img width="60" height="60" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                    </div>

                                    <button wire:click="deleteBlog" class="btn btn-danger"><i class="bi bi-trash me-1"></i>Hapus Blog</button>
                                    <div wire:loading wire:target="deleteBlog">
                                        <img width="60" height="60" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editor = SUNEDITOR.create('SEeditor', {
                height: '400px',
                buttonList: [
                    ['undo', 'redo'],
                    ['bold', 'underline', 'italic', 'strike'],
                    ['font', 'fontSize', 'formatBlock'],
                    ['fontColor', 'hiliteColor'],
                    ['align', 'list', 'table'],
                    ['link', 'image', 'video'],
                    ['fullScreen', 'showBlocks', 'codeView']
                ],
                // default image handling = base64 inline
                imageUploadUrl: null,
                imageUploadSizeLimit: 5 * 1024 * 1024, // 5MB
            });

            editor.onChange = function(contents) {
                const hidden = document.getElementById("content");
                hidden.value = contents;
                hidden.dispatchEvent(new Event('input', {
                    bubbles: true
                })); // penting untuk Livewire
            };
        });
    </script>
</div>