@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<style>
  :root{
    --red-950:#4b0000;
    --red-900:#6f0000;
    --red-800:#8a0000;
    --red-700:#9b0000;
    --red-600:#b10000;
    --red-100:#ffe9ea;

    --bg:#faf7f7;
    --card:#ffffff;
    --ink:#14181f;
    --muted:#6b7280;
    --line:rgba(20,24,31,.08);

    --radius:18px;
    --radius-lg:22px;
    --shadow: 0 18px 50px rgba(20,24,31,.10);
  }

  body{
    background: radial-gradient(900px 500px at 80% -10%, rgba(155,0,0,.10), transparent 55%), var(--bg);
    animation: bgFloat 20s ease-in-out infinite;
  }

  @keyframes bgFloat {
    0%, 100% { background-position: 80% -10%; }
    50% { background-position: 20% 10%; }
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes slideInLeft {
    from {
      opacity: 0;
      transform: translateX(-30px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  @keyframes scaleIn {
    from {
      opacity: 0;
      transform: scale(0.9);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  .dash-wrap{ 
    padding: 20px 16px 28px;
    animation: fadeInUp 0.6s ease-out;
  }

  .dash-shell{
    max-width: 1220px;
    margin: 0 auto;
    display:grid;
    grid-template-columns: 270px 1fr;
    gap: 18px;
    align-items:start;
  }

  /* ===================== SIDEBAR ===================== */
  .side{
    background: rgba(255,255,255,.88);
    border: 1px solid rgba(155,0,0,.12);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    overflow:hidden;
    position: sticky;
    top: 14px;
    height: calc(100vh - 120px);
    display:flex;
    flex-direction:column;
    backdrop-filter: blur(10px);
    animation: slideInLeft 0.6s ease-out;
  }

  .side-head{
    padding: 18px 16px 14px;
    background: linear-gradient(135deg, #5a0000, #8f0000);
    color:#fff;
    position:relative;
    overflow:hidden;
  }

  .side-head::before{
    content:"";
    position:absolute;
    width:220px;height:220px;
    border-radius:999px;
    background: rgba(255,255,255,.12);
    top:-140px; right:-100px;
    animation: rotate 15s linear infinite;
  }

  @keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }

  .brand{
    position:relative;
    z-index:2;
    display:flex;
    gap:10px;
    align-items:center;
  }
  .brand img{
    width: 40px; height: 40px;
    border-radius: 14px;
    background:#fff;
    object-fit: contain;
    padding:6px;
    box-shadow: 0 10px 18px rgba(0,0,0,.16);
    transition: transform 0.3s ease;
  }
  .brand img:hover{
    transform: scale(1.05) rotate(5deg);
  }
  .brand .t1{ margin:0; font-weight: 1000; font-size: 13px; line-height:1.1; }
  .brand .t2{ margin:2px 0 0; opacity:.92; font-weight: 800; font-size: 11px; }

  /* NAV */
  .navx{ 
    padding: 12px 12px 8px;
    flex: 1;
    overflow-y: auto;
  }
  .navx a{
    position: relative;
    display:flex;
    align-items:center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 14px;
    text-decoration:none;
    color: var(--ink);
    font-weight: 900;
    font-size: 12px;
    transition: all .3s ease;
    margin-bottom: 4px;
  }
  .navx a:hover{
    background: rgba(155,0,0,.06);
    transform: translateX(4px);
  }

  .navx a.active{
    background: linear-gradient(180deg, rgba(255,233,234,.95), rgba(255,233,234,.70));
    border: 1px solid rgba(155,0,0,.14);
    color: var(--red-700);
    box-shadow: 0 10px 22px rgba(155,0,0,.10);
    transform: translateX(4px);
  }
  .navx a.active::after{
    content:"";
    position:absolute;
    right: 14px;
    top: 50%;
    width: 8px;
    height: 8px;
    margin-top: -4px;
    border-radius: 999px;
    background: var(--red-700);
    box-shadow: 0 0 0 3px rgba(155,0,0,.10);
    animation: pulse 2s ease-in-out infinite;
  }

  @keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.8; }
  }

  .nav-ico{
    width: 36px; height: 36px;
    border-radius: 14px;
    display:flex;
    align-items:center;
    justify-content:center;
    background: rgba(255,233,234,.85);
    border: 1px solid rgba(155,0,0,.12);
    flex: 0 0 36px;
    transition: all 0.3s ease;
  }

  .navx a:hover .nav-ico{
    transform: rotate(5deg) scale(1.05);
  }

  /* ICONS */
  .ico{
    width:18px;
    height:18px;
    display:block;
    position:relative;
    color: var(--red-700);
  }

  .ico-home{
    width:16px;height:10px;
    border:2px solid currentColor;
    border-bottom:0;
    border-radius:4px 4px 0 0;
    margin-top:6px;
  }
  .ico-home::before{
    content:"";
    position:absolute;
    left:50%;
    top:2px;
    width:10px;height:10px;
    border-left:2px solid currentColor;
    border-top:2px solid currentColor;
    transform:translateX(-50%) rotate(45deg);
    border-radius:2px;
  }

  .ico-cal{
    box-sizing:border-box;
    border:2px solid currentColor;
    border-radius:4px;
  }
  .ico-cal::before{
    content:"";
    position:absolute;
    left:0; right:0; top:4px;
    height:2px;
    background: currentColor;
    opacity:.9;
  }
  .ico-cal::after{
    content:"";
    position:absolute;
    left:4px; top:8px;
    width:3px;height:3px;
    background: currentColor;
    border-radius:2px;
    opacity:.55;
    box-shadow: 6px 0 0 currentColor, 0 6px 0 currentColor, 6px 6px 0 currentColor;
  }

  .ico-file{
    box-sizing:border-box;
    border:2px solid currentColor;
    border-radius:4px;
  }
  .ico-file::before{
    content:"";
    position:absolute;
    left:4px; right:4px; top:5px;
    height:2px;
    background: currentColor;
    opacity:.85;
    box-shadow: 0 4px 0 rgba(155,0,0,.55), 0 8px 0 rgba(155,0,0,.35);
  }
  .ico-file::after{
    content:"";
    position:absolute;
    right:2px; top:2px;
    width:6px; height:6px;
    border-top:2px solid currentColor;
    border-right:2px solid currentColor;
    border-radius:0 3px 0 0;
    opacity:.35;
  }

  .ico-check{
    box-sizing:border-box;
    border:2px solid currentColor;
    border-radius:4px;
  }
  .ico-check::before{
    content:"";
    position:absolute;
    left:4px; top:9px;
    width:4px; height:2px;
    border-left:2px solid currentColor;
    border-bottom:2px solid currentColor;
    transform: rotate(-45deg);
  }
  .ico-check::after{
    content:"";
    position:absolute;
    left:7px; top:8px;
    width:7px; height:4px;
    border-right:2px solid currentColor;
    border-bottom:2px solid currentColor;
    transform: rotate(-45deg);
    opacity:.9;
  }

  .ico-badge{
    box-sizing:border-box;
    border:2px solid currentColor;
    border-radius:5px;
  }
  .ico-badge::before{
    content:"";
    position:absolute;
    left:50%; top:5px;
    width:7px;height:7px;
    border-radius:999px;
    border:2px solid currentColor;
    transform:translateX(-50%);
    opacity:.9;
  }
  .ico-badge::after{
    content:"";
    position:absolute;
    left:50%; bottom:-1px;
    width:0;height:0;
    border-left:4px solid transparent;
    border-right:4px solid transparent;
    border-top:6px solid currentColor;
    transform:translateX(-50%);
    opacity:.55;
  }

  .ico-chart{
    box-sizing:border-box;
    border:2px solid currentColor;
    border-radius:4px;
  }
  .ico-chart::before{
    content:"";
    position:absolute;
    left:4px; bottom:4px;
    width:3px; height:6px;
    background: currentColor;
    border-radius:2px;
    opacity:.9;
    box-shadow: 5px -2px 0 currentColor, 10px -4px 0 currentColor;
  }
  .ico-chart::after{
    content:"";
    position:absolute;
    left:4px; bottom:4px;
    width:12px; height:2px;
    background: rgba(155,0,0,.25);
    border-radius:2px;
  }

  .ico-user{
    box-sizing:border-box;
    border:2px solid currentColor;
    border-radius:999px;
  }
  .ico-user::before{
    content:"";
    position:absolute;
    left:50%; top:4px;
    width:6px; height:6px;
    border-radius:999px;
    background: currentColor;
    transform:translateX(-50%);
    opacity:.9;
  }
  .ico-user::after{
    content:"";
    position:absolute;
    left:50%; bottom:2px;
    width:12px; height:7px;
    border:2px solid currentColor;
    border-bottom:0;
    border-radius:10px 10px 6px 6px;
    transform:translateX(-50%);
    opacity:.65;
  }

  .navx a.active .nav-ico{
    background: rgba(255,233,234,1);
    border-color: rgba(155,0,0,.18);
  }

  .nav-divider{
    height: 1px;
    margin: 12px 8px;
    background: rgba(155,0,0,.15);
    border-radius: 999px;
  }

  /* QUICK ACTION */
  .side-foot{
    padding: 10px 12px 14px;
    margin-top: auto;
  }

  .upgrade{
    border-radius: 18px;
    padding: 14px 14px;
    background:
      radial-gradient(520px 220px at 20% 0%, rgba(155,0,0,.18), transparent 60%),
      linear-gradient(180deg, rgba(255,233,234,.85), rgba(255,233,234,.55));
    border: 1px solid rgba(155,0,0,.12);
    box-shadow: 0 14px 28px rgba(20,24,31,.10);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .upgrade:hover{
    transform: translateY(-2px);
    box-shadow: 0 18px 35px rgba(20,24,31,.15);
  }
  .upgrade .h{ font-weight: 1000; color: var(--ink); margin:0 0 6px; font-size: 12px; }
  .upgrade .p{ margin:0 0 12px; color: var(--muted); font-weight: 800; font-size: 11px; line-height:1.35; }

  .btn-red{
    border:0;
    border-radius: 12px;
    padding: 11px 12px;
    font-weight: 1000;
    color:#fff;
    background: linear-gradient(135deg, var(--red-900), var(--red-600));
    box-shadow: 0 14px 30px rgba(155,0,0,.18);
    text-decoration:none;
    display:inline-flex;
    gap: 10px;
    align-items:center;
    justify-content:center;
    width:100%;
    transition: all .3s ease;
    cursor: pointer;
  }
  .btn-red:hover{ 
    filter: brightness(1.08); 
    color:#fff; 
    transform: translateY(-2px);
    box-shadow: 0 18px 38px rgba(155,0,0,.25);
  }

  /* MAIN */
  .main{ 
    display:flex; 
    flex-direction:column; 
    gap: 14px;
  }

  .topbar{
    background: rgba(255,255,255,.85);
    border: 1px solid rgba(155,0,0,.10);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    padding: 16px 16px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 12px;
    backdrop-filter: blur(10px);
    animation: fadeInUp 0.6s ease-out 0.1s both;
  }
  .hello .t{ margin:0; font-weight: 1000; color: var(--ink); font-size: 18px; }
  .hello .s{ margin:2px 0 0; color: var(--muted); font-weight: 800; font-size: 12px; }

  .chip{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding: 9px 12px;
    border-radius: 999px;
    background: rgba(155,0,0,.08);
    border: 1px solid rgba(155,0,0,.12);
    color: var(--red-700);
    font-weight: 1000;
    font-size: 12px;
    white-space:nowrap;
  }
  .dot{ 
    width:8px;
    height:8px;
    border-radius:999px;
    background:var(--red-700);
    animation: pulse 2s ease-in-out infinite;
  }

  .grid-3{
    display:grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
  }

  .stat{
    border-radius: var(--radius-lg);
    padding: 14px 14px 12px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(155,0,0,.10);
    background: #fff;
    position:relative;
    overflow:hidden;
    min-height: 90px;
    transition: all 0.4s ease;
    animation: fadeInUp 0.6s ease-out both;
  }
  .stat:nth-child(1){ animation-delay: 0.2s; }
  .stat:nth-child(2){ animation-delay: 0.3s; }
  .stat:nth-child(3){ animation-delay: 0.4s; }

  .stat:hover{
    transform: translateY(-4px);
    box-shadow: 0 24px 60px rgba(20,24,31,.15);
  }

  .stat::before{
    content:"";
    position:absolute;
    width:200px;height:200px;
    border-radius:999px;
    bottom:-120px; right:-120px;
    opacity:.9;
    transition: all 0.6s ease;
  }
  .stat:hover::before{
    transform: scale(1.2);
    opacity: 1;
  }

  .stat.s1{ background: linear-gradient(135deg, rgba(155,0,0,.10), #fff); }
  .stat.s1::before{ background: rgba(155,0,0,.12); }
  .stat.s2{ background: linear-gradient(135deg, rgba(177,0,0,.10), #fff); }
  .stat.s2::before{ background: rgba(177,0,0,.12); }
  .stat.s3{ background: linear-gradient(135deg, rgba(111,0,0,.10), #fff); }
  .stat.s3::before{ background: rgba(111,0,0,.12); }

  .stat .k{ margin:0 0 6px; color: var(--muted); font-weight: 900; font-size: 12px; position:relative; z-index:1; }
  .stat .v{ margin:0; color: var(--ink); font-weight: 1000; font-size: 26px; position:relative; z-index:1; }
  .stat .mini{
    margin-top: 8px;
    display:inline-flex;
    gap:6px;
    align-items:center;
    padding: 6px 10px;
    border-radius: 999px;
    background: rgba(155,0,0,.08);
    border: 1px solid rgba(155,0,0,.12);
    color: var(--red-700);
    font-weight: 1000;
    font-size: 11px;
    position:relative; z-index:1;
  }

  .panel{
    background: rgba(255,255,255,.88);
    border: 1px solid rgba(155,0,0,.10);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    padding: 14px 14px;
    backdrop-filter: blur(10px);
    animation: fadeInUp 0.6s ease-out 0.5s both;
    transition: all 0.3s ease;
  }
  .panel:hover{
    box-shadow: 0 22px 55px rgba(20,24,31,.12);
  }

  @media (max-width: 1140px){
    .dash-shell{ grid-template-columns: 270px 1fr; }
  }
  @media (max-width: 860px){
    .dash-shell{ grid-template-columns: 1fr; }
    .side{ position:relative; height:auto; }
    .grid-3{ grid-template-columns: 1fr; }
  }
</style>

<div class="dash-wrap">
  <div class="dash-shell">

    {{-- SIDEBAR --}}
    <aside class="side">
      <div class="side-head">
        <div class="brand">
          <img src="{{ asset('images/logobadiklat.jpg') }}" alt="Logo">
          <div>
            <p class="t1">Badiklat Hukum Jateng</p>
            <p class="t2">Admin Panel</p>
          </div>
        </div>
      </div>

      <div class="navx">
        <a class="active" href="{{ route('admin.dashboard') }}">
          <div class="nav-ico"><span class="ico ico-home"></span></div>
          Overview
        </a>
        <a href="{{ route('admin.webinars.index') }}">
          <div class="nav-ico"><span class="ico ico-cal"></span></div>
          Manajemen Webinar
        </a>
        <a href="{{ route('admin.form-datadiri') }}">
          <div class="nav-ico"><span class="ico ico-file"></span></div>
          Form Data Diri
        </a>
        <a href="{{ route('admin.evaluasi.index') }}">
          <div class="nav-ico"><span class="ico ico-file"></span></div>
          Form Evaluasi
        </a>
        <a href="{{ route('admin.template-sertifikat.index') }}">
         <div class="nav-ico"><span class="ico ico-badge"></span></div>
          Template Sertifikat
        </a>
        <a href="{{ route('admin.laporan.evaluasi') }}">
          <div class="nav-ico">
            <span class="ico ico-chart"></span>
          </div>
          Laporan Evaluasi
        </a>
        <div class="nav-divider"></div>
        <a href="{{ route('admin.profil') }}">
        <div class="nav-ico">
          <span class="ico ico-user"></span>
        </div>
          Profil Admin
        </a>
      </div>

      <div class="side-foot">
        <div class="upgrade">
          <div class="h">Quick Action</div>
          <div class="p">
            Kelola webinar, evaluasi, dan sertifikat langsung dari dashboard.
          </div>

          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn-red" type="submit">
              <span class="btn-ico"></span>
              Logout
            </button>
          </form>
        </div>
      </div>
    </aside>

    {{-- MAIN --}}
    <main class="main">

      <div class="topbar">
        <div class="hello">
          <p class="t">Dashboard</p>
          <p class="s">Ringkasan sistem webinar, evaluasi, dan e-sertifikat</p>
        </div>

        <div class="chip">
          <span class="dot"></span> Status: Live Database
        </div>
      </div>

      {{-- STAT --}}
      <div class="grid-3">
        <div class="stat s1">
          <div class="k">Jumlah Peserta</div>
          <div class="v">{{ $totalPeserta }}</div>
          <div class="mini">Data dari tabel pesertas</div>
        </div>

        <div class="stat s2">
          <div class="k">Evaluasi Masuk</div>
          <div class="v">{{ $totalEvaluasi }}</div>
          <div class="mini">Jawaban evaluasi</div>
        </div>

        <div class="stat s3">
          <div class="k">Sertifikat Terbit</div>
          <div class="v">{{ $totalSertifikat }}</div>
          <div class="mini">Asumsi 1 peserta</div>
        </div>
      </div>

      {{-- NOTE --}}
      <section class="panel">
        <h3 style="margin:0 0 8px; font-weight:1000; color:var(--ink); font-size:14px;">Catatan</h3>
        <p style="color:#6b7280;font-size:13px; margin:0; line-height:1.6;">
          Dashboard ini sudah terhubung langsung ke database.
          Grafik & laporan lanjutan akan dikembangkan bertahap.
        </p>
      </section>

    </main>
  </div>
</div>

@endsection