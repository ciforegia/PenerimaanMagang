@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Pengajuan Magang Belum Direspon</h2>
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
                            <th>Tanggal Pengajuan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications->where('status', 'pending') as $i => $app)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $app->user->name ?? '-' }}</td>
                            <td>{{ $app->user->email ?? '-' }}</td>
                            <td>{{ $app->user->phone ?? '-' }}</td>
                            <td>{{ $app->divisi->name ?? '-' }}</td>
                            <td>{{ $app->created_at ? $app->created_at->format('d-m-Y') : '-' }}</td>
                            <td>{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-' }}</td>
                            <td><span class="badge bg-secondary">Pending</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Tidak ada pengajuan pending.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 