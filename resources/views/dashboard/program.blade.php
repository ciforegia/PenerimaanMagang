@extends('layouts.dashboard')

@section('title', 'Program Magang - PT Pos Indonesia')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Program Magang</h1>
            <p class="text-muted">Struktur organisasi dan divisi PT Pos Indonesia</p>
        </div>
    </div>

    <!-- Re-application Section for Rejected Applications -->
    @php
        $rejectedApplication = $user->internshipApplications()->where('status', 'rejected')->latest()->first();
    @endphp
    
    @if($rejectedApplication && !$hasAccepted)
    <div class="alert alert-warning">
        <strong><i class="fas fa-exclamation-triangle me-2"></i>Pengajuan Sebelumnya Ditolak</strong>
        <br><br>
        <b>Divisi sebelumnya:</b> {{ $rejectedApplication->divisi->name }}<br>
        <b>Alasan penolakan:</b> {{ $rejectedApplication->notes }}<br>
        <span class="text-muted">Anda dapat mengajukan ulang untuk divisi yang sama atau berbeda.</span>
    </div>
    @endif

    @if($hasAccepted)
        <div class="alert alert-success">
            Anda sudah diterima magang di salah satu divisi. Tidak dapat mengajukan permintaan magang ke divisi lain.
        </div>
    @endif

    <div class="accordion" id="direktoratAccordion">
    @foreach($direktorats as $direktorat)
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingDirektorat{{ $direktorat->id }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDirektorat{{ $direktorat->id }}" aria-expanded="false" aria-controls="collapseDirektorat{{ $direktorat->id }}">
                    <i class="fas fa-building me-2"></i>{{ $direktorat->name }}
                </button>
            </h2>
            <div id="collapseDirektorat{{ $direktorat->id }}" class="accordion-collapse collapse" aria-labelledby="headingDirektorat{{ $direktorat->id }}" data-bs-parent="#direktoratAccordion">
                <div class="accordion-body">
                    <div class="accordion" id="subdirektoratAccordion{{ $direktorat->id }}">
                    @foreach($direktorat->subDirektorats as $subDirektorat)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSub{{ $subDirektorat->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSub{{ $subDirektorat->id }}" aria-expanded="false" aria-controls="collapseSub{{ $subDirektorat->id }}">
                                    <i class="fas fa-sitemap me-2"></i>{{ $subDirektorat->name }}
                                </button>
                            </h2>
                            <div id="collapseSub{{ $subDirektorat->id }}" class="accordion-collapse collapse" aria-labelledby="headingSub{{ $subDirektorat->id }}" data-bs-parent="#subdirektoratAccordion{{ $direktorat->id }}">
                                <div class="accordion-body">
                                    <div class="row">
                                    @foreach($subDirektorat->divisis as $divisi)
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <div class="card border h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title fw-bold">{{ $divisi->name }}</h6>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small class="text-muted">PIC:</small><br>
                                                            <strong>{{ $divisi->pic_name }}</strong>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted">NIPPOS:</small><br>
                                                            <strong>{{ $divisi->nippos }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        @if(!$hasAccepted)
                                                            <a href="{{ route('internship.apply', ['divisi' => $divisi->id]) }}" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-paper-plane me-1"></i>Ajukan Permintaan Magang
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>

    <!-- Program Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Program Magang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Keuntungan Program Magang:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Pengalaman kerja langsung di perusahaan BUMN</li>
                                <li><i class="fas fa-check text-success me-2"></i>Mentoring dari profesional berpengalaman</li>
                                <li><i class="fas fa-check text-success me-2"></i>Sertifikat magang resmi</li>
                                <li><i class="fas fa-check text-success me-2"></i>Networking dengan karyawan PT Pos Indonesia</li>
                                <li><i class="fas fa-check text-success me-2"></i>Kesempatan untuk bergabung sebagai karyawan</li>
                                <li><i class="fas fa-check text-success me-2"></i>Pengembangan skill profesional</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Persyaratan Magang:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-file-alt text-info me-2"></i>Surat pengantar dari kampus</li>
                                <li><i class="fas fa-laptop text-info me-2"></i>Memiliki laptop dan koneksi internet</li>
                                <li><i class="fas fa-clock text-info me-2"></i>Dapat mengikuti jam kerja kantor</li>
                                <li><i class="fas fa-heart text-info me-2"></i>Memiliki motivasi tinggi untuk belajar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 