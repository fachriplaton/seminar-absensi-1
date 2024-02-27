<?php

use App\Http\Controllers\data_kegiatan\DataKegiatan;
use App\Http\Controllers\data_kegiatan\DataPesertaKegiatan;
use App\Http\Controllers\data_pendaftaran\DataPendaftaran;
use App\Http\Controllers\data_peserta\DataPeserta;
use App\Http\Controllers\landing_page\LandingPage;
use App\Http\Controllers\scan\ScanAbsen;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;

Route::resource('/', LandingPage::class);
Route::get('/pendaftaran-kegiatan/{id}', [LandingPage::class, 'getDataKegiatan'])->name('getDataKegiatan');
Route::get('/cek-peserta/{id}', [LandingPage::class, 'cekPeserta'])->name('cekPeserta');

Route::resource('/scan', ScanAbsen::class);
Route::get('/data-peserta/{id}', [ScanAbsen::class, 'DataPeserta'])->name('dataPeserta');
Route::get('/scan-peserta/{id}', [ScanAbsen::class, 'ScanPeserta'])->name('ScanPeserta');
Route::post('/update-absen-peserta', [ScanAbsen::class, 'updateAbsenPeserta'])->name('updateAbsenPeserta');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// cards
Route::group(['prefix' => 'administrator'], function () {
  // Main Page Route
  Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard');

  //Data Peserta
  Route::resource('/data-pendaftaran', DataPendaftaran::class);
  Route::get('/get-data-pendaftaran', [DataPendaftaran::class, 'getData'])->name('getDataPendaftaran');
  Route::post('/generate-qr', [DataPendaftaran::class, 'generateQr'])->name('generateQr');
  Route::post('/add-kegiatan', [DataPendaftaran::class, 'addKegiatan'])->name('addKegiatan');

  //Data Kegiatan
  Route::resource('/data-kegiatan', DataKegiatan::class);
  Route::get('/get-data-kegiatan', [DataKegiatan::class, 'getDataKegiatan'])->name('getDataKegiatan');

  //Data Peserta Kegiatan
  Route::resource('/data-kegiatan-peserta', DataPesertaKegiatan::class);
  Route::post('/get-data-peserta-kegiatan/{id}', [DataPesertaKegiatan::class, 'getDataPesertaKegiatan'])->name(
    'getDataPesertaKegiatan'
  );
  Route::post('/delete-data-peserta-kegiatan', [DataPesertaKegiatan::class, 'deleteMultiSelect'])->name(
    'deleteMultiSelect'
  );
  Route::get('/cek-data-peserta/{id}', [DataPesertaKegiatan::class, 'cekDataPeserta'])->name('cekDataPeserta');
  Route::get('/data-dropdown', [DataPesertaKegiatan::class, 'getDataDropdown'])->name('getDataDropdown');
  Route::post('/import-data-peserta', [DataPesertaKegiatan::class, 'import'])->name('import');
});
// Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');
