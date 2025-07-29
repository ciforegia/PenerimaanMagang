@extends('layouts.mentor-dashboard')

@section('title', 'Kirim Sertifikat Magang')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Kirim Sertifikat Magang</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Nama Peserta:</strong> {{ $user->name }}<br>
                        <strong>NIM:</strong> {{ $user->nim }}<br>
                        <strong>Jurusan:</strong> {{ $user->major }}<br>
                        <strong>Universitas/Sekolah:</strong> {{ $user->university }}<br>
                        <strong>Divisi:</strong> {{ $user->divisi->name ?? '-' }}<br>
                        <strong>PIC Divisi:</strong> {{ $user->divisi->vp ?? '-' }}<br>
                        <strong>NIPPOS:</strong> {{ $user->divisi->nippos ?? '-' }}<br>
                        <strong>Periode:</strong> {{ $application->start_date }} s/d {{ $application->end_date }}<br>
                    </div>
                    <form method="POST" action="{{ route('mentor.sertifikat.send', $user->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nomor_sertifikat" class="form-label">Nomor Sertifikat</label>
                            <input type="text" class="form-control" id="nomor_sertifikat" name="nomor_sertifikat" required>
                        </div>
                        <div class="mb-3">
                            <label for="predikat" class="form-label">Predikat</label>
                            <select class="form-control" id="predikat" name="predikat" required>
                                <option value="">-- Pilih Predikat --</option>
                                <option value="Kurang">Kurang</option>
                                <option value="Cukup">Cukup</option>
                                <option value="Baik">Baik</option>
                                <option value="Sangat Baik">Sangat Baik</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('mentor.sertifikat') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Kirim</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('mentor.sertifikat.preview', $user->id) }}" target="_blank" class="mt-2" id="previewForm">
                        @csrf
                        <input type="hidden" name="nomor_sertifikat" id="preview_nomor_sertifikat">
                        <input type="hidden" name="predikat" id="preview_predikat">
                        <button type="button" class="btn btn-outline-primary w-100" onclick="fillPreviewAndSubmit()">Preview</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function fillPreviewAndSubmit() {
    document.getElementById('preview_nomor_sertifikat').value = document.getElementById('nomor_sertifikat').value;
    document.getElementById('preview_predikat').value = document.getElementById('predikat').value;
    document.getElementById('previewForm').submit();
}
</script>
@endsection 
