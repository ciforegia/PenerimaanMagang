@extends('layouts.mentor-dashboard')

@section('title', 'Kirim Surat Penerimaan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Kirim Surat Penerimaan Magang</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Nama Peserta:</strong> {{ $application->user->name }}<br>
                        <strong>NIM:</strong> {{ $application->user->nim }}<br>
                        <strong>Jurusan:</strong> {{ $application->user->major }}<br>
                        <strong>Asal (Universitas/Sekolah):</strong> {{ $application->user->university }}<br>
                        <strong>Divisi:</strong> {{ $application->divisi->name }}<br>
                        <strong>VP Divisi:</strong> {{ $application->divisi->vp }}<br>
                        <strong>NIPPOS:</strong> {{ $application->divisi->nippos }}<br>
                    </div>
                    <form method="POST" action="{{ route('mentor.pengajuan.acceptance-letter.send', $application->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nomor_surat_penerimaan" class="form-label">Nomor Surat Penerimaan</label>
                            <input type="text" class="form-control" id="nomor_surat_penerimaan" name="nomor_surat_penerimaan" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomor_surat_pengantar" class="form-label">Nomor Surat Pengantar</label>
                            <input type="text" class="form-control" id="nomor_surat_pengantar" name="nomor_surat_pengantar" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_surat_pengantar" class="form-label">Tanggal Surat Pengantar</label>
                            <input type="date" class="form-control" id="tanggal_surat_pengantar" name="tanggal_surat_pengantar" required>
                        </div>
                        <div class="mb-3">
                            <label for="tujuan_surat" class="form-label">Tujuan Surat</label>
                            <input type="text" class="form-control" id="tujuan_surat" name="tujuan_surat" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('mentor.pengajuan') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Kirim</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('mentor.pengajuan.acceptance-letter.preview', $application->id) }}" target="_blank" class="mt-2" id="previewForm">
                        @csrf
                        <input type="hidden" name="nomor_surat_penerimaan" id="preview_nomor_surat_penerimaan">
                        <input type="hidden" name="nomor_surat_pengantar" id="preview_nomor_surat_pengantar">
                        <input type="hidden" name="tanggal_surat_pengantar" id="preview_tanggal_surat_pengantar">
                        <input type="hidden" name="tujuan_surat" id="preview_tujuan_surat">
                        <button type="button" class="btn btn-outline-primary w-100" onclick="fillPreviewAndSubmit()">Preview</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function fillPreviewAndSubmit() {
    document.getElementById('preview_nomor_surat_penerimaan').value = document.getElementById('nomor_surat_penerimaan').value;
    document.getElementById('preview_nomor_surat_pengantar').value = document.getElementById('nomor_surat_pengantar').value;
    document.getElementById('preview_tanggal_surat_pengantar').value = document.getElementById('tanggal_surat_pengantar').value;
    document.getElementById('preview_tujuan_surat').value = document.getElementById('tujuan_surat').value;
    document.getElementById('previewForm').submit();
}
</script>
@endsection 
