@extends('layouts.app')

@section('title', 'Program Magang - PT Pos Indonesia')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative" style="background: url('/image/Kantor_Pusat_Pos_Indonesia.jpeg') center center/cover no-repeat; min-height: 350px;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(26,41,86,0.85) 0%;"></div>
    <div class="container position-relative" style="z-index:2;">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white py-5">
                <h1 class="display-4 fw-bold mb-4">Program Magang PT Pos Indonesia</h1>
                <p class="lead mb-4">Pilih divisi yang sesuai dengan minat dan keahlian Anda untuk bergabung dalam program magang kami.</p>
            </div>
        </div>
    </div>
</section>

<!-- Program Section -->
<section class="py-5">
    <div class="container">
        @foreach($direktorats as $direktorat)
        <div class="card mb-5 border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    <i class="fas fa-building me-2"></i>{{ $direktorat->name }}
                </h3>
            </div>
            <div class="card-body">
                @foreach($direktorat->subDirektorats as $subDirektorat)
                <div class="mb-4">
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-sitemap me-2"></i>{{ $subDirektorat->name }}
                    </h5>
                    
                    <div class="row">
                        @foreach($subDirektorat->divisis as $divisi)
                        <div class="col-lg-6 col-md-12 mb-3">
                            <div class="card border h-100 card-hover">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">{{ $divisi->name }}</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">PIC:</small><br>
                                            <strong>{{ $divisi->vp }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">NIPPOS:</small><br>
                                            <strong>{{ $divisi->nippos }}</strong>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('register') }}?divisi={{ $divisi->id }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-paper-plane me-1"></i>Ajukan Permintaan Magang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4">Siap Bergabung dengan Program Magang Kami?</h2>
        <p class="lead mb-4">Pilih divisi yang sesuai dan daftar sekarang untuk mendapatkan pengalaman berharga di PT Pos Indonesia</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
        </a>
    </div>
</section>
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
});
</script>
@endsection 
