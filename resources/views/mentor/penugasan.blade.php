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
                                    <th>Feedback</th>
                                    <th>Revisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($participant->user->assignments->sortBy('created_at') as $assignment)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $assignment->title ?? '-' }}</td>
                                        <td>{{ $assignment->description ?? '-' }}</td>
                                        <td>{{ $assignment->deadline ? \Illuminate\Support\Carbon::parse($assignment->deadline)->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            <span class="text-success"><i class="fas fa-check"></i> Sudah diberi tugas</span>
                                        </td>
                                        <td>
                                            @if($assignment->submissions && $assignment->submissions->count() > 0)
                                                @foreach($assignment->submissions as $i => $submission)
                                                    <div class="mb-1">
                                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            File Tugas {{ $i+1 }}{{ $i == 0 ? '' : ' (Revisi ' . $i . ')'}}
                                                        </a>
                                                        <small class="text-muted">{{ $submission->submitted_at ? \Illuminate\Support\Carbon::parse($submission->submitted_at)->format('d-m-Y H:i') : '' }}</small>
                                                    </div>
                                                @endforeach
                                            @elseif($assignment->file_path)
                                                <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">File Tugas</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $assignment->grade ?? '-' }}</td>
                                        <td>{{ $assignment->feedback ?? '-' }}</td>
                                        <td>
                                            @if($assignment->submission_file_path)
                                                @if($assignment->is_revision === null)
                                                    <form method="POST" action="{{ route('mentor.penugasan.revisi', $assignment->id) }}" class="d-flex align-items-center gap-1">
                                                        @csrf
                                                        <button type="submit" name="is_revision" value="1" class="btn btn-outline-success btn-sm" title="Izinkan Revisi"><i class="fas fa-check"></i></button>
                                                        <button type="submit" name="is_revision" value="0" class="btn btn-outline-danger btn-sm" title="Tolak Revisi"><i class="fas fa-times"></i></button>
                                                    </form>
                                                @elseif($assignment->is_revision === 1)
                                                    <span class="badge bg-danger">Revisi</span>
                                                @elseif($assignment->is_revision === 0)
                                                    <span class="badge bg-success">Tidak Revisi</span>
                                                @else
                                                    <span class="badge bg-secondary">Belum Ditentukan</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="10" class="text-center text-muted">Belum ada tugas yang diberikan oleh pembimbing</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <!-- Form Penilaian di bawah tabel, kanan bawah -->
                    <div class="d-flex justify-content-between align-items-start mt-3">
                        <div>
                            <button class="btn btn-primary mb-3" type="button" id="toggleCreateTaskBtn{{ $participant->user->id }}">
                                <i class="fas fa-plus me-1"></i>Buat Tugas Baru
                            </button>
                        </div>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($participant->user->assignments->sortBy('created_at') as $assignment)
                                @php
                                    // Tugas perlu dinilai/feedback jika:
                                    // - Sudah ada submission_file_path (sudah dikumpulkan)
                                    // - Belum ada grade ATAU (status revisi dan feedback kosong)
                                    $perluNilai = false;
                                    if ($assignment->submission_file_path) {
                                        if (is_null($assignment->grade) && $assignment->is_revision !== 1) {
                                            $perluNilai = true;
                                        } elseif ($assignment->is_revision === 1 && empty($assignment->feedback)) {
                                            $perluNilai = true;
                                        }
                                    }
                                @endphp
                                @if($perluNilai)
                                    <form method="POST" action="{{ route('mentor.penugasan.nilai', $assignment->id) }}" class="d-flex align-items-center gap-2">
                                        @csrf
                                        <span><strong>{{ $assignment->title }}</strong></span>
                                        <input type="number" name="grade" class="form-control form-control-sm" placeholder="Nilai" min="0" max="100" value="{{ $assignment->grade ?? '' }}" style="width:80px;" @if($assignment->is_revision === 1) disabled @else required @endif>
                                        <input type="text" name="feedback" class="form-control form-control-sm" placeholder="Feedback" value="{{ session('feedback_saved_assignment_id') == $assignment->id ? '' : ($assignment->feedback ?? '') }}" style="width:140px;" @if($assignment->is_revision === 1) required @endif>
                                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div id="createTaskForm{{ $participant->user->id }}" style="display:none;">
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
                    <script>
                        document.getElementById('toggleCreateTaskBtn{{ $participant->user->id }}').addEventListener('click', function() {
                            var form = document.getElementById('createTaskForm{{ $participant->user->id }}');
                            form.style.display = (form.style.display === 'none') ? 'block' : 'none';
                        });
                    </script>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection 