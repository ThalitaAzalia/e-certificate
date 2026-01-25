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

      /* soft transparan biar background tetap keliatan */
      --soft: rgba(255,255,255,.62);

      --text:#1f2937;
    }

    body{
      margin:0;
      color:var(--text);
      font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, "Noto Sans", "Liberation Sans", sans-serif;

      background: linear-gradient(180deg, #ffffff 0%, #ffffff 35%, #f6f7f9 100%);
      position: relative;
      min-height: 100vh;
    }

    body::before{
      content:"";
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 0;
      opacity: .55;

      background-image:
        radial-gradient(rgba(155,0,0,.07) 1px, transparent 1px),
        radial-gradient(rgba(155,0,0,.05) 1px, transparent 1px),
        repeating-linear-gradient(135deg, rgba(155,0,0,.035) 0 1px, transparent 1px 10px);

      background-size: 42px 42px, 64px 64px, 18px 18px;
      background-position: 0 0, 18px 18px, 0 0;
    }

    body::after{
      content:"";
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 0;
      opacity: 1;

      background:
        radial-gradient(900px 520px at 18% 18%, rgba(155,0,0,.18), transparent 62%),
        radial-gradient(850px 520px at 82% 70%, rgba(155,0,0,.14), transparent 58%);
    }

    body > *{
      position: relative;
      z-index: 1;
    }

    .bg-soft{
      background: rgba(255,255,255,.62) !important;
    }

    .btn-brand{
      background: #ffffff !important;
      color: #9b0000 !important;
      border: 2px solid #9b0000 !important;
      font-weight: 700;
    }
    .btn-brand:hover{
      background: #9b0000 !important;
      color: #ffffff !important;
      border-color: #9b0000 !important;
    }

    .text-brand{ color:var(--brand) !important; }

    .hero{
      padding-top:5rem;
      padding-bottom:5rem;
      background: transparent;
      border-bottom:1px solid rgba(15,23,42,.07);
      position: relative;
      overflow: hidden;
    }
    .hero::before{
      content:"";
      position:absolute;
      inset:-90px;
      background:
        radial-gradient(720px 440px at 18% 20%, rgba(155,0,0,.10), transparent 62%),
        radial-gradient(720px 440px at 82% 70%, rgba(155,0,0,.08), transparent 62%);
      pointer-events:none;
      z-index:0;
    }
    .hero .container{ position: relative; z-index: 1; }

    .section-title{
      font-weight:800;
      letter-spacing:.2px;
    }

    .badge-status{
      background: #e8f5e9;
      color: #2e7d32;
      border: 1px solid #a5d6a7;
      font-weight: 600;
    }

    .card-shadow{
      box-shadow:
        0 20px 45px rgba(0,0,0,.12),
        0 6px 16px rgba(0,0,0,.08);
      border:1px solid rgba(0,0,0,.05);
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
      width:35px;
      height:35px;
      object-fit:contain;
    }
    
    .brand-logo-sm{
      width:28px;
      height:28px;
      object-fit:contain;
    }

    .footer img{
      max-height: 32px !important;
      width: auto !important;
    }

    .navbar{
      background: rgba(255,255,255,0.75) !important;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-bottom:1px solid rgba(185,28,28,.18);
    }

    .navbar .nav-link{
      color:#374151;
      padding: 4px 8px !important;
      border-radius: 5px;
      font-weight: 600;
      font-size: 14px;
      line-height: 1.1;
      display: inline-flex;
      align-items: center;
      transition: background .2s ease, color .2s ease, box-shadow .2s ease;
    }
    .navbar .nav-link:hover,
    .navbar .nav-link.active{
      background: #b91c1c;
      color: #fff !important;
      box-shadow: 0 6px 12px rgba(185, 28, 28, 0.18);
    }

    .btn-admin-icon{
      width:36px;
      height:36px;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      border-radius:10px;
      border:1.2px solid rgba(185,28,28,.22);
      background: rgba(255,255,255,.45);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      color: var(--brand);
    }
    .btn-admin-icon:hover{
      background: rgba(255,255,255,.65);
    }

    .offcanvas-admin{
      width:320px !important;
      background: rgba(255,255,255,.75) !important;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-right:1px solid rgba(0,0,0,.08);
    }
    .offcanvas-admin .offcanvas-header{
      border-bottom:1px solid rgba(0,0,0,.06);
    }
  </style>

  {{-- tambahan css per halaman --}}
  @stack('styles')
  @stack('head')
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg sticky-top navbar-light">
    <div class="container py-1">
      <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
        <img src="{{ asset('images/logobadiklat.jpg') }}" class="brand-logo" alt="Logo">
        <div class="lh-sm">
          <div class="fw-bold text-dark">Badiklat Hukum Jateng</div>
          <div class="small text-dark">E-Sertifikat & Webinar</div>
        </div>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
          <li class="nav-item"><a class="nav-link" href="{{ url('/#tentang') }}">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#webinar') }}">Webinar</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#lokasi') }}">Lokasi</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#kontak') }}">Kontak</a></li>

          <li class="nav-item ms-lg-2">
            <button type="button" class="btn btn-admin-icon"
              data-bs-toggle="offcanvas" data-bs-target="#adminPanel" title="Admin">
              <span style="font-size:10px;">&#9776;</span>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- SEMUA HALAMAN MASUK KE SINI --}}
  @yield('content')

  <!-- OFFCANVAS ADMIN -->
  <div class="offcanvas offcanvas-start offcanvas-admin" tabindex="-1" id="adminPanel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title fw-bold">Panel Admin</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
      <div class="card card-shadow rounded-16 border-0" style="background:rgba(255,255,255,.75);">
        <div class="card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <img src="{{ asset('images/logobadiklat.jpg') }}" style="width:34px;height:34px;" alt="Logo">
            <div>
              <div class="fw-semibold">Badiklat Hukum Jateng</div>
              <div class="small text-muted">Khusus Petugas/Admin</div>
            </div>
          </div>

          <a href="/admin/login" class="btn btn-brand rounded-16 w-100">Login</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- tambahan js per halaman --}}
  @stack('scripts')
</body>
</html>
