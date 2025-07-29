<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pembimbing Lapangan')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #e3ecfa 0%, #b6c9e6 100%);
            color: #223366;
        }
        .sidebar .nav-link {
            color: #223366;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.25rem 0;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color:rgb(0, 213, 246);
            background-color: #dde6f7;
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
    </style>
    @yield('styles')
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0">
            <div class="sidebar p-3">
                <div class="text-center mb-4">
                    <img src="/image/PosInd_Logo.png" alt="Logo PT Pos Indonesia" style="height:90px; margin-bottom:10px;">
                </div>
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Welcome</h6>
                    <p class="mb-0 fw-bold">{{ Auth::user()->divisi && Auth::user()->divisi->vp ? Auth::user()->divisi->vp : Auth::user()->name }}</p>
                </div>
                <hr class="my-3">
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}" href="{{ route('mentor.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('mentor.pengajuan') ? 'active' : '' }}" href="{{ route('mentor.pengajuan') }}">
                        <i class="fas fa-clipboard-list"></i>Pengajuan Magang
                    </a>
                    <a class="nav-link {{ request()->routeIs('mentor.penugasan') ? 'active' : '' }}" href="{{ route('mentor.penugasan') }}">
                        <i class="fas fa-tasks"></i>Penugasan & Penilaian
                    </a>
                    <a class="nav-link {{ request()->routeIs('mentor.sertifikat') ? 'active' : '' }}" href="{{ route('mentor.sertifikat') }}">
                        <i class="fas fa-certificate"></i>Sertifikat
                    </a>
                </nav>
                <hr class="my-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-0">
            <div class="main-content">
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="navbar-nav ms-auto">
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user me-1"></i>{{ Auth::user()->divisi && Auth::user()->divisi->vp ? Auth::user()->divisi->vp : Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('mentor.profil') }}">Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 3000);
    });
</script>
@yield('scripts')
</body>
</html>
