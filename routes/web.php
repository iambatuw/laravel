<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DutyAssignmentController;
use App\Http\Controllers\DutyScheduleController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SwapRequestController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/* ========================================
   Herkese Acik Sayfalar
   ======================================== */
Route::get('/', [PublicController::class, 'board'])->name('public.board');

/* ========================================
   Giris Sayfasi (Misafir)
   ======================================== */
Route::middleware('guest')->group(function () {
    Route::get('/giris', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/giris', [LoginController::class, 'login'])->middleware('throttle:login')->name('login.attempt');

    // Sifre sifirlama
    Route::get('/sifre-sifirlama', [PasswordResetController::class, 'showForm'])->name('password.request');
    Route::post('/sifre-sifirlama', [PasswordResetController::class, 'reset'])->middleware('throttle:password-reset')->name('password.reset');
});

/* ========================================
   Kimlik Dogrulanmis Kullanicilar
   ======================================== */
Route::middleware('auth')->group(function () {

    // Cikis (Post ve Get destekli)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/sifre', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Nobet Takas Talepleri (Tum kullanicilar)
    Route::resource('takas-talepleri', SwapRequestController::class)
        ->parameters(['takas-talepleri' => 'swapRequest'])
        ->names('swap-requests')
        ->only(['index', 'create', 'store']);

    // Bugunun cizelgesi
    Route::get('/bugunun-nobeti', [DutyScheduleController::class, 'today'])->name('schedules.today');

    /* ========================================
       Sadece Admin Erisimi
       ======================================== */
    Route::middleware('admin')->group(function () {

        // Ogretmen Yonetimi
        Route::resource('ogretmenler', TeacherController::class)
            ->parameters(['ogretmenler' => 'teacher'])
            ->names('teachers');
        Route::get('/ogretmenler-silinen', [TeacherController::class, 'trashed'])->name('teachers.trashed');
        Route::patch('/ogretmenler-geri-yukle/{id}', [TeacherController::class, 'restore'])->name('teachers.restore');

        // Nobet Yerleri
        Route::resource('nobet-yerleri', LocationController::class)
            ->parameters(['nobet-yerleri' => 'location'])
            ->names('locations');
        Route::get('/nobet-yerleri-silinen', [LocationController::class, 'trashed'])->name('locations.trashed');
        Route::patch('/nobet-yerleri-geri-yukle/{id}', [LocationController::class, 'restore'])->name('locations.restore');

        // Nobet Cizelgeleri
        Route::resource('nobet-cizelgeleri', DutyScheduleController::class)
            ->parameters(['nobet-cizelgeleri' => 'schedule'])
            ->names('schedules');
        Route::patch('/nobet-cizelgeleri/{schedule}/yayinla', [DutyScheduleController::class, 'publish'])->name('schedules.publish');
        Route::get('/nobet-cizelgeleri/{schedule}/yazdir', [DutyScheduleController::class, 'print'])->name('schedules.print');

        // Nobet Atamalari
        Route::post('/nobet-atamalari', [DutyAssignmentController::class, 'store'])->name('assignments.store');
        Route::patch('/nobet-atamalari/{assignment}', [DutyAssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('/nobet-atamalari/{assignment}', [DutyAssignmentController::class, 'destroy'])->name('assignments.destroy');
        Route::get('/ogretmen-gecmisi/{teacher}', [DutyAssignmentController::class, 'teacherHistory'])->name('assignments.teacher_history');

        // Takas Talep Onay/Red
        Route::patch('/takas-talepleri/{swapRequest}/onayla', [SwapRequestController::class, 'approve'])->name('swap-requests.approve');
        Route::patch('/takas-talepleri/{swapRequest}/reddet', [SwapRequestController::class, 'reject'])->name('swap-requests.reject');
    });
});
