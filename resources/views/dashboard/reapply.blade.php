@extends('layouts.dashboard')

@section('title', 'Ajukan Ulang Magang - PT Pos Indonesia')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ajukan Ulang Permintaan Magang</h1>
            <p class="text-muted">Form pengajuan ulang untuk user yang sudah terdaftar</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-edit me-2"></i>Form Pengajuan Ulang
                    </h5>
                </div>
                <div class="card-body">
                    <!-- User Information -->
                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>Informasi Akun
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nama:</strong> {{ $user->name }}</p>
                                <p class="mb-1"><strong>NIM:</strong> {{ $user->nim }}</p>
                                <p class="mb-1"><strong>Universitas:</strong> {{ $user->university }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                                <p class="mb-1"><strong>Jurusan:</strong> {{ $user->major }}</p>
                                <p class="mb-1"><strong>No HP:</strong> {{ $user->phone }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('dashboard.submit-reapply') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="divisi_id" class="form-label">Pilih Divisi <span class="text-danger">*</span></label>
                            <select class="form-select @error('divisi_id') is-invalid @enderror" id="divisi_id" name="divisi_id" required>
                                <option value="">Pilih Divisi</option>
                                @foreach($divisis as $divisi)
                                    <option value="{{ $divisi->id }}" 
                                        {{ (old('divisi_id') == $divisi->id || ($selectedDivisi && $selectedDivisi->id == $divisi->id)) ? 'selected' : '' }}>
                                        {{ $divisi->subDirektorat->direktorat->name }} - {{ $divisi->subDirektorat->name }} - {{ $divisi->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('divisi_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" required>
                            @error('start_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" required>
                            @error('end_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Ajukan Permintaan Magang
                            </button>
                            <a href="{{ route('dashboard.program') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Program Magang
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Previous Application Info -->
            @php
                $latestApplication = $user->internshipApplications()->latest()->first();
            @endphp
            
            @if($latestApplication)
            <div class="card mt-4">
                <div class="card-header 
                    @if($latestApplication->status == 'rejected') bg-warning text-white
                    @elseif($latestApplication->status == 'accepted') bg-success text-white
                    @elseif($latestApplication->status == 'finished') bg-info text-white
                    @else bg-secondary text-white
                    @endif">
                    <h5 class="card-title mb-0">
                        @if($latestApplication->status == 'rejected')
                            <i class="fas fa-exclamation-triangle me-2"></i>Pengajuan Sebelumnya (Ditolak)
                        @elseif($latestApplication->status == 'accepted')
                            <i class="fas fa-check-circle me-2"></i>Pengajuan Sebelumnya (Diterima)
                        @elseif($latestApplication->status == 'finished')
                            <i class="fas fa-trophy me-2"></i>Pengajuan Sebelumnya (Selesai)
                        @else
                            <i class="fas fa-clock me-2"></i>Pengajuan Sebelumnya ({{ ucfirst($latestApplication->status) }})
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Divisi:</strong> {{ $latestApplication->divisi->name }}</p>
                            <p class="mb-1"><strong>Status:</strong> 
                                @if($latestApplication->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($latestApplication->status == 'accepted')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($latestApplication->status == 'finished')
                                    <span class="badge bg-info">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($latestApplication->status) }}</span>
                                @endif
                            </p>
                            <p class="mb-1"><strong>Tanggal Pengajuan:</strong> {{ $latestApplication->created_at->format('d M Y H:i') }}</p>
                            @if($latestApplication->start_date && $latestApplication->end_date)
                                <p class="mb-1"><strong>Periode Magang:</strong> 
                                    @if(is_string($latestApplication->start_date))
                                        {{ \Carbon\Carbon::parse($latestApplication->start_date)->format('d M Y') }}
                                    @else
                                        {{ $latestApplication->start_date->format('d M Y') }}
                                    @endif
                                     - 
                                    @if(is_string($latestApplication->end_date))
                                        {{ \Carbon\Carbon::parse($latestApplication->end_date)->format('d M Y') }}
                                    @else
                                        {{ $latestApplication->end_date->format('d M Y') }}
                                    @endif
                                </p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($latestApplication->status == 'rejected' && $latestApplication->notes)
                                <p class="mb-1"><strong>Alasan Penolakan:</strong></p>
                                <p class="text-muted">{{ $latestApplication->notes }}</p>
                            @elseif($latestApplication->status == 'accepted')
                                <p class="mb-1"><strong>Status:</strong></p>
                                <p class="text-success">Pengajuan Anda telah diterima. Silakan selesaikan persyaratan tambahan.</p>
                            @elseif($latestApplication->status == 'finished')
                                <p class="mb-1"><strong>Status:</strong></p>
                                <p class="text-info">Selamat! Anda telah menyelesaikan program magang sebelumnya.</p>
                            @else
                                <p class="mb-1"><strong>Status:</strong></p>
                                <p class="text-muted">Pengajuan Anda sedang dalam proses review.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-select divisi if coming from program page
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const divisiId = urlParams.get('divisi');
    
    if (divisiId) {
        const divisiSelect = document.getElementById('divisi_id');
        if (divisiSelect) {
            divisiSelect.value = divisiId;
        }
    }

    // Client-side validation for dates
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    if (startDateInput && endDateInput) {
        // Set minimum date for start_date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        startDateInput.min = tomorrow.toISOString().split('T')[0];
        
        // Update end_date minimum when start_date changes
        startDateInput.addEventListener('change', function() {
            if (this.value) {
                const startDate = new Date(this.value);
                const nextDay = new Date(startDate);
                nextDay.setDate(nextDay.getDate() + 1);
                endDateInput.min = nextDay.toISOString().split('T')[0];
                
                // If end_date is before start_date, clear it
                if (endDateInput.value && endDateInput.value <= this.value) {
                    endDateInput.value = '';
                }
            }
        });
    }
});
</script>
@endsection 