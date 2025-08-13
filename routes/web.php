<?php

use App\Livewire\App\Auth\Login as LoginPage;
use App\Livewire\App\Auth\Logout as LogoutPage;

use App\Livewire\App\Account\Info as AccountInfoPage;
use App\Livewire\App\Account\Password as AccountPasswordPage;
use App\Livewire\App\Dashboard\Home as DashboardHome;

use App\Livewire\App\Users\Index as UsersIndexPage;
use App\Livewire\App\Users\Register as RegisterUserPage;
use App\Livewire\App\Users\Details as DetailUserPage;

use App\Livewire\App\Inventory\Index as InventoryIndexPage;
use App\Livewire\App\Inventory\CategoryDetail as InventoryCategoryDetailPage;
use App\Livewire\App\Inventory\CategoryAddNew as InventoryCategoryRegisterPage;

use App\Livewire\App\Inventory\SatuanAddNew as SatuanRegisterPage;
use App\Livewire\App\Inventory\SatuanDetail as SatuanDetailPage;

use App\Livewire\App\Inventory\Item\ShowAll as AllItemsPage;
use App\Livewire\App\Inventory\Item\AddNew as AddNewItemPage;
use App\Livewire\App\Inventory\Item\Details as ItemDetailsPage;
use App\Livewire\App\Inventory\Item\Filters as ItemFilteredPage;

use App\Livewire\App\Inventory\Transactions\ItemIncome as ItemInPage;
use App\Livewire\App\Inventory\Transactions\ItemOutcome as ItemOutPage;

use App\Livewire\App\Inventory\Stocks\PantauStokBarang as PantauStockPage;
use App\Livewire\App\Inventory\Stocks\ShowAll as AllStockPage;
use App\Livewire\App\Inventory\Stocks\LowStock as LowStockPage;

use App\Livewire\App\Reports\Index as ReportPage;
use App\Livewire\App\Reports\Graph as GraphReportPage;

use App\Livewire\App\Supplier\Details as SupplierDetailPage;
use App\Livewire\App\Supplier\Edit as SupplierEditDataPage;
use App\Livewire\App\Supplier\Index as SupplierIndexPage;
use App\Livewire\App\Supplier\Register as RegisterSupplierPage;
use App\Livewire\App\Supplier\ShowAll as AllSuppliersPage;
use App\Livewire\App\Supplier\Search as SupplierSearchResultPage;
use App\Livewire\App\Supplier\SearchWithBarcode as SupplierSearchByBarcodePage;

use App\Livewire\Home\Index;
use App\Livewire\Home\Layanan;
use App\Livewire\Home\Tentang;

use Illuminate\Support\Facades\Route;

//HOME LANDING PAGE
Route::get('/', Index::class)->name('homePage');
Route::get('/tentang', Tentang::class)->name('tentangPage');
Route::get('/layanan', Layanan::class)->name('layananPage');

//APP NO LOGIN
Route::get('/app/login', LoginPage::class)->name('appLoginPage');

//APP REQUIRED LOGIN
Route::get('/app/dashboard', DashboardHome::class)->name('appDashboardPage');
Route::get('/app/account/info', AccountInfoPage::class)->name('accountInfoPage');
Route::get('/app/account/password', AccountPasswordPage::class)->name('accountPasswordPage');
Route::get('/app/logout', LogoutPage::class)->name('appLogoutPage');

//SUPER ADMIN ONLY PAGES
Route::get('/app/users', UsersIndexPage::class)->name('appManageUserPage');
Route::get('/app/user/register', RegisterUserPage::class)->name('appRegisterUserPage');
Route::get('/app/user/{accountId}/details', DetailUserPage::class)->name('appDetailUserPage');

Route::get('/app/inventory', InventoryIndexPage::class)->name('appInventoryIndexPage');
Route::get('/app/inventory/category/register', InventoryCategoryRegisterPage::class)->name('appCategoryRegisterPage');
Route::get('/app/inventory/category/{categoryId}/details', InventoryCategoryDetailPage::class)->name('appCategoryDetailPage');

Route::get('/app/suppliers', SupplierIndexPage::class)->name('appSupplierIndexPage');
Route::get('/app/suppliers/register', RegisterSupplierPage::class)->name('appRegisterSupplierPage');
Route::get('/app/suppliers/all', AllSuppliersPage::class)->name('appShowAllSupplierPage');
Route::get('/app/suppliers/{supplierId}/details', SupplierDetailPage::class)->name('appSupplierDetailPage');
Route::get('/app/suppliers/details/{supplierId}/edit', SupplierEditDataPage::class)->name('appSupplierEditDataPage');
Route::get('/app/suppliers/{query}/search', SupplierSearchResultPage::class)->name('appSupplierSearchResultPage');
Route::get('/app/suppliers/barcode/scan', SupplierSearchByBarcodePage::class)->name('appSupplierSearchByBarcodePage');

Route::get('/app/inventory/units/register', SatuanRegisterPage::class)->name('appUnitRegisterPage');
Route::get('/app/inventory/units/{unitId}/details', SatuanDetailPage::class)->name('appUnitDetailPage');

Route::get('/app/inventory/items/all', AllItemsPage::class)->name('appShowAllItemsPage');
Route::get('/app/inventory/items/add', AddNewItemPage::class)->name('appAddItemPage');
Route::get('/app/inventory/items/{itemId}/detail', ItemDetailsPage::class)->name('appItemDetailsPage');
Route::get('/app/inventory/items/filtered', ItemFilteredPage::class)->name('appFilteredItemsPage');

Route::get('/app/stocks/observer', PantauStockPage::class)->name('appPantauStokPage');
Route::get('/app/stocks/show-all-stocks', AllStockPage::class)->name('appAllStokPage');
Route::get('/app/stocks/low-stock', LowStockPage::class)->name('appLowStokPage');

Route::get('/app/report', ReportPage::class)->name('appReportPage');
Route::get('/app/report/graph/{date}', GraphReportPage::class)->name('appGraphReportPage');

Route::get('/app/inventory/transaction/incom-stock', ItemInPage::class)->name('appItemInPage');
Route::get('/app/inventory/transaction/outcom-stock', ItemOutPage::class)->name('appItemOutPage');

//ADMIN BIASA PAGES
//NANTINYA ADMIN BIASA CUMA BISA LIHAT LAPORAN, CETAK LAPORAN DAN INPUT DATA BARANG MASUK SAJA


//SUPPLIER PAGES
//NANTINYA SUPPLIER CUMA BISA LIHAT LAPORAN, CETAK LAPORAN DAN LIHAT DATA BARANG YANG DIA MASUKIN SAJA