@extends('layouts.mentor-dashboard')

@section('title', 'Profil Pembimbing')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-3">Profil Pembimbing</h1>
    <div class="card mb-4">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Username</dt>
                <dd class="col-sm-9">{{ $user->username }}</dd>
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>
                <dt class="col-sm-3">Nama Pembimbing</dt>
                <dd class="col-sm-9">{{ $divisi ? $divisi->vp : '-' }}</dd>
                <dt class="col-sm-3">Nippos</dt>
                <dd class="col-sm-9">{{ $divisi ? $divisi->nippos : '-' }}</dd>
                <dt class="col-sm-3">Direktorat</dt>
                <dd class="col-sm-9">{{ $direktorat ? $direktorat->name : '-' }}</dd>
                <dt class="col-sm-3">Sub Direktorat</dt>
                <dd class="col-sm-9">{{ $subdirektorat ? $subdirektorat->name : '-' }}</dd>
                <dt class="col-sm-3">Divisi</dt>
                <dd class="col-sm-9">{{ $divisi ? $divisi->name : '-' }}</dd>
            </dl>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Ganti Password</h5>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Lama</label>
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Ganti Password</button>
            </form>
        </div>
    </div>
</div>
@endsection 
