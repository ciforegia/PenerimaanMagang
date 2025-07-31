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
                $rejectedApplication = $user->internshipApplications()->where('status', 'rejected')->latest()->first();
            @endphp
            
            @if($rejectedApplication)
            <div class="card mt-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>Pengajuan Sebelumnya
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Divisi:</strong> {{ $rejectedApplication->divisi->name }}</p>
                            <p class="mb-1"><strong>Status:</strong> 
                                <span class="badge bg-danger">Ditolak</span>
                            </p>
                            <p class="mb-1"><strong>Tanggal Pengajuan:</strong> {{ $rejectedApplication->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            @if($rejectedApplication->notes)
                                <p class="mb-1"><strong>Alasan Penolakan:</strong></p>
                                <p class="text-muted">{{ $rejectedApplication->notes }}</p>
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