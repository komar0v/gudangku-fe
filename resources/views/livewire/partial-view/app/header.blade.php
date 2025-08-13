<div>
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ url(env('APP_ASSET_URL') . '/img/noun-inventory-management-2825346.png') }}" alt="">
                <span class="d-none d-lg-block">GudangKu</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->


        <nav class="header-nav ms-auto">
            <details class="nav-item dropdown pe-3" style="position: relative;">
                <summary class="nav-link nav-profile d-flex align-items-center pe-0" style="list-style: none; cursor: pointer;">
                    <i class="bi bi-person-square h2"></i>
                    <span class="d-none d-md-block ps-2">{{ session('auth_data.accountdata.fullname') }}</span>
                </summary>

                <ul class="dropdown-menu show" style="position: absolute; right: 0; z-index: 999;">
                    <li class="dropdown-header">
                        <h6>{{ session('auth_data.accountdata.fullname') }}</h6>
                        <span>{{ session('auth_data.accountdata.role') }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" wire:navigate href="{{ route('accountInfoPage') }}">
                            <i class="bi bi-gear"></i>
                            <span>Akun Saya</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                            <i class="bi bi-question-circle"></i>
                            <span>Butuh Bantuan?</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" wire:navigate href="{{ route('appLogoutPage') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </details>

        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

</div>