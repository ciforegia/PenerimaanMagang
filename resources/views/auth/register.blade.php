@extends('layouts.app')

@section('title', 'Registrasi - PT Pos Indonesia')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                        <h3 class="fw-bold">Registrasi Peserta Magang</h3>
                        <p class="text-muted">Daftar untuk mengikuti program magang PT Pos Indonesia</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                           id="username" name="username" value="{{ old('username') }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Aktif<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                                           id="nim" name="nim" value="{{ old('nim') }}" required>
                                    @error('nim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="university" class="form-label">Asal Sekolah/Perguruan Tinggi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('university') is-invalid @enderror" 
                                           id="university" name="university" value="{{ old('university') }}" required>
                                    @error('university')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="major" class="form-label">Jurusan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('major') is-invalid @enderror" 
                                           id="major" name="major" value="{{ old('major') }}" required>
                                    @error('major')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">No HP Aktif <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ktp_number" class="form-label">No KTP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('ktp_number') is-invalid @enderror" 
                                           id="ktp_number" name="ktp_number" value="{{ old('ktp_number') }}" required>
                                    @error('ktp_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" required>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <label for="password" class="form-label">Harus beda dengan username <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="divisi_id" class="form-label">Pilih Divisi <span class="text-danger">*</span></label>
                            <select class="form-select @error('divisi_id') is-invalid @enderror" id="divisi_id" name="divisi_id" required>
                                <option value="">Pilih Divisi</option>
                                @foreach($divisis as $divisi)
                                    <option value="{{ $divisi->id }}" {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>
                                        {{ $divisi->subDirektorat->direktorat->name }} - {{ $divisi->subDirektorat->name }} - {{ $divisi->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('divisi_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ktm" class="form-label">Kartu Tanda Mahasiswa (KTM) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('ktm') is-invalid @enderror" 
                                   id="ktm" name="ktm" accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="form-text">Format yang diterima: JPG, JPEG, PNG, PDF (Maksimal 2MB)</div>
                            @error('ktm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai Magang</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Berakhir Magang</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Daftar & Ajukan Permintaan Magang
                            </button>
                        </div>
                    </form>

                    {{-- Hapus/blokir tampilan peraturan di bawah form registrasi --}}

                    <!-- Modal Peraturan Magang -->
                    <div class="modal fade" id="rulesModal" tabindex="-1" aria-labelledby="rulesModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width: 400px;">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="rulesModalLabel">Peraturan Pelaksanaan Magang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body" style="max-height: 300px; overflow-y: auto;" id="rulesContent">
                            @php $rule = \App\Models\Rule::first(); @endphp
                            @if($rule && $rule->content)
                                <div style="white-space: pre-line;">{!! nl2br(e($rule->content)) !!}</div>
                            @else
                                <span class="text-muted">Belum ada peraturan yang ditetapkan.</span>
                            @endif
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary w-100" id="agreeBtn" disabled>Saya mengerti dan setuju</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="text-center mt-4">
                        <p class="mb-0">Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-primary">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-select divisi if coming from program page
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const divisiId = urlParams.get('divisi');
    
    if (divisiId) {
        const divisiSelect = document.getElementById('divisi_id');
        if (divisiSelect) {
            divisiSelect.value = divisiId;
        }
    }

    // Intercept form submit
    const form = document.querySelector('form');
    const rulesModal = new bootstrap.Modal(document.getElementById('rulesModal'));
    let formShouldSubmit = false;

    if (form) {
        form.addEventListener('submit', function(e) {
            if (!formShouldSubmit) {
                e.preventDefault();
                rulesModal.show();
            }
        });
    }

    // Enable agree button only after scroll to bottom
    const rulesContent = document.getElementById('rulesContent');
    const agreeBtn = document.getElementById('agreeBtn');
    if (rulesContent && agreeBtn) {
        rulesContent.addEventListener('scroll', function() {
            const isBottom = rulesContent.scrollTop + rulesContent.clientHeight >= rulesContent.scrollHeight - 5;
            if (isBottom) {
                agreeBtn.disabled = false;
            }
        });
        // Reset button if modal closed
        document.getElementById('rulesModal').addEventListener('hidden.bs.modal', function () {
            agreeBtn.disabled = true;
            rulesContent.scrollTop = 0;
        });
    }

    // On agree, submit the form
    if (agreeBtn) {
        agreeBtn.addEventListener('click', function() {
            formShouldSubmit = true;
            rulesModal.hide();
            setTimeout(() => {
                form.submit();
            }, 300); // wait modal hide animation
        });
    }
});
</script>
@endsection 