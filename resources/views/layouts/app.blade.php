<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', 'E-Sertifikat & Webinar')</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --brand:#b91c1c;
      --brand-2:#dc2626;
      --brand-3:#991b1b;

      --soft:#fff1f1;
      --hero-soft:#f6d6d6;
      --text:#1f2937;
    }

    body{
      color:var(--text);
      font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    }

    .bg-soft{ background:var(--soft); }

    .btn-brand{
      background:var(--brand);
      color:#fff;
      border:none;
    }
    .btn-brand:hover{
      background:var(--brand-2);
      color:#fff;
    }

    .text-brand{ color:var(--brand) !important; }

    .hero{
      padding:5rem 0;
      background: var(--hero-soft);
      border-bottom:1px solid rgba(185,28,28,.12);
    }

    .section-title{
      font-weight:800;
      letter-spacing:.2px;
    }

    .badge-status{
      background: rgba(185,28,28,.20);
      color: var(--brand);
      border:1px solid rgba(185,28,28,.35);
    }

    .card-shadow{
      box-shadow:0 12px 32px rgba(0,0,0,.08);
      border:1px solid rgba(0,0,0,.06);
    }

    .rounded-16{ border-radius:16px; }

    .footer{
      background:#9b0000;
      color:#ffffff;
      border-top:4px solid #7a0000;
    }

    .footer a{
      color:#ffffff;
      text-decoration:none;
      opacity:.9;
    }

    .footer a:hover{
      opacity:1;
      text-decoration:underline;
    }

    .brand-logo{
      width:44px;
      height:44px;
      object-fit:contain;
    }

    .navbar{
      background: rgba(255,255,255,0.65) !important;
      backdrop-filter: blur(10px);
      border-bottom:1px solid rgba(185,28,28,.18);
    }

    .navbar .nav-link{
      color:#374151;
      font-weight:500;
    }

    .navbar .nav-link:hover{
      color:var(--brand);
    }

    .btn-admin-icon{
      width:40px;
      height:40px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      border-radius:12px;
      border:1px solid rgba(185,28,28,.22);
      background: rgba(255,255,255,.45);
      color: var(--brand);
    }

    .offcanvas-admin{
      width:320px !important;
      background: rgba(255,255,255,.65) !important;
      backdrop-filter: blur(12px);
      border-right:1px solid rgba(0,0,0,.08);
    }
  </style>

  {{-- tambahan css per halaman --}}
  @stack('head')
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container py-2">
      <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
        {{-- pastikan file gambar ADA di public/images --}}
        <img src="{{ asset('images/logobadiklat.jpg') }}" class="brand-logo" alt="Logo">
        <div class="lh-sm">
          <div class="fw-bold text-brand">Badiklat Hukum Jateng</div>
          <div class="small text-muted">E-Sertifikat & Webinar</div>
        </div>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
          <li class="nav-item"><a class="nav-link" href="{{ url('/#tentang') }}">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#webinar') }}">Webinar</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#lokasi') }}">Lokasi</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#kontak') }}">Kontak</a></li>

          <li class="nav-item ms-lg-2">
            <button
              type="button"
              class="btn btn-admin-icon"
              data-bs-toggle="offcanvas"
              data-bs-target="#adminPanel"
              title="Admin"
            >
              ☰
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- ===== INI BAGIAN PALING PENTING ===== --}}
  {{-- SEMUA HALAMAN (landing, absensi, peserta) MASUK KE SINI --}}
  @yield('content')

  <!-- OFFCANVAS ADMIN -->
  <div class="offcanvas offcanvas-start offcanvas-admin" tabindex="-1" id="adminPanel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title fw-bold">Panel Admin</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
      <div class="card card-shadow rounded-16 border-0">
        <div class="card-body">
          <div class="fw-semibold mb-2">Badiklat Hukum Jateng</div>
          <a href="/admin/login" class="btn btn-brand w-100">
            Login Admin
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- tambahan js per halaman --}}
  @stack('scripts')
</body>
</html>
