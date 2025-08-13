<div>
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.webp" alt=""> -->
                <h1 class="sitename">Consulting.</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a wire:navigate href="{{ route('homePage') }}" class="{{ request()->routeIs('homePage') ? 'active' : '' }}">Home</a></li>
                    <li><a wire:navigate href="{{ route('tentangPage') }}" class="{{ request()->routeIs('tentangPage') ? 'active' : '' }}">Tentang</a></li>
                    <li><a wire:navigate href="{{ route('layananPage') }}" class="{{ request()->routeIs('layananPage') ? 'active' : '' }}">Layanan</a></li>
                    
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('appLoginPage') }}">Masuk</a>

        </div>
    </header>
</div>