<div>
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('appDashboardPage') ? '' : 'collapsed' }}" href="{{route('appDashboardPage')}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a wire:navigate class="nav-link {{ request()->routeIs('appSearchTransactions') ? '' : 'collapsed' }}" href="{{route('appSearchTransactions')}}">
                    <i class="bi bi-search"></i>
                    <span>Cari Transaksi</span>
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate class="nav-link {{ request()->routeIs('appLatestTransactions') ? '' : 'collapsed' }}" href="{{route('appLatestTransactions')}}">
                    <i class="bi bi-clock-history"></i>
                    <span>Transaksi Terbaru</span>
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate class="nav-link {{ request()->routeIs('appHutangStatisticsPage') || request()->routeIs('appHutangDetails')||request()->routeIs('appHutangPengrajinPage') ? '' : 'collapsed' }}" href="{{route('appHutangStatisticsPage')}}">
                    <i class="bi bi-wallet2"></i>
                    <span>Hutang Piutang</span>
                </a>
            </li>

            @if(session('auth_data.accountdata.role_code')=='RL_SA')
            
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ request()->routeIs('appOverdueTransactions') ? '' : 'collapsed' }}" href="{{route('appOverdueTransactions')}}">
                    <i class="bi bi-exclamation-octagon-fill"></i>
                    <span>Barang Belum Kembali</span>
                </a>
            </li>

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
                <a class="nav-link {{ request()->routeIs('appRankReportPage') ? '' : 'collapsed' }}" href="{{route('appRankReportPage')}}">
                    <i class="bi bi-trophy-fill"></i>
                    <span>Ranking Pengrajin</span>
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