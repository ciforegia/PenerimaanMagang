@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="container mt-4">
    <h2>Edit Peraturan</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.rules.update') }}">
        @csrf
        <div class="mb-3">
            <label for="content" class="form-label">Isi Peraturan</label>
            <textarea name="content" id="content" class="form-control" rows="10" required>{{ old('content', $rule ? $rule->content : '') }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection 