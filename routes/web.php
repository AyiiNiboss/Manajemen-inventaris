<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengeluaranController;
use App\Models\PembelianModel;
use App\Models\PengeluaranModel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/






//Route Login
Route::get('/', function () {
    return view('login.login');
})->name('login');
Route::post('/', [AuthController::class, 'proses']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-proses', [AuthController::class, 'registerProses']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Menu Pengguna Sistem
    Route::get('/pengguna-sistem', [AuthController::class, 'index'])->name('pengguna-sistem');
    Route::get('/pengguna-sistem-delete/{id}', [AuthController::class, 'delete'])->name('pengguna-sistem-delete');
    Route::get('/pengguna-sistem-edit/{id}', [AuthController::class, 'edit'])->name('pengguna-sistem-edit');
    Route::get('/pengguna-sistem-reset/{id}', [AuthController::class, 'resetPassword'])->name('pengguna-sistem-reset');
    Route::put('/pengguna-sistem-edit/proses/{id}', [AuthController::class, 'update'])->name('pengguna-sistem-edit-proses');
    Route::get('/pennguna-sistem-acc/{id}', [AuthController::class, 'AccUser'])->name('acc-user');
    Route::get('/pengguna-sistem-tolak/{id}', [AuthController::class, 'TolakUser'])->name('tolak-user');

    // Menu Supplier
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
    Route::post('/supplier-add', [SupplierController::class, 'store'])->name('supplier-add');
    Route::get('/supplier-delete/{id}', [SupplierController::class, 'delete'])->name('supplier-delete');
    Route::put('/supplier-edit-proses/{id}', [SupplierController::class, 'update'])->name('supplier-edit');

    // Menu Satuan
    Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan');
    Route::post('/satuan-add', [SatuanController::class, 'store'])->name('satuan-add');
    Route::get('/satuan-delete/{id}', [SatuanController::class, 'delete'])->name('satuan-delete');
    Route::put('/satuan-edit/proses/{id}', [SatuanController::class, 'update'])->name('satuan-edit-proses');

    // Menu Barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::post('/barang-add', [BarangController::class, 'store'])->name('barang-add');
    Route::put('/barang-edit/proses/{id}', [BarangController::class, 'update'])->name('barang-edit-proses');
    Route::get('/barang-delete/{id}', [BarangController::class, 'delete'])->name('barang-delete');
    // Route::post('/getSatuan', [obatController::class, 'getSatuan'])->name('get-satuan');
    // Route::get('/test', [obatController::class, 'test']);

    // Menu Stok Barang
    Route::get('/stok-barang', [StokController::class, 'index'])->name('stok-barang');

    // Menu Setting User Ubah password
    Route::put('/setting-user/{id}', [AuthController::class, 'setting'])->name('setting-user');

    // Menu Barang Masuk
    Route::get('/barang-masuk', [PembelianController::class, 'index'])->name('barang-masuk');
    Route::get('/barang-masuk-view/{id}', [PembelianController::class, 'view'])->name('barang-masuk-view');
    Route::get('/barang-masuk-delete/{id}', [PembelianController::class, 'delete'])->name('barang-masuk-delete');
    Route::get('/barang-masuk-add', [PembelianController::class, 'create'])->name('barang-masuk-add');
    Route::post('/getBarang', [PembelianController::class, 'getBarang'])->name('get-barang');
    Route::get('/pembelian-barang/add/{id}', [PembelianController::class, 'getData']);
    Route::post('/getSupplier', [PembelianController::class, 'getSupplier'])->name('get-supplier');
    Route::post('/barang-masuk-add/proses', [PembelianController::class, 'store'])->name('barang-masuk-proses');

    // Menu Barang Keluar
    Route::get('/barang-keluar', [PengeluaranController::class, 'index'])->name('barang-keluar');
    Route::get('/barang-keluar-add', [PengeluaranController::class, 'create'])->name('barang-keluar-add');
    Route::post('/barang-keluar-add/proses', [PengeluaranController::class, 'store'])->name('barang-keluar-proses');
    Route::get('/pengeluaran-barang/add/{id}', [PengeluaranController::class, 'getData']);
    Route::get('/barang-keluar-view/{id}', [PengeluaranController::class, 'view'])->name('barang-keluar-view');
    Route::get('/barang-keluar-acc', [PengeluaranController::class, 'AccTampil'])->name('barang-keluar-acc-tampil');
    Route::get('/barang-keluar-acc/proses/{id}', [PengeluaranController::class, 'ACC'])->name('barang-keluar-acc');
    Route::post('/barang-keluar-tolak/proses/{id}', [PengeluaranController::class, 'Tolak'])->name('barang-keluar-tolak');
    Route::get('/barang-keluar-delete/{id}', [PengeluaranController::class, 'delete'])->name('barang-keluar-delete');
    Route::post('/getBarangPengeluaran', [PengeluaranController::class, 'getBarangPengeluaran'])->name('get-barang-pengeluaran');

    // Menu Laporan Barang masuk
    Route::get('/laporan-barang-masuk', [PembelianController::class, 'LaporanPembelian'])->name('laporan-pembelian');
    Route::get('/laporan-barang-masuk-view/{id}', [PembelianController::class, 'LaporanPembelianView'])->name('laporan-pembelian-view');
    Route::get('/filter-barang-masuk', [PembelianController::class, 'FilterBarangMasuk'])->name('filter-barang-masuk');
    Route::get('/laporan-barang-masuk-pdf/{id}', [PembelianController::class, 'ExportPDF'])->name('pembelian-pdf');
    Route::get('/laporan-barang-masuk-pdf', [PembelianController::class, 'ExportAllPDF'])->name('pembelian-all-pdf');
    Route::get('/laporan-barang-masuk-pdf/{start_date}/{end_date}', [PembelianController::class, 'ExportAllPDFFilter'])->name('pembelian-all-pdf-filter');
    Route::get('/laporan-barang-masuk-excel', [PembelianController::class, 'ExportExcel'])->name('pembelian-excels');

    // Menu Laporan Barang Keluar
    Route::get('/laporan-barang-keluar', [PengeluaranController::class, 'LaporanPengeluaran'])->name('laporan-pengeluaran');
    Route::get('/laporan-barang-keluar-view/{id}', [PengeluaranController::class, 'LaporanPengeluaranView'])->name('laporan-pengeluaran-view');
    ROute::get('/laporan-barang-keluar-pdf/{id}', [PengeluaranController::class, 'ExportPDF'])->name('pengeluaran-pdf');
    Route::get('/filter-barang-keluar', [PengeluaranController::class, 'FilterBarangKeluar'])->name('filter-barang-keluar');
    Route::get('/laporan-barang-keluar-pdf/{start_date}/{end_date}', [PengeluaranController::class, 'ExportAllPDFFilter'])->name('pengeluaran-all-pdf-filter');
    Route::get('/laporan-barang-keluar-pdf', [PengeluaranController::class, 'ExportAllPDF'])->name('pengeluaran-all-pdf');
    Route::get('/laporan-barang-keluar-excel', [PengeluaranController::class, 'ExportExcel'])->name('pengeluaran-excels');
        
    // Menu Laporan Stok Barang
    Route::get('/laporan-stok-barang', [StokController::class, 'LaporanStok'])->name('laporan-stok-barang');
    Route::get('/filter-stok-barang', [StokController::class, 'FilterStokBarang'])->name('filter-stok-barang');
    Route::get('/laporan-stok-barang-pdf/{start_date}/{end_date}', [StokController::class, 'ExportAllPDFFilter'])->name('stok-all-pdf-filter');
    Route::get('/laporan-stok-barang-pdf', [StokController::class, 'ExportAllPDF'])->name('stok-all-pdf');
    Route::get('/laporan-stok-barang-excel', [StokController::class, 'ExportExcel'])->name('stok-excels');

});