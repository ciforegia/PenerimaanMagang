@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="container-fluid">
    <h2 class="mb-1">Welcome, Admin!</h2>
    <p class="text-muted mb-4">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Peserta Magang</h5>
                    <h2 class="display-4">{{ $totalParticipants }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pengajuan Magang</h5>
                    <h2 class="display-4">{{ $totalApplications }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Peserta Magang Selesai</h5>
                    <h2 class="display-4">{{ $totalFinishedParticipants }}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabel Pengajuan Terbaru -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Pengajuan Magang Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Peserta</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentApplications as $i => $app)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $app->user->name ?? '-' }}</td>
                            <td>{{ $app->divisi->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $app->status == 'finished' ? 'info' : ($app->status == 'accepted' ? 'success' : ($app->status == 'rejected' ? 'danger' : 'secondary')) }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td>{{ $app->created_at->format('d-m-Y') }}</td>
                            <td>{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Belum ada pengajuan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 