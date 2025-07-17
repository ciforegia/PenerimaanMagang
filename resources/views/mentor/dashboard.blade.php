@extends('layouts.mentor-dashboard')

@section('title', 'Dashboard Pembimbing Lapangan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard Pembimbing Lapangan</h1>
            <p class="text-muted">Welcome, {{ Auth::user()->divisi && Auth::user()->divisi->pic_name ? Auth::user()->divisi->pic_name : Auth::user()->name }}!</p>
            <p class="text-muted">{{ Auth::user()->divisi ? Auth::user()->divisi->name : '-' }}</p>
        </div>
    </div>
    <!-- Notifikasi -->
    @if($pengajuanBaru > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-user-clock me-2"></i>
            <strong>{{ $pengajuanBaru }} pengajuan magang baru</strong> menunggu persetujuan!
            <a href="{{ route('mentor.pengajuan') }}" class="alert-link">Lihat Pengajuan</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($tugasBaruDiupload > 0)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-tasks me-2"></i>
            <strong>{{ $tugasBaruDiupload }} tugas baru</strong> telah di-upload peserta dan menunggu penilaian!
            <a href="{{ route('mentor.penugasan') }}" class="alert-link">Lihat Tugas</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <!-- Statistik Ringkas -->
    <div class="row mb-4">
        <div class="col-md-4 mb-2">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body">
                    <div class="mb-2"><i class="fas fa-user-clock fa-2x text-primary"></i></div>
                    <h6 class="fw-bold mb-1">Pengajuan Menunggu</h6>
                    <h3 class="fw-bold">{{ $pendingApplications }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body">
                    <div class="mb-2"><i class="fas fa-users fa-2x text-success"></i></div>
                    <h6 class="fw-bold mb-1">Peserta Aktif</h6>
                    <h3 class="fw-bold">{{ $activeParticipants }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body">
                    <div class="mb-2"><i class="fas fa-tasks fa-2x text-warning"></i></div>
                    <h6 class="fw-bold mb-1">Tugas Harus Dinilai</h6>
                    <h3 class="fw-bold">{{ $assignmentsToGrade }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Pengajuan Magang -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-clipboard-list me-2"></i>Pengajuan Magang</h5>
                    <p class="card-text">Lihat dan kelola pengajuan magang yang masuk ke divisi Anda.</p>
                    <a href="{{ route('mentor.pengajuan') }}" class="btn btn-primary">Lihat Pengajuan</a>
                </div>
            </div>
        </div>
        <!-- Penugasan & Penilaian -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-tasks me-2"></i>Penugasan & Penilaian</h5>
                    <p class="card-text">Kelola tugas dan penilaian peserta magang di bawah bimbingan Anda.</p>
                    <a href="{{ route('mentor.penugasan') }}" class="btn btn-primary">Berikan Penugasan</a>
                </div>
            </div>
        </div>
        <!-- Sertifikat -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-certificate me-2"></i>Sertifikat</h5>
                    <p class="card-text">Kelola dan cetak sertifikat peserta magang yang telah selesai.</p>
                    <a href="{{ route('mentor.sertifikat') }}" class="btn btn-primary">Upload Sertifikat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 