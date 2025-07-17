@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Peserta Magang</h2>
    <!-- Status Legend -->
    <div class="mb-3">
        <span class="me-3"><span class="text-success"><i class="fas fa-check-circle"></i></span> Sudah mengumpulkan tugas / Sudah menerima sertifikat</span>
        <span class="me-3"><span class="text-danger"><i class="fas fa-times-circle"></i></span> Belum mengumpulkan tugas / Belum menerima sertifikat</span>
        <span class="me-3"><span class="text-warning"><i class="fas fa-edit"></i></span> Sedang revisi tugas</span>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Divisi</th>
                            <th>Judul Tugas</th>
                            <th>Status Tugas</th>
                            <th>Sertifikat</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $row = 1; @endphp
                        @foreach($participants as $peserta)
                            @foreach($peserta->internshipApplications->where('status', 'accepted') as $app)
                                <tr>
                                    <td class="align-middle text-start">{{ $row++ }}</td>
                                    <td class="align-middle text-start">{{ $peserta->name }}</td>
                                    <td class="align-middle text-start">{{ $peserta->email ?? '-' }}</td>
                                    <td class="align-middle text-start">{{ $peserta->phone ?? '-' }}</td>
                                    <td class="align-middle text-start">{{ $app->divisi->name ?? '-' }}</td>
                                    <td class="align-middle text-start">
                                        @if($peserta->assignments && $peserta->assignments->count() > 0)
                                            @foreach($peserta->assignments as $i => $tugas)
                                                <div class="pb-2">
                                                    {{ $tugas->title ?? '-' }}
                                                </div>
                                                @if($i < $peserta->assignments->count() - 1)
                                                    <hr class="my-1">
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($peserta->assignments && $peserta->assignments->count() > 0)
                                            @foreach($peserta->assignments as $i => $tugas)
                                                <div class="pb-2">
                                                    @if($tugas->is_revision == 1)
                                                        <span class="text-warning" title="Sedang Revisi"><i class="fas fa-edit"></i></span>
                                                    @elseif($tugas->submitted_at)
                                                        <span class="text-success" title="Sudah Mengumpulkan"><i class="fas fa-check-circle"></i></span>
                                                    @else
                                                        <span class="text-danger" title="Belum Mengumpulkan"><i class="fas fa-times-circle"></i></span>
                                                    @endif
                                                </div>
                                                @if($i < $peserta->assignments->count() - 1)
                                                    <hr class="my-1">
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @php
                                            $hasCertificate = $peserta->certificates && $peserta->certificates->count() > 0;
                                        @endphp
                                        @if($hasCertificate)
                                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                                        @else
                                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-start">{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-' }}</td>
                                    <td class="align-middle text-start">{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        @if($row === 1)
                            <tr><td colspan="7" class="text-center">Tidak ada peserta magang berstatus accepted.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 