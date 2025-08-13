<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'App Page' }}</title>

    <link href="{{ url(env('APP_ASSET_URL') . '/img/favicon.png') }}" rel="icon">
    <link href="{{ url(env('APP_ASSET_URL') . '/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ url(env('APP_ASSET_URL') . '/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url(env('APP_ASSET_URL') . '/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ url(env('APP_ASSET_URL') . '/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ url(env('APP_ASSET_URL') . '/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ url(env('APP_ASSET_URL') . '/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ url(env('APP_ASSET_URL') . '/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ url(env('APP_ASSET_URL') . '/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ url(env('APP_ASSET_URL') . '/css/style.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Sesuaikan tinggi elemen Select2 agar mirip dengan Bootstrap form-select */
        .select2-container .select2-selection--single {
            height: calc(2.375rem + 2px);
            /* default tinggi form-select Bootstrap 5 */
            padding: 0.375rem 0.75rem;
            line-height: 1.5;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: 10px;
        }
    </style>

    @livewireStyles
</head>

<body>
    {{ $slot }}
    <script src="{{ url(env('APP_ASSET_URL') . '/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ url(env('APP_ASSET_URL') . '/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url(env('APP_ASSET_URL') . '/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ url(env('APP_ASSET_URL') . '/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ url(env('APP_ASSET_URL') . '/vendor/quill/quill.js') }}"></script>
    <script src="{{ url(env('APP_ASSET_URL') . '/vendor/tinymce/tinymce.min.js') }}"></script>


    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ url(env('APP_ASSET_URL') . '/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <!-- Template Main JS File -->

    <script src="{{ url(env('APP_ASSET_URL') . '/js/main.js') }}"></script>
    
    @livewireScripts

    <!-- Header Account Info Dropdown -->
    <script>
        (function() {
            document.addEventListener('click', function(event) {
                document.querySelectorAll('details[open]').forEach(function(details) {
                    if (!details.contains(event.target)) {
                        details.removeAttribute('open');
                    }
                });
            });
        })();
    </script>

    <script>
        (function() {
            $('.select2').select2();
        })();
    </script>

</body>

</html>