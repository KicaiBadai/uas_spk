<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>SPK TOPSIS Pemain Futsal</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (untuk ikon navigasi) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts (opsional, untuk tipografi lebih modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    <style>
        /* Sentuhan UI/UX tambahan */
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            scroll-behavior: smooth;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            transform: translateY(-1px);
        }

        .container {
            max-width: 1280px;
        }

        /* Efek card halus untuk konten yield (opsional, tidak mengganggu konten internal) */
        .content-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            transition: box-shadow 0.2s;
        }

        footer {
            margin-top: 3rem;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

<!-- Navbar Bootstrap 5 - Responsif & Modern -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-trophy-fill me-2"></i>
            SPK TOPSIS Futsal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="/schools">
                        <i class="bi bi-building me-1"></i> Sekolah
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/players">
                        <i class="bi bi-people-fill me-1"></i> Pemain
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/criteria">
                        <i class="bi bi-bar-chart-steps me-1"></i> Kriteria
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/assessments">
                        <i class="bi bi-pencil-square me-1"></i> Penilaian
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link fw-semibold text-warning dropdown-toggle" href="#" id="topsisDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-graph-up me-1"></i> Hasil TOPSIS
                    </a>
                    <ul class="dropdown-menu shadow border-0" aria-labelledby="topsisDropdown">
                        <li><a class="dropdown-item" href="/topsis"><i class="bi bi-trophy me-2"></i>Ranking per Sekolah</a></li>
                        <li><a class="dropdown-item" href="/topsis/detail"><i class="bi bi-calculator me-2"></i>Detail Perhitungan Matriks</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content Area dengan container responsif dan sentuhan kartu putih -->
<div class="container my-4">
    <div class="content-card">
        @yield('content')
    </div>
</div>

<!-- Footer sederhana untuk UX lengkap -->
<footer class="py-4 text-center text-muted small">
    <div class="container">
        <i class="bi bi-calculator-fill me-1"></i> Sistem Pendukung Keputusan | Metode TOPSIS untuk Seleksi Pemain Futsal
        <br class="d-sm-none">
        <span class="mx-1 d-none d-sm-inline">•</span> © 2025
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle (untuk interaksi navbar toggler dan komponen lain jika diperlukan) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>