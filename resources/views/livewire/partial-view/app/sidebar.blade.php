<div>
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('appDashboardPage') ? '' : 'collapsed' }}" href="{{route('appDashboardPage')}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            @if(session('auth_data.accountdata.role_code')=='RL_SA')
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ request()->routeIs('appCashflowIndexPage') ? '' : 'collapsed' }}" href="{{route('appCashflowIndexPage')}}">
                    <i class="bi bi-cash-stack"></i>
                    <span>Keuangan</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ request()->routeIs('appItemInOutNonPengrajinPage')||request()->routeIs('appAddItemPage')||request()->routeIs('appItemDetailsPage')||request()->routeIs('appShowAllItemsPage')||request()->routeIs('appUnitDetailPage')||request()->routeIs('appUnitRegisterPage')||request()->routeIs('appCategoryDetailPage')||request()->routeIs('appCategoryRegisterPage')||request()->routeIs('appInventoryIndexPage') ? '' : 'collapsed' }}" href="{{route('appInventoryIndexPage')}}">
                    <i class="bx bxs-box"></i>
                    <span>Inventory Master</span>
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate class="nav-link {{ request()->routeIs('appSupplierEditDataPage')||request()->routeIs('appSupplierIndexPage')||request()->routeIs('appRegisterSupplierPage')||request()->routeIs('appShowAllSupplierPage')||request()->routeIs('appSupplierDetailPage') ? '' : 'collapsed' }}" href="{{route('appSupplierIndexPage')}}">
                    <i class="bi bi-people"></i>
                    <span>Pengrajin Master</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('appStatsObserverPage') ? '' : 'collapsed' }}" href="{{route('appStatsObserverPage')}}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Statistik Hari Ini</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('appGraphReportPage')||request()->routeIs('appReportPage') ? '' : 'collapsed' }}" href="{{route('appReportPage')}}">
                    <i class="bi bi-graph-up"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate class="nav-link {{ request()->routeIs('appDetailUserPage')||request()->routeIs('appManageUserPage')||request()->routeIs('appRegisterUserPage') ? '' : 'collapsed' }}" href="{{route('appManageUserPage')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Kelola Pengguna</span>
                </a>
            </li>
            
            @endif

            <li class="nav-item">
                <a wire:navigate class="nav-link {{ request()->routeIs('appEditImageBlogCoverPage')||request()->routeIs('appEditBlogPage')||request()->routeIs('appCreateBlogPage')||request()->routeIs('appManageBlogsPage')||request()->routeIs('appSiteSettingsIndexPage')||request()->routeIs('appLandingPageFooterSettingsPage') ? '' : 'collapsed' }}" href="{{route('appSiteSettingsIndexPage')}}">
                    <i class="bi bi-tools"></i>
                    <span>Pengaturan Website</span>
                </a>
            </li>
        </ul>

    </aside><!-- End Sidebar-->

</div>