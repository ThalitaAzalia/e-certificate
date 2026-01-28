<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'E-Sertifikat & Webinar')</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --brand-primary: #9b0000;
      --brand-secondary: #c62828;
      --brand-accent: #ef5350;
      --brand-light: #ffebee;
      --brand-dark: #7b0000;
      
      --text-primary: #1a1a1a;
      --text-secondary: #4a4a4a;
      --text-light: #ffffff;
      
      --bg-light: #fefefe;
      --bg-soft: rgba(255, 255, 255, 0.85);
      
      --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.05);
      --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.08);
      --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.12);
      --shadow-red: 0 10px 30px rgba(155, 0, 0, 0.15);
      
      --radius-sm: 8px;
      --radius-md: 16px;
      --radius-lg: 24px;
      --radius-xl: 32px;
      
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
      color: var(--text-primary);
      background: var(--bg-light);
      overflow-x: hidden;
      line-height: 1.6;
    }

    /* Elegant background with subtle red texture */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 10% 20%, rgba(155, 0, 0, 0.03) 0%, transparent 40%),
        radial-gradient(circle at 90% 80%, rgba(155, 0, 0, 0.02) 0%, transparent 40%),
        linear-gradient(135deg, #ffffff 0%, #fff5f5 100%);
      z-index: -2;
      pointer-events: none;
    }

    /* Subtle grid pattern */
    body::after {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: 
        linear-gradient(rgba(155, 0, 0, 0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(155, 0, 0, 0.02) 1px, transparent 1px);
      background-size: 40px 40px;
      z-index: -1;
      pointer-events: none;
      opacity: 0.5;
    }

    /* Elegant scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background: var(--bg-light);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--brand-primary);
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--brand-dark);
    }

    /* NAVBAR */
    .navbar{
      background: rgba(255,255,255,0.75) !important;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-bottom:1px solid rgba(185,28,28,.18);
      padding: .25rem 0;
      box-shadow: none;
    }

    .navbar.scrolled{
      box-shadow: 0 10px 22px rgba(0,0,0,.08);
    }

    .brand-logo{
      width:35px;
      height:35px;
      object-fit:contain;
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

    /* tombol admin icon */
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
      color: #b91c1c;
    }
    .btn-admin-icon:hover{
      background: rgba(255,255,255,.65);
    }

    /* offcanvas admin */
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


    /* Buttons */
    .btn-brand {
      background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
      color: white;
      border: none;
      padding: 0.75rem 1.75rem;
      font-weight: 600;
      border-radius: var(--radius-md);
      transition: var(--transition);
      box-shadow: var(--shadow-red);
      position: relative;
      overflow: hidden;
    }

    .btn-brand::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.7s;
    }

    .btn-brand:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 35px rgba(155, 0, 0, 0.25);
      color: white;
    }

    .btn-brand:hover::before {
      left: 100%;
    }

    .btn-outline-brand {
      background: transparent;
      color: var(--brand-primary);
      border: 2px solid var(--brand-primary);
      padding: 0.75rem 1.75rem;
      font-weight: 600;
      border-radius: var(--radius-md);
      transition: var(--transition);
    }

    .btn-outline-brand:hover {
      background: var(--brand-primary);
      color: white;
      transform: translateY(-2px);
      box-shadow: var(--shadow-red);
    }

    /* Cards */
    .card-elegant{
      background: rgba(255,255,255,0.98);
      border: 1px solid rgba(17, 24, 39, 0.10);
      border-radius: 22px;
      overflow: hidden;

      /* shadow elegan (soft + depth) */
      box-shadow:
        0 20px 55px rgba(17, 24, 39, 0.12),
        0 8px 22px rgba(17, 24, 39, 0.08);

      transition: transform .22s ease, box-shadow .22s ease;
      position: relative;
    }

    /* garis merah tipis di atas (aksen premium) */
    .card-elegant::before{
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 5px;
      background: linear-gradient(90deg, var(--brand-primary), var(--brand-secondary));
    }

    /* hover halus */
    .card-elegant:hover{
      transform: translateY(-6px);
      box-shadow:
        0 30px 75px rgba(17, 24, 39, 0.16),
        0 12px 30px rgba(17, 24, 39, 0.10);
    }

    /* isi card lebih nyaman */
    .card-elegant .card-body{
      padding: 30px;
    }

    /* judul lebih elegan */
    .card-elegant .card-title,
    .card-elegant h1,
    .card-elegant h2,
    .card-elegant h3,
    .card-elegant h4,
    .card-elegant h5{
      font-weight: 800;
      color: var(--text-primary);
      letter-spacing: .2px;
    }

    /* teks lebih soft tapi tetap jelas */
    .card-elegant p,
    .card-elegant .card-text{
      color: var(--text-secondary);
    }

    /* divider dalam card */
    .card-elegant hr{
      border: none;
      height: 1px;
      background: rgba(17, 24, 39, 0.10);
      margin: 18px 0;
    }


    /* Sections */
    .section-padding {
      padding: 5rem 0;
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-bottom: 1rem;
      position: relative;
      display: inline-block;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, var(--brand-primary), var(--brand-accent));
      border-radius: 2px;
    }

    .section-subtitle {
      font-size: 1.1rem;
      color: var(--text-secondary);
      max-width: 700px;
      margin: 0 auto 3rem;
    }

    /* Footer */
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

    /* Animations */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }

    .float-animation {
      animation: float 5s ease-in-out infinite;
    }

    .pulse-animation {
      animation: pulse 2s ease-in-out infinite;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .section-padding {
        padding: 3rem 0;
      }
      
      .section-title {
        font-size: 2rem;
      }
      
      .navbar-collapse {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: var(--radius-md);
        padding: 1rem;
        margin-top: 0.5rem;
        box-shadow: var(--shadow-lg);
      }
    }

    /* Admin Panel */
    .offcanvas-admin {
      width: 350px !important;
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(30px);
      -webkit-backdrop-filter: blur(30px);
      border-right: 1px solid rgba(155, 0, 0, 0.1);
    }

    .admin-card {
      background: linear-gradient(135deg, rgba(155, 0, 0, 0.05), rgba(255, 255, 255, 0.9));
      border: 1px solid rgba(155, 0, 0, 0.1);
      border-radius: var(--radius-lg);
      backdrop-filter: blur(10px);
    }

    /* Utility Classes */
    .text-gradient {
      background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .bg-gradient-red {
      background: linear-gradient(135deg, var(--brand-light), rgba(255, 235, 238, 0.5));
    }

    .glass-effect {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    /* PAKSA semua card jadi lebih menonjol (Bootstrap .card + .card-elegant) */
.card,
.card-elegant,
.admin-card{
  background: #ffffff !important;
  border: 1px solid rgba(0,0,0,.14) !important;
  border-radius: 22px !important;

  box-shadow:
    0 18px 45px rgba(0,0,0,.14),
    0 6px 18px rgba(0,0,0,.10) !important;

  overflow: hidden;
}

/* hover lebih elegan */
.card:hover,
.card-elegant:hover,
.admin-card:hover{
  transform: translateY(-4px);
  transition: .2s ease;
  box-shadow:
    0 28px 65px rgba(0,0,0,.18),
    0 10px 26px rgba(0,0,0,.12) !important;
}

/* MODEL CARD CLEAN (nggak aneh, lebih elegan & jelas) */
.card,
.card-elegant,
.admin-card{
  background: #ffffff !important;
  border: 1px solid rgba(15, 23, 42, 0.12) !important; /* border soft tapi jelas */
  border-radius: 18px !important;

  /* shadow lembut, tidak lebay */
  box-shadow:
    0 12px 28px rgba(15, 23, 42, 0.10),
    0 3px 10px rgba(15, 23, 42, 0.06) !important;

  overflow: hidden;
  transform: none;
}

/* hover halus */
.card:hover,
.card-elegant:hover,
.admin-card:hover{
  box-shadow:
    0 18px 42px rgba(15, 23, 42, 0.14),
    0 6px 16px rgba(15, 23, 42, 0.08) !important;
  transform: translateY(-2px);
  transition: transform .18s ease, box-shadow .18s ease;
}

/* padding biar isi card lebih lega (tanpa ganggu layout) */
.card .card-body,
.card-elegant .card-body{
  padding: 22px;
}

/* teks dalam card biar lebih rapi */
.card .card-title,
.card-elegant .card-title{
  font-weight: 800;
  color: var(--text-primary);
}

.card p,
.card small,
.card .text-muted{
  color: var(--text-secondary) !important;
}
/* ✅ ANIMASI NGAMBANG KHUSUS LANDING PAGE SAJA */
.landing-page .card,
.landing-page .card-elegant{
  animation: floatCard 4s ease-in-out infinite;
  will-change: transform;
}

/* beda-beda timing biar nggak bareng (khusus landing) */
.landing-page .card:nth-child(2),
.landing-page .card-elegant:nth-child(2){
  animation-duration: 4.6s;
}
.landing-page .card:nth-child(3),
.landing-page .card-elegant:nth-child(3){
  animation-duration: 5.2s;
}
.landing-page .card:nth-child(4),
.landing-page .card-elegant:nth-child(4){
  animation-duration: 5.8s;
}


/* hover lebih naik */
.card:hover,
.card-elegant:hover,
.admin-card:hover{
  transform: translateY(-8px) scale(1.01);
  transition: transform .25s ease, box-shadow .25s ease;
}

/* keyframes gerak ngambang */
@keyframes floatCard{
  0%, 100% { transform: translateY(0px); }
  50%      { transform: translateY(-8px); }
}


  </style>

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


  @yield('content')

  <!-- OFFCANVAS ADMIN -->
  <div class="offcanvas offcanvas-start offcanvas-admin" tabindex="-1" id="adminPanel">
    <div class="offcanvas-header border-bottom">
      <div class="d-flex align-items-center gap-3">
        <img src="{{ asset('images/logobadiklat.jpg') }}" style="width:40px;height:40px;" alt="Logo">
        <div>
          <h5 class="offcanvas-title fw-bold mb-0" style="color: var(--brand-primary);">Admin Panel</h5>
          <small class="text-muted">Secure Access Portal</small>
        </div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
      <div class="admin-card p-4 mb-4">
        <div class="text-center mb-3">
          <i class="fas fa-shield-alt fa-3x mb-3" style="color: var(--brand-primary);"></i>
          <h6 class="fw-bold">Secure Admin Access</h6>
          <p class="small text-muted mb-3">Restricted area for authorized personnel only</p>
        </div>
        <a href="/admin/login" class="btn btn-brand w-100">
          <i class="fas fa-sign-in-alt me-2"></i>Login to Dashboard
        </a>
      </div>
      
      <div class="card border-0 bg-light p-3">
        <h6 class="fw-bold mb-3">Quick Links</h6>
        <div class="d-flex flex-column gap-2">
          <a href="#" class="text-decoration-none d-flex align-items-center gap-2 text-dark">
            <i class="fas fa-users" style="color: var(--brand-primary);"></i>
            <span>Participant Management</span>
          </a>
          <a href="#" class="text-decoration-none d-flex align-items-center gap-2 text-dark">
            <i class="fas fa-certificate" style="color: var(--brand-primary);"></i>
            <span>Certificate Generator</span>
          </a>
          <a href="#" class="text-decoration-none d-flex align-items-center gap-2 text-dark">
            <i class="fas fa-chart-bar" style="color: var(--brand-primary);"></i>
            <span>Analytics Dashboard</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 80,
            behavior: 'smooth'
          });
        }
      });
    });

    // Initialize animations
    document.addEventListener('DOMContentLoaded', function() {
      // Add animation classes to elements
      const animateElements = document.querySelectorAll('.animate-on-scroll');
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animated');
          }
        });
      }, { threshold: 0.1 });
      
      animateElements.forEach(element => observer.observe(element));
    });
  </script>
  @stack('scripts')
</body>
</html>