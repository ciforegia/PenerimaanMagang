@extends('layouts.app')

@section('title', 'Beranda - Sistem Penerimaan Magang PT Pos Indonesia')

@section('content')
<style>
.hero-section {
    background: linear-gradient(135deg, rgba(26,41,86,0.85) 0%, rgba(34,51,102,0.85) 100%), url('/image/Kantor_Pusat_Pos_Indonesia.jpeg') center right/cover no-repeat;
    color: white;
    padding: 100px 0;
    min-height: 500px;
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Selamat Datang di Program Magang PT Pos Indonesia</h1>
                <p class="lead mb-4">Bergabunglah dengan kami dalam program magang yang akan memberikan pengalaman berharga di perusahaan pos terbesar di Indonesia.</p>
                <a href="{{ route('program') }}" class="btn btn-light btn-lg me-3">
                    <i class="fas fa-rocket me-2"></i>Lihat Program Magang
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- About Company Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Tentang PT Pos Indonesia</h2>
                <p class="lead text-muted">
                    PT Pos Indonesia adalah perusahaan pos terbesar di Indonesia yang telah melayani masyarakat sejak tahun 1746. 
                    Kami berkomitmen untuk memberikan layanan pos yang terpercaya dan inovatif untuk seluruh Indonesia.
                </p>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-4 text-center mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Layanan Kurir</h5>
                        <p class="card-text">Layanan kurir cepat dan terpercaya ke seluruh Indonesia dengan jaringan yang luas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <i class="fas fa-university fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Layanan Keuangan</h5>
                        <p class="card-text">Berbagai layanan keuangan seperti transfer, pembayaran, dan tabungan untuk masyarakat.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <i class="fas fa-mobile-alt fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Digital Services</h5>
                        <p class="card-text">Layanan digital modern untuk memudahkan akses masyarakat ke layanan kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Internship Program Preview -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Program Magang PT Pos Indonesia</h2>
                <p class="lead text-muted">
                    Program magang kami memberikan kesempatan kepada mahasiswa untuk belajar langsung dari para profesional 
                    di berbagai divisi dan direktorat PT Pos Indonesia.
                </p>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-graduation-cap me-2"></i>Divisi yang Tersedia
                        </h5>
                        <p class="card-text">Berikut struktur organisasi magang:</p>
                        <div class="accordion" id="direktoratAccordion">
                            @foreach($direktorats as $direktorat)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingDirektorat{{ $direktorat->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDirektorat{{ $direktorat->id }}" aria-expanded="false" aria-controls="collapseDirektorat{{ $direktorat->id }}">
                                            <i class="fas fa-building me-2"></i>{{ $direktorat->name }}
                                        </button>
                                    </h2>
                                    <div id="collapseDirektorat{{ $direktorat->id }}" class="accordion-collapse collapse" aria-labelledby="headingDirektorat{{ $direktorat->id }}" data-bs-parent="#direktoratAccordion">
                                        <div class="accordion-body">
                                            <div class="accordion" id="subdirektoratAccordion{{ $direktorat->id }}">
                                            @foreach($direktorat->subDirektorats as $subDirektorat)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSub{{ $subDirektorat->id }}">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSub{{ $subDirektorat->id }}" aria-expanded="false" aria-controls="collapseSub{{ $subDirektorat->id }}">
                                                            <i class="fas fa-sitemap me-2"></i>{{ $subDirektorat->name }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSub{{ $subDirektorat->id }}" class="accordion-collapse collapse" aria-labelledby="headingSub{{ $subDirektorat->id }}" data-bs-parent="#subdirektoratAccordion{{ $direktorat->id }}">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                            @foreach($subDirektorat->divisis as $divisi)
                                                                <div class="col-lg-6 col-md-12 mb-3">
                                                                    <div class="card border h-100">
                                                                        <div class="card-body">
                                                                            <h6 class="card-title fw-bold">{{ $divisi->name }}</h6>
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <small class="text-muted">PIC:</small><br>
                                                                                    <strong>{{ $divisi->pic_name }}</strong>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <small class="text-muted">NIPPOS:</small><br>
                                                                                    <strong>{{ $divisi->nippos }}</strong>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="fas fa-users me-2"></i>Keuntungan Magang
                        </h5>
                        <p class="card-text">Bergabung dengan program magang kami memberikan berbagai keuntungan:</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-star text-warning me-2"></i>Pengalaman kerja langsung di perusahaan BUMN</li>
                            <li><i class="fas fa-star text-warning me-2"></i>Mentoring dari profesional berpengalaman</li>
                            <li><i class="fas fa-star text-warning me-2"></i>Sertifikat magang resmi</li>
                            <li><i class="fas fa-star text-warning me-2"></i>Networking dengan karyawan PT Pos Indonesia</li>
                            <li><i class="fas fa-star text-warning me-2"></i>Kesempatan untuk bergabung sebagai karyawan</li>
                            <li><i class="fas fa-star text-warning me-2"></i>Pengembangan skill profesional</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('program') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-search me-2"></i>Lihat Semua Divisi
            </a>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="card border-0 bg-primary text-white">
                    <div class="card-body">
                        <i class="fas fa-users fa-2x mb-3"></i>
                        <h3 class="fw-bold">50+</h3>
                        <p class="mb-0">Divisi Tersedia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 bg-success text-white">
                    <div class="card-body">
                        <i class="fas fa-graduation-cap fa-2x mb-3"></i>
                        <h3 class="fw-bold">1000+</h3>
                        <p class="mb-0">Peserta Magang</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 bg-warning text-white">
                    <div class="card-body">
                        <i class="fas fa-map-marker-alt fa-2x mb-3"></i>
                        <h3 class="fw-bold">500+</h3>
                        <p class="mb-0">Kantor Cabang</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 bg-info text-white">
                    <div class="card-body">
                        <i class="fas fa-calendar-alt fa-2x mb-3"></i>
                        <h3 class="fw-bold">276</h3>
                        <p class="mb-0">Tahun Pengalaman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="mb-4">Siap Bergabung dengan Program Magang Kami?</h2>
        <p class="lead mb-4">Daftar sekarang dan dapatkan pengalaman berharga di PT Pos Indonesia</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">
            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
            <i class="fas fa-sign-in-alt me-2"></i>Login
        </a>
    </div>
</section>
@endsection 