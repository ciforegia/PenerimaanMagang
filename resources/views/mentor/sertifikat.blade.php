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
                                    $isEndDatePassed = $p->end_date && now()->isAfter($p->end_date);
                                    $assignments = $p->user->assignments;
                                    $allAssignmentsGraded = $assignments->count() > 0 && $assignments->every(fn($a) => $a->grade !== null);
                                    $canUploadCertificate = ($p->status === 'finished' || $isEndDatePassed);
                                @endphp
                                
                                @if($canUploadCertificate)
                                    @if($p->user->certificates->count() > 0)
                                        <a href="{{ asset('storage/' . $p->user->certificates->first()->certificate_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Preview Sertifikat</a>
                                    @else
                                        <form method="POST" action="{{ route('mentor.sertifikat.upload', $p->user->id) }}" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                            @csrf
                                            <input type="file" name="certificate" accept="application/pdf" required class="form-control form-control-sm" style="max-width:200px;">
                                            <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-muted">Belum selesai magang</span>
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