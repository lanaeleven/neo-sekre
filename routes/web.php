<?php

use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DireksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\JenisInformasiController;
use App\Http\Controllers\JenisRegulasiController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\JenisSuratMasukController;
use App\Http\Controllers\PerjanjianKerjaSamaController;
use App\Http\Controllers\RegulasiController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\SuratIzinController;
use App\Http\Controllers\UndanganController;

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

Route::get('/', [DashboardController::class, 'create'])->middleware('auth')->name('dashboard');
// Route::get('/coba', [SuratMasukController::class, 'coba']);

// Route::get('/email', [EmailController::class, 'index']);

Route::get('/surat-masuk/index', [SuratMasukController::class, 'create'])->middleware('sekre')->name('surat-masuk.index');
Route::get('/surat-masuk/index-ns', [SuratMasukController::class, 'indexNs'])->middleware('notSekre')->name('surat-masuk.index-ns');
Route::get('/surat-masuk/s/{keterangan}', [SuratMasukController::class, 'create'])->middleware('sekre');
Route::get('/laporan/distribusi-surat/{keterangan}', [SuratMasukController::class, 'laporanDistribusiSurat'])->middleware('sekre');
Route::get('/surat-masuk/tambah', [SuratMasukController::class, 'tambah'])->middleware('sekre');
Route::get('/surat-masuk/tambah-ns', [SuratMasukController::class, 'tambahNs'])->middleware('notSekre');
Route::get('/surat-masuk/edit/{suratMasuk}', [SuratMasukController::class, 'edit'])->middleware('sekre');
Route::get('/laporan/surat-masuk/per-direksi', [SuratMasukController::class, 'laporanPerDireksi'])->middleware('sekre');
Route::get('/laporan/distribusi-surat/rekap/per-tujuan', [SuratMasukController::class, 'laporanPerTujuan'])->middleware('sekre');
Route::get('/surat-masuk/disposisi/{suratMasuk}', [SuratMasukController::class, 'disposisi'])->middleware('auth');
Route::get('/surat-masuk/lacak-distribusi/{suratMasuk}', [SuratMasukController::class, 'lacakDistribusi'])->middleware('auth');
Route::get('/surat-masuk/ns/belum-diteruskan', [SuratMasukController::class, 'nonSekreBelumDiteruskan'])->middleware('notSekre')->name('surat-masuk.belum-diteruskan');
Route::get('/surat-masuk/ns/sudah-diteruskan', [SuratMasukController::class, 'nonSekreSudahDiteruskan'])->middleware('notSekre')->name('surat-masuk.sudah-diteruskan');
Route::get('/surat-masuk/ns/sudah-diarsipkan', [SuratMasukController::class, 'nonSekreSudahDiarsipkan'])->middleware('notSekre')->name('surat-masuk.sudah-diarsipkan');
Route::get('/surat-masuk/ns/dikirim', [SuratMasukController::class, 'nonSekreDikirim'])->middleware('notSekre')->name('surat-masuk.yang-dikirim');
Route::get('/surat-masuk/terusan-surat/{idSuratMasuk}/{terusanSurat}/edit', [SuratMasukController::class, 'editTerusanSurat'])->middleware('sekre');
Route::put('/terusan-surat', [SuratMasukController::class, 'updateTerusanSurat']);
Route::post('/surat-masuk/tambah', [SuratMasukController::class, 'store']);
Route::post('/surat-masuk/tambah-ns', [SuratMasukController::class, 'storeNs']);
Route::post('/surat-masuk/save', [SuratMasukController::class, 'save']);
Route::post('/surat-masuk/teruskan', [SuratMasukController::class, 'teruskan']);
Route::post('/surat-masuk/arsipkan', [SuratMasukController::class, 'arsipkan']);
Route::post('/surat-masuk/buka-arsip', [SuratMasukController::class, 'bukaArsip']);
Route::post('/unduh-disposisi-surat-masuk', [SuratMasukController::class, 'unduhDisposisi']);
Route::post('/unduh-rekap-suratmasuk', [SuratMasukController::class, 'rekapSuratMasuk']);

Route::get('/surat-izin/index', [SuratIzinController::class, 'create'])->middleware('sekre')->name('surat-izin.index');
Route::get('/surat-izin/index-ns', [SuratIzinController::class, 'indexNs'])->middleware('notSekre')->name('surat-izin.index-ns');
Route::get('/surat-izin/s/{keterangan}', [SuratIzinController::class, 'create'])->middleware('sekre');
Route::get('/laporan/distribusi-surat/{keterangan}', [SuratIzinController::class, 'laporanDistribusiSurat'])->middleware('sekre');
Route::get('/surat-izin/tambah', [SuratIzinController::class, 'tambah'])->middleware('sekre');
Route::get('/surat-izin/tambah-ns', [SuratIzinController::class, 'tambahNs'])->middleware('notSekre');
Route::get('/surat-izin/edit/{suratIzin}', [SuratIzinController::class, 'edit'])->middleware('sekre');
Route::get('/surat-izin/disposisi/{suratIzin}', [SuratIzinController::class, 'disposisi'])->middleware('auth');
Route::get('/surat-izin/lacak-distribusi/{suratIzin}', [SuratIzinController::class, 'lacakDistribusi'])->middleware('auth');
Route::get('/surat-izin/ns/belum-diteruskan', [SuratIzinController::class, 'nonSekreBelumDiteruskan'])->middleware('notSekre')->name('surat-izin.belum-diteruskan');
Route::get('/surat-izin/ns/sudah-diteruskan', [SuratIzinController::class, 'nonSekreSudahDiteruskan'])->middleware('notSekre')->name('surat-izin.sudah-diteruskan');
Route::get('/surat-izin/ns/sudah-diarsipkan', [SuratIzinController::class, 'nonSekreSudahDiarsipkan'])->middleware('notSekre')->name('surat-izin.sudah-diarsipkan');
Route::get('/surat-izin/ns/dikirim', [SuratIzinController::class, 'nonSekreDikirim'])->middleware('notSekre')->name('surat-izin.yang-dikirim');
// Route::get('/surat-izin/terusan-surat/{idSuratMasuk}/{terusanSurat}/edit', [SuratIzinController::class, 'editTerusanSurat'])->middleware('sekre');
Route::post('/surat-izin/tambah', [SuratIzinController::class, 'store']);
Route::post('/surat-izin/tambah-ns', [SuratIzinController::class, 'storeNs']);
Route::post('/surat-izin/save', [SuratIzinController::class, 'save']);
Route::post('/surat-izin/teruskan', [SuratIzinController::class, 'teruskan']);
Route::post('/surat-izin/arsipkan', [SuratIzinController::class, 'arsipkan']);
Route::post('/surat-izin/buka-arsip', [SuratIzinController::class, 'bukaArsip']);
Route::post('/unduh-disposisi-surat-izin', [SuratIzinController::class, 'unduhDisposisi']);
// Route::post('/unduh-rekap-suratmasuk', [SuratIzinController::class, 'rekapSuratMasuk']);

Route::get('/surat-keluar/index', [SuratKeluarController::class, 'create'])->middleware('sekre')->name('surat-keluar.index');
Route::get('/surat-keluar/tambah', [SuratKeluarController::class, 'tambah'])->middleware('sekre');
Route::get('/surat-keluar/edit/{suratKeluar}', [SuratKeluarController::class, 'edit'])->middleware('sekre');
Route::get('/surat-keluar/{ket}', [SuratKeluarController::class, 'create'])->middleware('sekre');
Route::get('/laporan/surat-keluar/per-jenis-surat', [SuratKeluarController::class, 'laporanPerJenisSurat'])->middleware('sekre');
Route::post('/exportLaporan', [SuratKeluarController::class, 'exportLaporan'])->middleware('sekre');
Route::get('/laporan/surat-keluar/per-direksi', [SuratKeluarController::class, 'laporanPerDireksi'])->middleware('sekre');
Route::post('/surat-keluar/tambah', [SuratKeluarController::class, 'store']);
Route::post('/surat-keluar/save', [SuratKeluarController::class, 'save']);
Route::post('/unduh-rekap-suratkeluar', [SuratKeluarController::class, 'rekapSuratKeluar']);
Route::get('/rekap/{fileName}', [SuratKeluarController::class, 'downloadZip']);
Route::get('/td', [SuratKeluarController::class, 'testDownload']);

Route::get('/spo/index', [SpoController::class, 'create'])->middleware('sekre')->name('spo.index');;
Route::get('/spo/tambah', [SpoController::class, 'tambah'])->middleware('sekre');
Route::get('/spo/edit/{spo}', [SpoController::class, 'edit'])->middleware('sekre');
Route::get('/spo/index/ns/', [SpoController::class, 'listSpoNs'])->middleware('notSekre')->name('spo.index-ns');
Route::post('/spo/tambah', [SpoController::class, 'store']);
Route::post('/spo/save', [SpoController::class, 'save']);
Route::post('/unduh-rekap-spo', [SpoController::class, 'rekapSpo']);

Route::get('/regulasi/index', [RegulasiController::class, 'create'])->middleware('sekre')->name('regulasi.index');
Route::get('/regulasi/tambah', [RegulasiController::class, 'tambah'])->middleware('sekre');
Route::get('/regulasi/edit/{regulasi}', [RegulasiController::class, 'edit'])->middleware('sekre');
Route::get('/regulasi/index/ns/', [RegulasiController::class, 'listRegulasiNs'])->middleware('notSekre')->name('regulasi.index-ns');
Route::post('/regulasi/tambah', [RegulasiController::class, 'store']);
Route::post('/regulasi/save', [RegulasiController::class, 'save']);

Route::get('/informasi/index', [InformasiController::class, 'create'])->middleware('sekre')->name('informasi.index');
Route::get('/informasi/tambah', [InformasiController::class, 'tambah'])->middleware('sekre');
Route::get('/informasi/edit/{informasi}', [InformasiController::class, 'edit'])->middleware('sekre');
Route::get('/informasi/index/ns/', [InformasiController::class, 'listInformasiNs'])->middleware('notSekre')->name('informasi.index-ns');
Route::post('/informasi/tambah', [InformasiController::class, 'store']);
Route::post('/informasi/save', [InformasiController::class, 'save']);

Route::get('/undangan/index', [UndanganController::class, 'create'])->middleware('sekre');
Route::get('/undangan/tambah', [UndanganController::class, 'tambah'])->middleware('sekre');
Route::get('/undangan/edit/{undangan}', [UndanganController::class, 'edit'])->middleware('sekre');
Route::get('/undangan/index/ns/', [UndanganController::class, 'listUndanganNs'])->middleware('notSekre');
Route::post('/undangan/tambah', [UndanganController::class, 'store']);
Route::post('/undangan/save', [UndanganController::class, 'save']);
Route::get('/undangan/terlalu', [UndanganController::class, 'undanganTerlalu'])->middleware('sekre');

Route::get('/pks/index', [PerjanjianKerjaSamaController::class, 'create'])->middleware('sekre')->name('pks.index');
Route::get('/pks/tambah', [PerjanjianKerjaSamaController::class, 'tambah'])->middleware('sekre');
Route::get('/pks/edit/{pks}', [PerjanjianKerjaSamaController::class, 'edit'])->middleware('sekre');
Route::get('/pks/index/ns/', [PerjanjianKerjaSamaController::class, 'listPerjanjianKerjaSamaNs'])->middleware('notSekre')->name('pks.index-ns');
Route::post('/pks/tambah', [PerjanjianKerjaSamaController::class, 'store']);
Route::post('/pks/save', [PerjanjianKerjaSamaController::class, 'save']);

Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
// Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:3,1');
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/direksi/index', [DireksiController::class, 'create'])->middleware('sekre');
Route::get('/direksi/tambah', [DireksiController::class, 'tambah'])->middleware('sekre');
Route::get('/direksi/edit/{direksi}', [DireksiController::class, 'edit'])->middleware('sekre');
Route::post('/direksi/tambah', [DireksiController::class, 'store']);
Route::post('/direksi/save', [DireksiController::class, 'save']);

Route::get('/jenis-surat/index', [JenisSuratController::class, 'create'])->middleware('sekre');
Route::get('/jenis-surat/tambah', [JenisSuratController::class, 'tambah'])->middleware('sekre');
Route::get('/jenis-surat/edit/{jenisSurat}', [JenisSuratController::class, 'edit'])->middleware('sekre');
Route::post('/jenis-surat/tambah', [JenisSuratController::class, 'store']);
Route::post('/jenis-surat/save', [JenisSuratController::class, 'save']);

Route::get('/jenis-surat-masuk/index', [JenisSuratMasukController::class, 'create'])->middleware('sekre');
Route::get('/jenis-surat-masuk/tambah', [JenisSuratMasukController::class, 'tambah'])->middleware('sekre');
Route::get('/jenis-surat-masuk/edit/{jenisSurat}', [JenisSuratMasukController::class, 'edit'])->middleware('sekre');
Route::post('/jenis-surat-masuk/tambah', [JenisSuratMasukController::class, 'store']);
Route::post('/jenis-surat-masuk/save', [JenisSuratMasukController::class, 'save']);

Route::get('/jenis-regulasi/index', [JenisRegulasiController::class, 'create'])->middleware('sekre');
Route::get('/jenis-regulasi/tambah', [JenisRegulasiController::class, 'tambah'])->middleware('sekre');
Route::get('/jenis-regulasi/edit/{jenisRegulasi}', [JenisRegulasiController::class, 'edit'])->middleware('sekre');
Route::post('/jenis-regulasi/tambah', [JenisRegulasiController::class, 'store']);
Route::post('/jenis-regulasi/save', [JenisRegulasiController::class, 'save']);

Route::get('/jenis-informasi/index', [JenisInformasiController::class, 'create'])->middleware('sekre');
Route::get('/jenis-informasi/tambah', [JenisInformasiController::class, 'tambah'])->middleware('sekre');
Route::get('/jenis-informasi/edit/{jenisInformasi}', [JenisInformasiController::class, 'edit'])->middleware('sekre');
Route::post('/jenis-informasi/tambah', [JenisInformasiController::class, 'store']);
Route::post('/jenis-informasi/save', [JenisInformasiController::class, 'save']);

Route::get('/unit/index', [UnitController::class, 'index'])->middleware('sekre');
Route::get('/unit/tambah', [UnitController::class, 'tambah'])->middleware('sekre');
Route::get('/unit/edit/{unit}', [UnitController::class, 'edit'])->middleware('sekre');
Route::post('/unit/tambah', [UnitController::class, 'store']);
Route::post('/unit/save', [UnitController::class, 'save']);
Route::post('/unit/hapus/{id}', [UnitController::class, 'delete']);

Route::get('/data-master/index', [DashboardController::class, 'dataMasterIndex'])->middleware('sekre')->name('data-master.index');
Route::get('/user/index', [UserController::class, 'create'])->middleware('sekre');
Route::get('/user/tambah', [UserController::class, 'tambah'])->middleware('sekre');
Route::get('/user/edit-profil/{user}', [UserController::class, 'editProfil'])->middleware('sekre');
Route::get('/user/edit-password/{user}', [UserController::class, 'editPassword'])->middleware('sekre');
Route::get('/user/edit-lingkup-unit/{user}', [UserController::class, 'editLingkupUnit'])->middleware('sekre');
Route::get('/user/akun-ns', [UserController::class, 'akunNs'])->middleware('notSekre');
Route::get('/user/atur-akun-ns', [UserController::class, 'aturAkunNs'])->middleware('notSekre')->name('user.atur-akun-ns');
Route::get('/user/edit-profil-ns', [UserController::class, 'editProfilNs'])->middleware('notSekre')->name('user.edit-profil-ns');
Route::get('/user/edit-password-ns', [UserController::class, 'editPasswordNs'])->middleware('notSekre')->name('user.edit-password-ns');
Route::get('/user/kelola-khusus/{user}', [UserController::class, 'kelolaKhusus'])->middleware('sekre');
Route::get('/hapusPengirim/{id}', [UserController::class, 'hapusPengirim']);
Route::get('/hapusPenerima/{id}', [UserController::class, 'hapusPenerima']);
Route::post('/user/tambah', [UserController::class, 'store']);
Route::post('/user/save', [UserController::class, 'save']);
Route::post('/user/updateInfoProfil', [UserController::class, 'updateInfoProfil']);
Route::post('/user/updatePasswordNs', [UserController::class, 'updatePasswordNs']);
Route::post('/user/updatePassword', [UserController::class, 'updatePassword']);
Route::post('/user/jadikanKhusus', [UserController::class, 'jadikanKhusus']);
Route::post('/user/batalkanKhusus', [UserController::class, 'batalkanKhusus']);
Route::post('/user/update-lingkup-unit', [UserController::class, 'updateLingkupUnit']);
Route::post('/akun-khusus/tambah-pengirim', [UserController::class, 'tambahPengirim']);
Route::post('/akun-khusus/tambah-penerima', [UserController::class, 'tambahPenerima']);
Route::post('/user/nonaktifkan', [UserController::class, 'nonaktifkan']);
Route::post('/user/aktifkan', [UserController::class, 'aktifkan']);

Route::get('/struktur-organisasi/tambah/{user}', [StrukturOrganisasiController::class, 'tambah'])->middleware('sekre');
Route::post('/struktur-organisasi/store', [StrukturOrganisasiController::class, 'store']);
Route::post('/struktur-organisasi/save', [StrukturOrganisasiController::class, 'save']);

// Route::get('/dashboard-laporan/akun-ns', [DashboardController::class, 'dashboardLaporan'])->middleware('notSekre');