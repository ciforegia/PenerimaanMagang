<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/program', [HomeController::class, 'program'])->name('program');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Internship routes
Route::get('/internship', [InternshipController::class, 'index'])->name('internship.index');
Route::get('/internship/apply/{divisi}', [InternshipController::class, 'apply'])->name('internship.apply');
Route::post('/internship/apply/{divisi}', [InternshipController::class, 'submitApply'])->name('internship.apply');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/status', [DashboardController::class, 'status'])->name('dashboard.status');
    Route::get('/dashboard/assignments', [DashboardController::class, 'assignments'])->name('dashboard.assignments');
    Route::post('/dashboard/assignments/{id}/submit', [DashboardController::class, 'submitAssignment'])->name('dashboard.assignments.submit');
    Route::get('/dashboard/certificates', [DashboardController::class, 'certificates'])->name('dashboard.certificates');
    Route::get('/dashboard/certificates/{id}/download', [DashboardController::class, 'downloadCertificate'])->name('dashboard.certificates.download');
    Route::get('/dashboard/program', [DashboardController::class, 'program'])->name('dashboard.program');
    
    // Re-application routes
    Route::get('/dashboard/reapply', [DashboardController::class, 'reapply'])->name('dashboard.reapply');
    Route::post('/dashboard/reapply', [DashboardController::class, 'submitReapply'])->name('dashboard.submit-reapply');

    // Change password routes
    Route::get('/dashboard/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/dashboard/change-password', [AuthController::class, 'changePassword'])->name('password.update');
});

// Mentor (Pembimbing) dashboard routes
Route::middleware(['auth'])->prefix('mentor')->group(function () {
    // Dashboard utama pembimbing
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard');
    // Menu pengajuan magang
    Route::get('/pengajuan', [MentorDashboardController::class, 'pengajuan'])->name('mentor.pengajuan');
    Route::post('/pengajuan/{id}/respon', [MentorDashboardController::class, 'responPengajuan'])->name('mentor.pengajuan.respon');
    // Menu penugasan dan penilaian
    Route::get('/penugasan', [MentorDashboardController::class, 'penugasan'])->name('mentor.penugasan');
    Route::post('/penugasan/tambah', [MentorDashboardController::class, 'tambahPenugasan'])->name('mentor.penugasan.tambah');
    Route::post('/penugasan/{assignment}/nilai', [MentorDashboardController::class, 'beriNilaiPenugasan'])->name('mentor.penugasan.nilai');
    Route::post('/penugasan/{assignment}/revisi', [MentorDashboardController::class, 'setRevisiPenugasan'])->name('mentor.penugasan.revisi');
    // Menu sertifikat
    Route::get('/sertifikat', [MentorDashboardController::class, 'sertifikat'])->name('mentor.sertifikat');
    Route::post('/sertifikat/{user}/upload', [MentorDashboardController::class, 'uploadSertifikat'])->name('mentor.sertifikat.upload');
    // Menu profil
    Route::get('/profil', [MentorDashboardController::class, 'profil'])->name('mentor.profil');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/applications', [AdminController::class, 'applications'])->name('applications');
    Route::get('/participants', [AdminController::class, 'participants'])->name('participants');
    Route::get('/divisions', [AdminController::class, 'divisions'])->name('divisions');
    Route::get('/mentors', [AdminController::class, 'mentors'])->name('mentors');

    // Direktorat CRUD
    Route::post('/direktorat', [AdminController::class, 'storeDirektorat'])->name('direktorat.store');
    Route::put('/direktorat/{id}', [AdminController::class, 'updateDirektorat'])->name('direktorat.update');
    Route::delete('/direktorat/{id}', [AdminController::class, 'deleteDirektorat'])->name('direktorat.delete');
    // Subdirektorat CRUD
    Route::post('/subdirektorat', [AdminController::class, 'storeSubdirektorat'])->name('subdirektorat.store');
    Route::put('/subdirektorat/{id}', [AdminController::class, 'updateSubdirektorat'])->name('subdirektorat.update');
    Route::delete('/subdirektorat/{id}', [AdminController::class, 'deleteSubdirektorat'])->name('subdirektorat.delete');
    // Divisi CRUD
    Route::post('/divisi', [AdminController::class, 'storeDivisi'])->name('divisi.store');
    Route::put('/divisi/{id}', [AdminController::class, 'updateDivisi'])->name('divisi.update');
    Route::delete('/divisi/{id}', [AdminController::class, 'deleteDivisi'])->name('divisi.delete');
    
    // Mentor management
    Route::post('/mentor/{id}/reset-password', [AdminController::class, 'resetMentorPassword'])->name('mentor.reset-password');
});
