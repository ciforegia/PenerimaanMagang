@extends('layouts.admin-dashboard')

@php
use Carbon\Carbon;
@endphp

@section('admin-content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-0">Monitoring Pembimbing Lapangan</h3>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Pembimbing dan Peserta Magang</h5>
                </div>
                <div class="card-body">
                    @if($mentors->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pembimbing</th>
                                        <th>Divisi</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Pengajuan Pending</th>
                                        <th>Pengajuan Diterima</th>
                                        <th>Peserta Magang</th>
                                        <th>Nama Peserta</th>
                                        <th>Judul Tugas</th>
                                        <th>Status</th>
                                        <th>Sertifikat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $rowNumber = 1; @endphp
                                    @foreach($mentors->unique('id') as $mentor)
                                    @php
                                        $divisi = $mentor->divisi;
                                        $pendingCount = $divisi ? $divisi->internshipApplications->where('status', 'pending')->count() : 0;
                                        $acceptedCount = $divisi ? $divisi->internshipApplications->where('status', 'accepted')->count() : 0;
                                        $participants = $divisi ? $divisi->internshipApplications->whereIn('status', ['accepted', 'finished'])->filter(function($p) {
                                            return !$p->end_date || \Carbon\Carbon::parse($p->end_date)->gte(now());
                                        }) : collect();
                                        $participantCount = $participants->count();
                                        $rowspan = max(1, $participantCount);
                                    @endphp
                                    @if($participantCount > 0)
                                        @foreach($participants as $participantIndex => $participant)
                                        <tr>
                                            @if($participantIndex == 0)
                                                <td rowspan="{{ $rowspan }}">{{ $rowNumber++ }}</td>
                                                <td rowspan="{{ $rowspan }}">
                                                    <strong>{{ $mentor->name }}</strong>
                                                    @if($mentor->divisi)
                                                        <br><small class="text-muted">{{ $mentor->divisi->subDirektorat->direktorat->name ?? '' }}</small>
                                                    @endif
                                                </td>
                                                <td rowspan="{{ $rowspan }}">
                                                    @if($mentor->divisi)
                                                        <span class="badge bg-info">{{ $mentor->divisi->name }}</span>
                                                    @else
                                                        <span class="badge bg-warning">Tidak ada divisi</span>
                                                    @endif
                                                </td>
                                                <td rowspan="{{ $rowspan }}">
                                                    <span class="badge bg-primary">{{ $mentor->username }}</span>
                                                </td>
                                                <td rowspan="{{ $rowspan }}">{{ $mentor->email }}</td>
                                                <td rowspan="{{ $rowspan }}">
                                                    <span class="badge bg-warning">{{ $pendingCount }}</span>
                                                </td>
                                                <td rowspan="{{ $rowspan }}">
                                                    <span class="badge bg-info">{{ $acceptedCount }}</span>
                                                </td>
                                                <td rowspan="{{ $rowspan }}">
                                                    <span class="badge bg-success">{{ $participantCount }}</span>
                                                </td>
                                            @endif
                                            <td>
                                                <strong>{{ $participant->user->name }}</strong>
                                                <br><small class="text-muted">{{ $participant->user->nim ?? '-' }}</small>
                                            </td>
                                            <td>
                                                @if($participant->user->assignments->count() > 0)
                                                    @foreach($participant->user->assignments as $assignment)
                                                        <div class="mb-1">
                                                            <small class="fw-bold">{{ $assignment->title }}</small>
                                                            @if($assignment->deadline)
                                                                <br><small class="text-muted">Deadline: {{ Carbon::parse($assignment->deadline)->format('d/m/Y') }}</small>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Belum ada tugas</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($participant->user->assignments->count() > 0)
                                                    @foreach($participant->user->assignments as $assignment)
                                                        <div class="mb-2">
                                                            <span class="text-success"><i class="fas fa-check"></i> Sudah diberi tugas</span>
                                                            <br>
                                                            @if($assignment->grade !== null)
                                                                <span class="text-success"><i class="fas fa-star"></i> Nilai: {{ $assignment->grade }}/100</span>
                                                            @else
                                                                <span class="text-warning"><i class="fas fa-clock"></i> Belum dinilai</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <i class="fas fa-times text-danger" title="Tidak ada tugas"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if($participant->user->certificates->count() > 0)
                                                    <i class="fas fa-check text-success" title="Ada sertifikat"></i>
                                                @else
                                                    <i class="fas fa-times text-danger" title="Tidak ada sertifikat"></i>
                                                @endif
                                            </td>
                                            @if($participantIndex == 0)
                                                <td rowspan="{{ $rowspan }}">
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $mentor->id }}">
                                                        <i class="fas fa-key me-1"></i>Reset Password
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>{{ $rowNumber++ }}</td>
                                            <td><strong>{{ $mentor->name }}</strong></td>
                                            <td>
                                                @if($mentor->divisi)
                                                    <span class="badge bg-info">{{ $mentor->divisi->name }}</span>
                                                @else
                                                    <span class="badge bg-warning">Tidak ada divisi</span>
                                                @endif
                                            </td>
                                            <td><span class="badge bg-primary">{{ $mentor->username }}</span></td>
                                            <td>{{ $mentor->email }}</td>
                                            <td><span class="badge bg-warning">{{ $pendingCount }}</span></td>
                                            <td><span class="badge bg-info">{{ $acceptedCount }}</span></td>
                                            <td><span class="badge bg-success">0</span></td>
                                            <td class="text-center text-muted" colspan="4">Tidak ada peserta magang aktif</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $mentor->id }}">
                                                    <i class="fas fa-key me-1"></i>Reset Password
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada pembimbing lapangan</h5>
                            <p class="text-muted">Pembimbing akan dibuat otomatis ketika Anda menambahkan divisi baru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Penting
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-user-plus me-2"></i>Pembuatan Otomatis</h6>
                            <ul class="list-unstyled">
                                <li>• User pembimbing dibuat otomatis saat menambah divisi baru</li>
                                <li>• Username: mentor_[nama_divisi]</li>
                                <li>• Password default: mentor123</li>
                                <li>• Email: username@posindonesia.co.id</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-shield-alt me-2"></i>Keamanan</h6>
                            <ul class="list-unstyled">
                                <li>• Pembimbing harus mengubah password saat login pertama</li>
                                <li>• Password dapat direset oleh admin</li>
                                <li>• Akses terbatas hanya ke divisi masing-masing</li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6><i class="fas fa-info-circle me-2"></i>Keterangan Status</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success me-2"></i>Tugas dikumpulkan</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>Tugas belum dikumpulkan</li>
                                        <li><i class="fas fa-star text-success me-2"></i>Sudah dinilai</li>
                                        <li><i class="fas fa-clock text-warning me-2"></i>Belum dinilai</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success me-2"></i>Ada sertifikat</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>Tidak ada sertifikat</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>Tidak ada tugas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modals -->
@foreach($mentors as $mentor)
<div class="modal fade" id="resetPasswordModal{{ $mentor->id }}" tabindex="-1" aria-labelledby="resetPasswordModalLabel{{ $mentor->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel{{ $mentor->id }}">Reset Password Pembimbing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.mentor.reset-password', $mentor->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Password akan direset menjadi "mentor123"
                    </div>
                    <p>Reset password untuk pembimbing: <strong>{{ $mentor->name }}</strong></p>
                    <p>Username: <code>{{ $mentor->username }}</code></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@endsection

@push('scripts')
<script>
    // Auto hide alert after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
@endpush 