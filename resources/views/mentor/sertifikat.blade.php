@extends('layouts.mentor-dashboard')

@section('title', 'Sertifikat')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-3">Sertifikat Peserta Magang</h1>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Peserta</th>
                            <th>NIM</th>
                            <th>Status Magang</th>
                            <th>Sertifikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $i => $p)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>{{ $p->user->nim ?? '-' }}</td>
                            <td>
                                @php
                                    $isEndDatePassed = $p->end_date && now()->isAfter($p->end_date);
                                    $assignments = $p->user->assignments;
                                    $allAssignmentsGraded = $assignments->count() > 0 && $assignments->every(fn($a) => $a->grade !== null);
                                @endphp
                                
                                @if($p->status === 'finished' || $isEndDatePassed)
                                    <span class="badge bg-success">Selesai</span>
                                    <br><small class="text-muted">Periode magang berakhir</small>
                                @elseif($p->status === 'accepted')
                                    <span class="badge bg-warning text-dark">Sedang Berlangsung</span>
                                    @if($p->end_date)
                                        <br><small class="text-muted">Berakhir: {{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }}</small>
                                    @endif
                                    @if($allAssignmentsGraded)
                                        <br><small class="text-success"><i class="fas fa-check"></i> Semua tugas dinilai</small>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($p->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $canUploadCertificate = $p->can_upload_certificate;
                                @endphp
                                @if($canUploadCertificate)
                                    @if($p->user->certificates->count() > 0)
                                        <a href="{{ asset('storage/' . $p->user->certificates->first()->certificate_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Preview Sertifikat</a>
                                    @else
                                        <a href="{{ route('mentor.sertifikat.form', $p->user->id) }}" class="btn btn-sm btn-primary">Kirimkan Sertifikat</a>
                                    @endif
                                @else
                                    <span class="text-muted">Upload sertifikat hanya bisa dilakukan jika semua tugas sudah dinilai dan tidak ada tugas status revisi.</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 