<?php

use Illuminate\Support\Facades\Route;
use App\Models\Webinar;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

// PUBLIC
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\SertifikatController;

// ADMIN
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WebinarController;
use App\Http\Controllers\Admin\FormDataDiriController;
use App\Http\Controllers\Admin\EvaluasiQuestionController;
use App\Http\Controllers\Admin\CertificateTemplateController;
use App\Http\Controllers\Admin\EvaluasiReportController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC AREA (PESERTA)
|--------------------------------------------------------------------------
*/

// LANDING PAGE
Route::get('/', function () {
    $webinars = Webinar::where('status', 'published')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('landing', compact('webinars'));
});

// ABSENSI
Route::get('/absensi', [PesertaController::class, 'create']);
Route::post('/absensi', [PesertaController::class, 'store'])
    ->middleware('throttle:10,1');

// EVALUASI PESERTA
Route::get('/evaluasi', [EvaluasiController::class, 'index']);
Route::post('/evaluasi', [EvaluasiController::class, 'store'])
    ->middleware('throttle:10,1');

// SERTIFIKAT PESERTA
Route::get('/sertifikat', [SertifikatController::class, 'index'])
    ->name('sertifikat.index');

Route::get('/sertifikat/download', [SertifikatController::class, 'download'])
    ->name('sertifikat.download');


/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AuthController::class, 'logout'])
    ->name('admin.logout');

Route::get('/admin/forgot-password', [AuthController::class, 'showResetForm'])
    ->name('admin.forgot');

Route::post('/admin/forgot-password', [AuthController::class, 'resetPassword'])
    ->name('admin.reset');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware('auth:admin')
    ->name('admin.')
    ->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/api/webinar/{webinarId}/peserta', [DashboardController::class, 'getPesertaWebinar']);

    // Handle both DELETE and POST (for _method override)
    Route::match(['delete', 'post'], '/dashboard/peserta/{pesertaId}', [DashboardController::class, 'deletePeserta'])
        ->name('dashboard.peserta.delete');

    Route::match(['delete', 'post'], '/dashboard/webinar/{webinarId}/peserta', [DashboardController::class, 'deleteWebinarPeserta'])
        ->name('dashboard.webinar-peserta.delete');

    /*
    |--------------------------------------------------------------------------
    | WEBINAR
    |--------------------------------------------------------------------------
    */
    Route::get('/webinars', [WebinarController::class, 'index'])
        ->name('webinars.index');

    Route::post('/webinars', [WebinarController::class, 'store'])
        ->name('webinars.store');

    Route::put('/webinars/{webinar}', [WebinarController::class, 'update'])
        ->name('webinars.update');

    Route::delete('/webinars/{webinar}', [WebinarController::class, 'destroy'])
        ->name('webinars.destroy');

    /*
    |--------------------------------------------------------------------------
    | FORM DATA DIRI
    |--------------------------------------------------------------------------
    */
    Route::get('/form-data-diri', [FormDataDiriController::class, 'index'])
        ->name('form-datadiri');

    Route::post('/form-data-diri', [FormDataDiriController::class, 'store'])
        ->name('form-datadiri.store');

    Route::put('/form-data-diri/{field}', [FormDataDiriController::class, 'update'])
        ->name('form-datadiri.update');

    Route::delete('/form-data-diri/{field}', [FormDataDiriController::class, 'destroy'])
        ->name('form-datadiri.destroy');

    /*
    |--------------------------------------------------------------------------
    | FORM EVALUASI (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::get('/evaluasi', [EvaluasiQuestionController::class, 'index'])
        ->name('evaluasi.index');

    Route::post('/evaluasi', [EvaluasiQuestionController::class, 'store'])
        ->name('evaluasi.store');

    Route::put('/evaluasi/{question}', [EvaluasiQuestionController::class, 'update'])
        ->name('evaluasi.update');
    
    Route::put(
    '/evaluasi/{question}/scale',
    [EvaluasiQuestionController::class, 'updateScale']
    )->name('evaluasi.update-scale');

    Route::delete('/evaluasi/{question}', [EvaluasiQuestionController::class, 'destroy'])
        ->name('evaluasi.destroy');

    /*
    |--------------------------------------------------------------------------
    | TEMPLATE SERTIFIKAT
    |--------------------------------------------------------------------------
    */

    // HALAMAN UTAMA
    Route::get('/template-sertifikat', [CertificateTemplateController::class, 'index'])
        ->name('template-sertifikat.index');

    // UPLOAD TEMPLATE
    Route::post('/template-sertifikat', [CertificateTemplateController::class, 'store'])
        ->name('template-sertifikat.store');

    // UPDATE SETTING NAMA (AJAX)
    Route::post(
        '/template-sertifikat/{id}/setting',
        [CertificateTemplateController::class, 'updateSetting']
    )->name('template-sertifikat.setting');

    // AKTIFKAN TEMPLATE
    Route::post(
        '/template-sertifikat/{id}/activate',
        [CertificateTemplateController::class, 'activate']
    )->name('template-sertifikat.activate');

    // HAPUS TEMPLATE
    Route::delete(
        '/template-sertifikat/{id}',
        [CertificateTemplateController::class, 'destroy']
    )->name('template-sertifikat.destroy');

    /*
    |--------------------------------------------------------------------------
    | LAPORAN EVALUASI
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan-evaluasi', [EvaluasiReportController::class, 'index'])
    ->name('laporan.evaluasi');

    Route::get('/laporan-evaluasi/webinar/{webinar}', [EvaluasiReportController::class, 'peserta'])
        ->name('laporan.evaluasi.peserta');

    Route::get('/laporan-evaluasi/detail/{peserta}', [EvaluasiReportController::class, 'detail'])
        ->name('laporan.evaluasi.detail');

    Route::get('/laporan-evaluasi/export', [EvaluasiReportController::class, 'export'])
        ->name('laporan.evaluasi.export');

    /*
|--------------------------------------------------------------------------
| PROFIL ADMIN
|--------------------------------------------------------------------------
*/
    Route::get('/profil', [ProfileController::class, 'index'])
        ->name('profil');

    Route::post('/profil/username', [ProfileController::class, 'updateUsername'])
        ->name('profil.username');

    Route::post('/profil/password', [ProfileController::class, 'updatePassword'])
        ->name('profil.password');

    Route::post('/profil/photo', [ProfileController::class, 'uploadPhoto'])
        ->name('profil.photo');

    Route::delete('/profil/photo', [ProfileController::class, 'removePhoto'])
        ->name('profil.photo.delete');

});
