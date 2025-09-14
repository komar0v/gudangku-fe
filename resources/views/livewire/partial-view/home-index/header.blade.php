<div>
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="#" class="logo d-flex align-items-center me-auto me-xl-0">
                <img src="{{ url(env('ASSET_URL') . 'assets/img/android-chrome-512x512.png') }}">
                <h1 class="sitename">Emping Merapi</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a wire:navigate href="{{ route('homePage') }}" class="{{ request()->routeIs('homePage') ? 'active' : '' }}">Home</a></li>
                    <li><a wire:navigate href="{{ route('tentangPage') }}" class="{{ request()->routeIs('tentangPage') ? 'active' : '' }}">Tentang</a></li>
                    <li><a wire:navigate href="{{ route('layananPage') }}" class="{{ request()->routeIs('layananPage') ? 'active' : '' }}">Blog</a></li>
                    
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>
</div>