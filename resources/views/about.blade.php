@extends('layouts.app')

@section('title', 'Tentang Kami - PT Pos Indonesia')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative" style="background: url('/image/Kantor_Pusat_Pos_Indonesia.jpeg') center center/cover no-repeat; min-height: 350px;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(26,41,86,0.85) 0%;"></div>
    <div class="container position-relative" style="z-index:2;">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white py-5">
                <h1 class="display-4 fw-bold mb-4">Tentang PT Pos Indonesia</h1>
            </div>
        </div>
    </div>
</section>

<!-- Company History -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="mb-4">Sejarah Perusahaan</h2>
                <p class="lead">PT Pos Indonesia adalah perusahaan pos terbesar di Indonesia yang telah melayani masyarakat selama lebih dari 276 tahun.</p>
                <p>Didirikan pada tahun 1746, PT Pos Indonesia telah mengalami berbagai transformasi untuk mengikuti perkembangan zaman dan kebutuhan masyarakat. Dari layanan pos tradisional hingga layanan digital modern, kami terus berkomitmen untuk memberikan layanan terbaik kepada masyarakat Indonesia.</p>
                <p>Sebagai Badan Usaha Milik Negara (BUMN), PT Pos Indonesia tidak hanya fokus pada layanan pos, tetapi juga telah berkembang menjadi penyedia layanan keuangan, logistik, dan digital services yang terpercaya.</p>
            </div>
            <div class="col-lg-6">
                <img src="/image/kantor-pusat-pt-pos-indonesia.jpg" alt="Sejarah PT Pos Indonesia" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Vision Mission -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-eye fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Visi</h4>
                        <p class="card-text">Menjadi Postal Operator, Penyedia Jasa Kurir, Logistik dan Keuangan Paling Kompetitif.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-bullseye fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Misi</h4>
                        <p class="card-text">Bertindak Efektif Untuk Mencapai Performance Terbaik</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Business Lines -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Lini Bisnis</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body text-center">
                        <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Layanan Pos & Kurir</h5>
                        <p class="card-text">Layanan pengiriman surat, paket, dan dokumen ke seluruh Indonesia dengan jaringan yang luas dan terpercaya.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body text-center">
                        <i class="fas fa-university fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Layanan Keuangan</h5>
                        <p class="card-text">Berbagai layanan keuangan seperti transfer, pembayaran, tabungan, dan layanan keuangan lainnya untuk masyarakat.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body text-center">
                        <i class="fas fa-mobile-alt fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Digital Services</h5>
                        <p class="card-text">Layanan digital modern seperti e-commerce, digital payment, dan aplikasi mobile untuk memudahkan akses masyarakat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Values -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-3">AKHLAK</h2>
        <p class="text-center mb-4">AKHLAK merupakan budaya perusahaan milik negara Indonesia yang diusulkan oleh Kementerian Badan Usaha Milik Negara. Arti pokok di balik AKHLAK adalah sebagai berikut:</p>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5>Amanah</h5>
                    <p class="text-muted">Memegang teguh kepercayaan yang diberikan</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                    <h5>Kompeten</h5>
                    <p class="text-muted">Terus belajar dan mengembangkan kapabilitas</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-hands-helping fa-3x text-primary mb-3"></i>
                    <h5>Harmonis</h5>
                    <p class="text-muted">Saling peduli dan menghargai perbedaan</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-flag fa-3x text-primary mb-3"></i>
                    <h5>Loyal</h5>
                    <p class="text-muted">Berdedikasi & mengutamakan kepentingan bangsa & negara</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-sync-alt fa-3x text-primary mb-3"></i>
                    <h5>Adaptif</h5>
                    <p class="text-muted">Terus berinovasi dan antusias dalam menggerakkan ataupun menghadapi perubahan</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5>Kolaboratif</h5>
                    <p class="text-muted">Membangun kerja sama yang strategis</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Informasi Kontak</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>
                        <h5>Alamat</h5>
                        <p>Gedung Pos Indonesia<br>Jl. Gedung Kesenian No. 1<br>Jakarta Pusat 10110</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <i class="fas fa-phone fa-2x text-primary mb-3"></i>
                        <h5>Telepon</h5>
                        <p>+62 21 384 0000<br>+62 21 384 0001</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                        <h5>Email</h5>
                        <p>info@posindonesia.co.id<br>cs@posindonesia.co.id</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 