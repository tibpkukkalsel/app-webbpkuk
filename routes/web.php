<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HalamanutamaController;
use App\Http\Controllers\HashtagController;
use App\Http\Controllers\IdentitasController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorganisasiController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VisimisiController;
use App\Http\Controllers\HeroBannerController;
use App\Http\Controllers\InfografisController;
use App\Http\Controllers\SeksiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Website\BerandaController as WebsiteBerandaController;
use App\Http\Controllers\Website\TentangController as WebsiteTentangController;
use App\Http\Controllers\Website\VisimisiController as WebsiteVisimisiController;
use App\Http\Controllers\Website\StorganisasiController as WebsiteStorganisasiController;
use App\Http\Controllers\Website\InformasiController as WebsiteInformasiController;
use App\Http\Controllers\Website\GaleriController as WebsiteGaleriController;
use App\Http\Controllers\Website\AgendaController as WebsiteAgendaController;
use App\Http\Controllers\Website\PegawaiController as WebsitePegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteBerandaController::class, 'view']);
Route::get('/profil/tentang', [WebsiteTentangController::class, 'view'])->name('website.profil.tentang');
Route::get('/profil/visimisi', [WebsiteVisimisiController::class, 'view'])->name('website.profil.visimisi');
Route::get('/profil/struktur-organisasi', [WebsiteStorganisasiController::class, 'view'])->name('website.profil.storganisasi');
Route::get('/profil/pegawai', [WebsitePegawaiController::class, 'view'])->name('website.profil.pegawai');
Route::get('/agenda', [WebsiteAgendaController::class, 'view'])->name('website.agenda');
Route::get('/agenda/{slug}', [WebsiteAgendaController::class, 'detail'])->name('website.agenda.detail');
Route::get('/informasi', [WebsiteInformasiController::class, 'view'])->name('website.informasi');
Route::get('/informasi/{slug}', [WebsiteInformasiController::class, 'detail'])->name('website.informasi.detail');
Route::get('/galeri', function() { return redirect('/galeri/foto'); })->name('website.galeri');
Route::get('/galeri/foto', [WebsiteGaleriController::class, 'view'])->name('website.galeri.foto');
Route::get('/galeri/video', [WebsiteGaleriController::class, 'viewVideo'])->name('website.galeri.video');
Route::get('/galeri/foto/{slug}', [WebsiteGaleriController::class, 'detail'])->name('website.galeri.detail');
Route::get('/galeri/{slug}', [WebsiteGaleriController::class, 'detail']);
Route::get('/gallery/{slug}', [WebsiteGaleriController::class, 'detail']);





Route::prefix('cp-x14')
    ->middleware('auth')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'view'])
            ->name('dashboard');
        //Start Crud PENGGUNA
        Route::get('/pengguna', [UsersController::class, 'view'])
            ->middleware('permission:pengguna.view')
            ->name('pengguna.view');
        Route::post('/pengguna/simpan', [UsersController::class, 'store'])
            ->middleware('permission:pengguna.store')
            ->name('pengguna.store');
        Route::post('/pengguna/edit', [UsersController::class, 'edit'])
            ->middleware('permission:pengguna.edit')
            ->name('pengguna.edit');
        Route::post('/pengguna/update', [UsersController::class, 'update'])
            ->middleware('permission:pengguna.update')
            ->name('pengguna.update');
        Route::get('/pengguna/hapus/{id}', [UsersController::class, 'delete'])
            ->middleware('permission:pengguna.delete')
            ->name('pengguna.delete');
        //end crud PENGGUNA
        //Start Crud KATEGORI
        Route::get('/kategori', [KategoriController::class, 'view'])
            ->middleware('permission:pengguna.view')
            ->name('kategori.view');
        //end crud KATEGORI
        //Start Crud SEKSI
        Route::get('/seksi', [SeksiController::class, 'view'])
            ->middleware('permission:pengguna.view')
            ->name('seksi.view');
        //end crud SEKSI
        //Start Crud JABATAN
        Route::get('/jabatan', [JabatanController::class, 'view'])
            ->middleware('permission:pengguna.view')
            ->name('jabatan.view');
        //end crud JABATAN
        //Start Crud PEGAWAI
        Route::get('/pegawai', [PegawaiController::class, 'view'])
            ->middleware('permission:pengguna.view')
            ->name('pegawai.view');
        //end crud PEGAWAI
        //Start Crud IDENTITAS
        Route::get('/identitas', [IdentitasController::class, 'view'])
            ->middleware('permission:identitas.view')
            ->name('identitas.view');
        //end crud IDENTITAS
        //Start Crud FOOTER
        Route::get('/footer', [FooterController::class, 'view'])
            ->middleware('permission:footer.view')
            ->name('footer.view');
        //end crud FOOTER
        //Start Crud Beranda
        Route::get('/beranda/bannerutama', [BerandaController::class, 'bannerutama_view'])
            ->middleware('permission:beranda.view')
            ->name('bannerutama.view');
         Route::get('/beranda/mitra', [BerandaController::class, 'mitra_view'])
            ->middleware('permission:beranda.view')
            ->name('mitra.view');
        Route::get('/beranda/tajuktentang', [BerandaController::class, 'tajuktentang_view'])
            ->middleware('permission:beranda.view')
            ->name('tajuktentang.view');  
        Route::get('/beranda/tajukcard', [BerandaController::class, 'tajukcard_view'])
            ->middleware('permission:beranda.view')
            ->name('tajukcard.view');
        Route::get('/beranda/kalimattajuk', [BerandaController::class, 'kalimattajuk_view'])
            ->middleware('permission:beranda.view')
            ->name('kalimattajuk.view');    
        //Start Crud HERO BANNER
        Route::get('/hero-banner', [HeroBannerController::class, 'view'])
            ->middleware('permission:beranda.view')
            ->name('hero-banner.view');
        //end crud HERO BANNER

        //Start Crud INFOGRAFIS
        Route::get('/infografis', [InfografisController::class, 'view'])
            ->middleware('permission:beranda.view')
            ->name('infografis.view');
        //end crud INFOGRAFIS
        //end crud BERANDA
        //Start Crud PROFILE WEBSITE
        Route::get('/profile/tentang', [TentangController::class, 'view'])
            ->middleware('permission:profile.konfig')
            ->name('tentang.view');
        Route::get('/profile/visimisi', [VisimisiController::class, 'view'])
            ->middleware('permission:profile.konfig')
            ->name('visimisi.view');
        Route::get('/profile/strukturorganisasi', [StorganisasiController::class, 'view'])
            ->middleware('permission:profile.konfig')
            ->name('storganisasi.view');
        Route::get('/profile/fasilitas', [FasilitasController::class, 'view'])
            ->middleware('permission:profile.konfig')
            ->name('fasilitas.view');
        //end Crud PROFILE WEBSITE
        //Start Crud LAYANAN
        Route::get('/layanan', [LayananController::class, 'view'])
            ->middleware('permission:layanan.konfig')
            ->name('layanan.view');
        Route::get('/layanan/create', [LayananController::class, 'create'])
            ->middleware('permission:layanan.konfig')
            ->name('layanan.create');
             Route::get('/layanan/edit/{id_layanan}', [LayananController::class, 'edit'])
            ->middleware('permission:layanan.konfig')
            ->name('layanan.edit');
        //end Crud LAYANAN
        //Start Crud HASHTAG
        Route::get('/hashtag', [HashtagController::class, 'view'])
            ->middleware('permission:profile.konfig')
            ->name('hashtag.view');
        Route::get('/hashtag/search', [HashtagController::class,'search'])
            ->name('hashtag.search');
        //Start Crud HASHTAG
        //Start Crud AGENDA
        Route::get('/agenda', [AgendaController::class, 'view'])
            ->middleware('permission:agenda.konfig')
            ->name('agenda.view');
        //end Crud AGENDA
        //Start Crud POST
        Route::get('/berita', [BeritaController::class, 'view'])
            ->middleware('permission:post.konfig')
            ->name('berita.view');
        Route::get('/berita/create', [BeritaController::class, 'create'])
            ->middleware('permission:post.konfig')
            ->name('berita.create');
        Route::get('/berita/edit/{id}', [BeritaController::class, 'edit'])
            ->middleware('permission:post.konfig')
            ->name('berita.edit');
        //end Crud POST
        //Start Crud INFO DAN TIPS
        Route::get('/info', [InfoController::class, 'view'])
            ->middleware('permission:post.konfig')
            ->name('info.view');
        Route::get('/info/create', [InfoController::class, 'create'])
            ->middleware('permission:post.konfig')
            ->name('info.create');
        Route::get('/info/edit/{id}', [InfoController::class, 'edit'])
            ->middleware('permission:post.konfig')
            ->name('info.edit');
        //end Crud INFO DAN TIPS
        //Start Crud ARTIKEL
        Route::get('/artikel', [ArtikelController::class, 'view'])
            ->middleware('permission:post.konfig')
            ->name('artikel.view');
        Route::get('/artikel/create', [ArtikelController::class, 'create'])
            ->middleware('permission:post.konfig')
            ->name('artikel.create');
        Route::get('/artikel/edit/{id}', [ArtikelController::class, 'edit'])
            ->middleware('permission:post.konfig')
            ->name('artikel.edit');
        //end Crud ARTIKEL
        //Start Crud VIDEO
        Route::get('/video', [VideoController::class, 'view'])
            ->middleware('permission:post.konfig')
            ->name('video.view');
        Route::get('/video/create', [VideoController::class, 'create'])
            ->middleware('permission:post.konfig')
            ->name('video.create');
        Route::get('/video/edit/{id}', [VideoController::class, 'edit'])
            ->middleware('permission:post.konfig')
            ->name('video.edit');
        //end Crud VIDEO
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
