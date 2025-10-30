<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DireksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;

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

Route::get('/', [DashboardController::class, 'create'])->middleware('auth');

Route::get('/surat-masuk/index', [SuratMasukController::class, 'create'])->middleware('admin');
Route::get('/surat-masuk/s/{keterangan}', [SuratMasukController::class, 'create'])->middleware('admin');
Route::get('/surat-masuk/tambah', [SuratMasukController::class, 'tambah']);
Route::get('/surat-masuk/edit/{suratMasuk}', [SuratMasukController::class, 'edit'])->middleware('admin');
Route::get('/laporan/surat-masuk/per-direksi', [SuratMasukController::class, 'laporanPerDireksi'])->middleware('admin');
Route::get('/surat-masuk/disposisi/{suratMasuk}', [SuratMasukController::class, 'disposisi']);
// Route::get('/surat-masuk/disposisi/lihat/{suratMasuk}', [SuratMasukController::class, 'lihatSuratDisposisi']);
Route::get('/surat-masuk/d/belum-diteruskan', [SuratMasukController::class, 'direkturBelumDiteruskan'])->middleware('direktur');
Route::get('/surat-masuk/d/sudah-diteruskan', [SuratMasukController::class, 'direkturSudahDiteruskan'])->middleware('direktur');
Route::get('/surat-masuk/kb/belum-diteruskan', [SuratMasukController::class, 'kepalaBagianBelumDiteruskan'])->middleware('kepala');
Route::get('/surat-masuk/kb/sudah-diteruskan', [SuratMasukController::class, 'kepalaBagianSudahDiteruskan'])->middleware('kepala');
Route::get('/surat-masuk/pj/belum-diteruskan', [SuratMasukController::class, 'penanggungJawabBelumDiteruskan'])->middleware('penjab');
Route::get('/surat-masuk/pj/sudah-diteruskan', [SuratMasukController::class, 'penanggungJawabSudahDiteruskan'])->middleware('penjab');
Route::get('/surat-masuk/lacak-distribusi/{suratMasuk}', [SuratMasukController::class, 'lacakDistribusi']);
Route::post('/surat-masuk/tambah', [SuratMasukController::class, 'store']);
Route::post('/surat-masuk/save', [SuratMasukController::class, 'save']);
Route::post('/surat-masuk/teruskan', [SuratMasukController::class, 'teruskan']);

Route::get('/surat-keluar/index', [SuratKeluarController::class, 'create'])->middleware('admin');
Route::get('/surat-keluar/tambah', [SuratKeluarController::class, 'tambah'])->middleware('admin');
Route::get('/surat-keluar/edit/{suratKeluar}', [SuratKeluarController::class, 'edit'])->middleware('admin');
Route::get('/surat-keluar/{ket}', [SuratKeluarController::class, 'create'])->middleware('admin');
Route::get('/laporan/surat-keluar/per-jenis-surat', [SuratKeluarController::class, 'laporanPerJenisSurat'])->middleware('admin');
Route::get('/laporan/surat-keluar/per-direksi', [SuratKeluarController::class, 'laporanPerDireksi'])->middleware('admin');
Route::post('/surat-keluar/tambah', [SuratKeluarController::class, 'store']);
Route::post('/surat-keluar/save', [SuratKeluarController::class, 'save']);

Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/direksi/index', [DireksiController::class, 'create'])->middleware('admin');
Route::get('/direksi/tambah', [DireksiController::class, 'tambah'])->middleware('admin');
Route::get('/direksi/edit/{direksi}', [DireksiController::class, 'edit'])->middleware('admin');
Route::post('/direksi/tambah', [DireksiController::class, 'store']);
Route::post('/direksi/save', [DireksiController::class, 'save']);

Route::get('/jenis-surat/index', [JenisSuratController::class, 'create'])->middleware('admin');
Route::get('/jenis-surat/tambah', [JenisSuratController::class, 'tambah'])->middleware('admin');
Route::get('/jenis-surat/edit/{jenisSurat}', [JenisSuratController::class, 'edit'])->middleware('admin');
Route::post('/jenis-surat/tambah', [JenisSuratController::class, 'store']);
Route::post('/jenis-surat/save', [JenisSuratController::class, 'save']);

Route::get('/user/index', [UserController::class, 'create'])->middleware('admin');
Route::get('/user/tambah', [UserController::class, 'tambah'])->middleware('admin');
Route::get('/user/edit/{user}', [UserController::class, 'edit'])->middleware('admin');
Route::post('/user/tambah', [UserController::class, 'store']);
Route::post('/user/save', [UserController::class, 'save']);