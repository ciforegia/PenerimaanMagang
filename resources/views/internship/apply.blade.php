@extends('layouts.dashboard')

@section('title', 'Ajukan Permintaan Magang')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Ajukan Permintaan Magang</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('internship.apply', ['divisi' => $divisi->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="divisi_id" class="form-label">Pilih Divisi</label>
            <select name="divisi_id" id="divisi_id" class="form-select" required>
                <option value="">-- Pilih Divisi --</option>
                <option value="{{ $divisi->id }}" selected>{{ $divisi->name }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="cover_letter" class="form-label">Upload Surat Pengantar (PDF, max 2MB)</label>
            <input type="file" name="cover_letter" id="cover_letter" class="form-control" accept="application/pdf" required>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i>Ajukan Magang</button>
        <a href="{{ url('/dashboard/program') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection 