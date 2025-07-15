@extends('layouts.mentor-dashboard')

@section('title', 'Penugasan & Penilaian')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">Penugasan & Penilaian</h1>
    @if($participants->isEmpty())
        <div class="alert alert-info">Belum ada peserta magang diterima di divisi Anda.</div>
    @else
        @foreach($participants as $participant)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user me-2"></i>{{ $participant->user->name ?? '-' }} ({{ $participant->user->nim ?? '-' }})</span>
                        <span class="badge bg-success">Diterima</span>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Daftar Penugasan</h6>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>File Tugas</th>
                                    <th>Nilai</th>
                                    <th>Penilaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($participant->user->assignments as $j => $assignment)
                                    <tr>
                                        <td>{{ $j+1 }}</td>
                                        <td>{{ $assignment->title ?? '-' }}</td>
                                        <td>{{ $assignment->description ?? '-' }}</td>
                                        <td>{{ $assignment->deadline ? \Illuminate\Support\Carbon::parse($assignment->deadline)->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            <span class="text-success"><i class="fas fa-check"></i> Sudah diberi tugas</span>
                                        </td>
                                        <td>
                                            @if($assignment->file_path)
                                                <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">File Tugas</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $assignment->grade ?? '-' }}</td>
                                        <td>
                                            @if($assignment->submission_file_path)
                                                <form method="POST" action="{{ route('mentor.penugasan.nilai', $assignment->id) }}" class="d-flex align-items-center">
                                                    @csrf
                                                    <input type="number" name="grade" class="form-control form-control-sm me-2" placeholder="Nilai" min="0" max="100" value="{{ $assignment->grade ?? '' }}" style="width:80px;">
                                                    <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                                </form>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted">Belum ada tugas yang diberikan oleh pembimbing</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h6 class="mb-2">Buat Penugasan Baru</h6>
                    <form method="POST" action="{{ route('mentor.penugasan.tambah') }}" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $participant->user->id }}">
                        <div class="col-md-4">
                            <input type="text" name="title" class="form-control" placeholder="Judul Penugasan" required>
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="deadline" class="form-control" placeholder="Deadline" required>
                        </div>
                        <div class="col-md-4">
                            <input type="file" name="file_path" class="form-control">
                        </div>
                        <div class="col-12">
                            <textarea name="description" class="form-control" placeholder="Deskripsi atau instruksi tugas (boleh kosong)"></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Buat Penugasan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection 