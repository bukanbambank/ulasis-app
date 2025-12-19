<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('questionnaires', \App\Http\Controllers\QuestionnaireController::class);
    Route::get('questionnaires/{questionnaire}/preview', [\App\Http\Controllers\QuestionnaireController::class, 'preview'])->name('questionnaires.preview');

    Route::resource('qr-codes', \App\Http\Controllers\QrCodeController::class)->except(['edit', 'update', 'show']);
    Route::get('qr-codes/{qrCode}/download', [\App\Http\Controllers\QrCodeController::class, 'download'])->name('qr-codes.download');

    Route::resource('feedback-inbox', \App\Http\Controllers\FeedbackInboxController::class)->parameters(['feedback-inbox' => 'feedback']);

    // Reporting
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/export', [\App\Http\Controllers\ReportController::class, 'export'])->name('reports.export');

    // Support
    Route::resource('support', \App\Http\Controllers\SupportTicketController::class)->only(['index', 'create', 'store', 'show']);
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show']);
    Route::post('/users/{user}/suspend', [\App\Http\Controllers\Admin\UserController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/activate', [\App\Http\Controllers\Admin\UserController::class, 'activate'])->name('users.activate');

    // Support Management
    Route::resource('support', \App\Http\Controllers\Admin\SupportController::class)->only(['index', 'show']);
    Route::post('/support/{support}/reply', [\App\Http\Controllers\Admin\SupportController::class, 'reply'])->name('support.reply');

    // Audit Logs
    Route::get('/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit_logs.index');
});

// Public Feedback Routes (No Auth)
Route::group(['middleware' => ['web']], function () {
    Route::get('/feedback/thank-you', [\App\Http\Controllers\FeedbackController::class, 'thankYou'])->name('feedback.thank-you');
    Route::get('/feedback/{uuid}', [\App\Http\Controllers\FeedbackController::class, 'show'])->name('feedback.show');
    Route::post('/feedback/{uuid}', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');
});

require __DIR__ . '/auth.php';
