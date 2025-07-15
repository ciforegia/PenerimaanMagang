@extends('layouts.dashboard')

@section('title', 'Dashboard - PT Pos Indonesia')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard</h1>
            <p class="text-muted">Selamat datang di dashboard peserta magang PT Pos Indonesia</p>
        </div>
        <div class="text-end">
            <small class="text-muted">Terakhir login: {{ Auth::user()->updated_at->format('d M Y H:i') }}</small>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-3">Informasi Peserta</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Nama:</strong> {{ $user->name }}</p>
                                    <p class="mb-1"><strong>NIM:</strong> {{ $user->nim }}</p>
                                    <p class="mb-1"><strong>Universitas:</strong> {{ $user->university }}</p>
                                    <p class="mb-1"><strong>Jurusan:</strong> {{ $user->major }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                                    <p class="mb-1"><strong>No HP:</strong> {{ $user->phone }}</p>
                                    <p class="mb-1"><strong>Status:</strong> 
                                        @if($application)
                                            @if($application->status == 'accepted')
                                                <span class="badge bg-success">{{ ucfirst($application->status) }}</span>
                                            @elseif($application->status == 'rejected')
                                                <span class="badge bg-danger">{{ ucfirst($application->status) }}</span>
                                            @elseif($application->status == 'finished')
                                                <span class="badge bg-primary">{{ ucfirst($application->status) }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ ucfirst($application->status) }}</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Belum ada pengajuan</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-user-graduate fa-4x text-primary mb-3"></i>
                            <h6>Peserta Magang</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Status -->
    @if($application)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Status Pengajuan Magang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Divisi:</strong> {{ $application->divisi->name }}</p>
                            <p class="mb-1"><strong>Sub Direktorat:</strong> {{ $application->divisi->subDirektorat->name }}</p>
                            <p class="mb-1"><strong>Direktorat:</strong> {{ $application->divisi->subDirektorat->direktorat->name }}</p>
                            <p class="mb-1"><strong>PIC:</strong> {{ $application->divisi->pic_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status:</strong> 
                                @if($application->status == 'accepted')
                                    <span class="badge bg-success">{{ ucfirst($application->status) }}</span>
                                @elseif($application->status == 'rejected')
                                    <span class="badge bg-danger">{{ ucfirst($application->status) }}</span>
                                @elseif($application->status == 'finished')
                                    <span class="badge bg-primary">{{ ucfirst($application->status) }}</span>
                                @else
                                    <span class="badge bg-warning">{{ ucfirst($application->status) }}</span>
                                @endif
                            </p>
                            <p class="mb-1"><strong>Tanggal Pengajuan:</strong> {{ $application->created_at->format('d M Y') }}</p>
                            @if($application->notes)
                                <p class="mb-1"><strong>Catatan:</strong> {{ $application->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $user->internshipApplications->count() }}</h4>
                    <small>Pengajuan Magang</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-tasks fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $user->assignments->count() }}</h4>
                    <small>Total Tugas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $user->assignments->where('submitted_at', null)->count() }}</h4>
                    <small>Tugas Pending</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-certificate fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $user->certificates->count() ?? 0 }}</h4>
                    <small>Sertifikat</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tasks me-2"></i>Tugas Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->assignments->count() > 0)
                        @foreach($user->assignments->take(3) as $assignment)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1">{{ Str::limit($assignment->description, 50) }}</h6>
                                <small class="text-muted">{{ $assignment->created_at->format('d M Y') }}</small>
                            </div>
                            <div>
                                @if($assignment->submitted_at)
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <a href="{{ route('dashboard.assignments') }}" class="btn btn-primary btn-sm">Lihat Semua Tugas</a>
                    @else
                        <p class="text-muted mb-0">Belum ada tugas yang diberikan.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-certificate me-2"></i>Sertifikat Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->certificates->count() > 0)
                        @foreach($user->certificates->take(3) as $certificate)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1">Sertifikat Magang</h6>
                                <small class="text-muted">{{ $certificate->created_at->format('d M Y') }}</small>
                            </div>
                            <div>
                                <a href="{{ route('dashboard.certificates.download', $certificate->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        <a href="{{ route('dashboard.certificates') }}" class="btn btn-primary btn-sm">Lihat Semua Sertifikat</a>
                    @else
                        <p class="text-muted mb-0">Belum ada sertifikat yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 