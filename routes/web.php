<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertiController;
use App\Http\Controllers\Client\ProjectController;
use App\Http\Controllers\ProjectDocumentController;
use App\Http\Controllers\UserController;

Route::redirect('/', '/login');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // ===== PROPERTI =====
    Route::get('/properti/karyawan', [PropertiController::class, 'karyawan'])->name('properti.karyawan');
    Route::get('/properti/client', [PropertiController::class, 'client'])->name('properti.client');
    Route::get('/properti/dokumen', [PropertiController::class, 'dokumen'])->name('properti.dokumen');
    Route::get('/properti/fisik', [PropertiController::class, 'fisik'])->name('properti.fisik');
    Route::get('/properti/penilaian', [PropertiController::class, 'penilaian'])->name('properti.penilaian');

    // [TERINTEGRASI NODE.JS] Dokumen Karyawan (list + verifikasi + unduh) - Fitur Verifikasi Dokumen
    Route::prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/documents', [ProjectDocumentController::class, 'index'])->name('documents');
        Route::get('/project-documents/{document}/download', [ProjectDocumentController::class, 'download'])->name('document.download');
        Route::post('/project-documents/{document}/verify', [ProjectDocumentController::class, 'verify'])->name('document.verify'); // Menggunakan API Node.js
        Route::post('/projects/{project}/verify', [ProjectDocumentController::class, 'verifyProject'])->name('project.verify');
        Route::post('/verify-batch', [ProjectDocumentController::class, 'verifyBatch'])->name('verify-batch');
        Route::get('/projects/{project}/download-all', [ProjectDocumentController::class, 'downloadAll'])->name('project.download-all');
    });

    // [LARAVEL NATIVE] Fitur Detail Project & Nilai
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    // [HYBRID CONTROLLER] Nilai Logic moved to NilaiController
    Route::get('/properti/nilai/{projectId}', [\App\Http\Controllers\NilaiController::class, 'show'])->name('properti.nilai.get');
    Route::post('/properti/nilai/{projectId}', [\App\Http\Controllers\NilaiController::class, 'store'])->name('properti.nilai.save');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::match(['put', 'patch'], '/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

    // [LARAVEL NATIVE] ===== CRUD PROJECT CLIENT =====
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });

    // [LARAVEL NATIVE] ===== PROFIL =====
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // [LARAVEL NATIVE] ===== SISTEM CHAT (API Node.js Tersedia untuk Pengembangan) =====
    Route::get('/chats', \App\Livewire\Chat::class)->name('chats.index');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::get('/messages/conversation/{user}', [\App\Http\Controllers\MessageController::class, 'conversation'])->name('messages.conversation');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::match(['put', 'patch'], '/messages/{message}', [\App\Http\Controllers\MessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [\App\Http\Controllers\MessageController::class, 'destroy'])->name('messages.destroy');
    Route::post('/messages/conversation/{user}/read', [\App\Http\Controllers\MessageController::class, 'markRead'])->name('messages.markRead');

    // [TERINTEGRASI NODE.JS] ===== SURVEY / FISIK (PEKERJA TAMBAHAN) =====
    Route::get('/survey/{project_id?}', function ($project_id = null) {
        $project = \App\Models\Project::find($project_id);
        return view('dashboards.pekerjaTambahan.index', compact('project'));
    })->name('survey.index');

    Route::prefix('survey')->name('survey.')->group(function () {
        Route::get('/{project}/elements', [App\Http\Controllers\SurveyController::class, 'getElements'])->name('elements');
        Route::post('/store', [App\Http\Controllers\SurveyController::class, 'store'])->name('store');

        // [PANGGILAN API NODE.JS] Verifikasi Karyawan (Verifikasi Fisik)
        Route::post('/element/{id}/verify', [App\Http\Controllers\SurveyController::class, 'verifyElement'])->name('verify');

        // Tampilan Halaman
        Route::get('/{project}/verification', function (\App\Models\Project $project) {
            return view('modul.survey.verification', compact('project'));
        })->name('verification.page');
    });
});

// Laporan
Route::prefix('laporan')->middleware('auth')->group(function () {
    Route::get('/project', [PropertiController::class, 'laporanProject'])->name('laporan.project');
    Route::get('/project/{id}', [PropertiController::class, 'getProject'])->name('laporan.project.show');
    Route::post('/upload', [PropertiController::class, 'uploadLaporan'])->name('laporan.upload');
    Route::delete('/reset/{id}', [PropertiController::class, 'resetLaporan'])->name('laporan.reset');
    Route::get('/tahunan', [PropertiController::class, 'laporanTahunan'])->name('laporan.tahunan');
    Route::get('/tahunan/{year}', [PropertiController::class, 'getTahunanByYear'])->name('laporan.tahunan.show');
    Route::delete('/project/delete/{id}', [PropertiController::class, 'deleteProject'])->name('laporan.project.delete');
    Route::get('/tahunan/download-zip/{year}', [PropertiController::class, 'downloadZipTahunan'])->name('laporan.tahunan.zip');
});

Route::get('/test-node-api', function () {
    try {
        $response = \Illuminate\Support\Facades\Http::get('http://localhost:3000/');
        return [
            'laravel_message' => 'Connected to Node.js successfully!',
            'node_response' => $response->json()
        ];
    } catch (\Exception $e) {
        return [
            'error' => 'Failed to connect to Node.js API',
            'details' => $e->getMessage()
        ];
    }
});

require __DIR__ . '/auth.php';