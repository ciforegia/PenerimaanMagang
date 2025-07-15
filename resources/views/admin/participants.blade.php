@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Peserta Magang</h2>
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
                            <th>Tugas</th>
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
                                    <td>{{ $row++ }}</td>
                                    <td>{{ $peserta->name }}</td>
                                    <td>{{ $peserta->email ?? '-' }}</td>
                                    <td>{{ $peserta->phone ?? '-' }}</td>
                                    <td>{{ $app->divisi->name ?? '-' }}</td>
                                    <td class="text-center">
                                        @php
                                            $hasSubmittedTask = $peserta->assignments && $peserta->assignments->whereNotNull('submitted_at')->count() > 0;
                                        @endphp
                                        @if($hasSubmittedTask)
                                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                                        @else
                                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $hasCertificate = $peserta->certificates && $peserta->certificates->count() > 0;
                                        @endphp
                                        @if($hasCertificate)
                                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                                        @else
                                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                                        @endif
                                    </td>
                                    <td>{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-' }}</td>
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