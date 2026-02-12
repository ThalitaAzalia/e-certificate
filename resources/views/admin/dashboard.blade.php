@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 12px 16px;">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 12px 16px;">
    <strong>{{ session('error') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif


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
    background: transparent;
    border: none;
    box-shadow: none;
    color: var(--ink);
    transform: none;
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
  .hello .t{ margin:0; font-weight: 800; color: var(--ink); font-size: 18px; letter-spacing: -0.02em;}
  .hello .s{ margin:2px 0 0; color: var(--muted); font-weight: 500; font-size: 12px; letter-spacing: -0.01em;}

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
    padding: 18px 18px;
    backdrop-filter: blur(10px);
    animation: fadeInUp 0.6s ease-out 0.5s both;
    transition: all 0.3s ease;
  }
  .panel:hover{
    box-shadow: 0 22px 55px rgba(20,24,31,.12);
  }

  /* ACTIVITY PANEL */
  .panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
  }

  .panel-title {
    margin: 0 0 6px;
    font-weight: 1000;
    color: var(--ink);
    font-size: 18px;
    letter-spacing: -0.01em;
  }

  .panel-subtitle {
    color: var(--muted);
    font-size: 13px;
    margin: 0;
    line-height: 1.4;
    font-weight: 600;
  }

  .btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.9);
    border: 1.5px solid rgba(155, 0, 0, 0.15);
    color: var(--red-700);
    font-weight: 900;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(155, 0, 0, 0.08);
  }

  .btn-secondary:hover {
    background: rgba(255, 255, 255, 1);
    border-color: var(--red-700);
    color: var(--red-800);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(155, 0, 0, 0.12);
  }

  /* ACTIVITY CONTAINER */
  .activity-container {
    display: flex;
    flex-direction: column;
    gap: 1px;
    background: rgba(155, 0, 0, 0.04);
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(155, 0, 0, 0.08);
  }

  .activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 24px;
    background: white;
    transition: all 0.25s ease;
    position: relative;
  }

  .activity-item:hover {
    background: rgba(255, 233, 234, 0.15);
    transform: translateX(2px);
  }

  .activity-item:not(:last-child)::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 72px;
    right: 24px;
    height: 1px;
    background: linear-gradient(90deg, rgba(155, 0, 0, 0.08), transparent);
  }

  .activity-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(155, 0, 0, 0.08), rgba(155, 0, 0, 0.03));
    border: 1px solid rgba(155, 0, 0, 0.1);
    color: var(--red-700);
    flex-shrink: 0;
  }

  .activity-content {
    flex: 1;
    min-width: 0;
  }

  .activity-title {
    margin: 0 0 6px;
    font-weight: 900;
    font-size: 14px;
    color: var(--ink);
    letter-spacing: -0.01em;
  }

  .activity-desc {
    margin: 0 0 4px;
    font-weight: 600;
    font-size: 13.5px;
    color: var(--ink);
    line-height: 1.5;
  }

  .activity-desc strong {
    font-weight: 1000;
    color: var(--red-800);
  }

  .activity-meta {
    display: inline-block;
    font-size: 12px;
    color: var(--muted);
    font-weight: 600;
    background: rgba(155, 0, 0, 0.04);
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid rgba(155, 0, 0, 0.08);
  }

  .activity-status {
    flex-shrink: 0;
  }

  .status-badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-weight: 900;
    font-size: 11px;
    letter-spacing: 0.02em;
    text-transform: uppercase;
    border: 1px solid;
  }

  .status-complete {
    background: rgba(155, 0, 0, 0.08);
    color: var(--red-800);
    border-color: rgba(155, 0, 0, 0.15);
  }

  .status-success {
    background: rgba(5, 150, 105, 0.08);
    color: #059669;
    border-color: rgba(5, 150, 105, 0.15);
  }

  .status-ready {
    background: rgba(124, 58, 237, 0.08);
    color: #7c3aed;
    border-color: rgba(124, 58, 237, 0.15);
  }

  .status-active {
    background: rgba(8, 145, 178, 0.08);
    color: #0891b2;
    border-color: rgba(8, 145, 178, 0.15);
  }

  /* RESPONSIVE */
  @media (max-width: 768px) {
    .panel-header {
      flex-direction: column;
      align-items: stretch;
    }
    
    .btn-secondary {
      align-self: flex-start;
    }
    
    .activity-item {
      flex-wrap: wrap;
      padding: 16px;
      gap: 12px;
    }
    
    .activity-item:not(:last-child)::after {
      left: 16px;
      right: 16px;
    }
    
    .activity-status {
      margin-left: auto;
    }
  }

  @media (max-width: 480px) {
    .activity-item {
      flex-direction: column;
      align-items: flex-start;
    }
    
    .activity-status {
      align-self: flex-end;
    }
  }
</style>

{{-- POP UP PANJANG DI ATAS--}}
@if (session('success'))
  <div style="position: fixed; top: 16px; left: 50%; transform: translateX(-50%); z-index: 9999; width: auto; max-width: 510px;">
    <div class="alert alert-success alert-dismissible fade show" role="alert"
         style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,.12);">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
@endif

@if (session('error'))
  <div style="position: fixed; top: 16px; left: 50%; transform: translateX(-50%); z-index: 9999; width: auto; max-width: 510px;"  >
    <div class="alert alert-danger alert-dismissible fade show" role="alert"
         style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,.12);">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
@endif

<div class="dash-wrap">
  <div class="dash-shell">

    {{-- SIDEBAR --}}
    <aside class="side">
      <div class="side-head">
        <div class="brand">
          <img src="{{ asset('images/logobapelkum.jpg') }}" alt="Logo">
          <div>
            <p class="t1">Bapelkum Semarang</p>
            <p class="t2">Admin Panel</p>
          </div>
        </div>
      </div>

      <div class="navx">
      <a href="{{ route('admin.dashboard') }}"
        class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <div class="nav-ico"><span class="ico ico-home"></span></div>
        Dashboard
      </a>

      <a href="{{ route('admin.webinars.index') }}"
        class="{{ request()->is('admin/webinars*') ? 'active' : '' }}">
        <div class="nav-ico"><span class="ico ico-cal"></span></div>
        Manajemen Webinar
      </a>

      <a href="{{ route('admin.form-datadiri') }}"
        class="{{ request()->is('admin/form-datadiri*') ? 'active' : '' }}">
        <div class="nav-ico"><span class="ico ico-file"></span></div>
        Form Data Diri
      </a>

      <a href="{{ route('admin.evaluasi.index') }}"
        class="{{ request()->is('admin/evaluasi*') ? 'active' : '' }}">
        <div class="nav-ico"><span class="ico ico-file"></span></div>
        Form Evaluasi
      </a>

      <a href="{{ route('admin.template-sertifikat.index') }}"
        class="{{ request()->is('admin/template-sertifikat*') ? 'active' : '' }}">
        <div class="nav-ico"><span class="ico ico-badge"></span></div>
        Template Sertifikat
      </a>

      <a href="{{ route('admin.laporan.evaluasi') }}"
        class="{{ request()->is('admin/laporan/evaluasi*') ? 'active' : '' }}">
        <div class="nav-ico"><span class="ico ico-chart"></span></div>
        Laporan Evaluasi
      </a>

      <div class="nav-divider"></div>

      <a href="{{ route('admin.profil') }}"
        class="{{ request()->is('admin/profil*') ? 'active' : '' }}">
        <div class="nav-ico"><span class="ico ico-user"></span></div>
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
          <p class="s">Ringkasan pengelolaan webinar, evaluasi, dan sertifikat digital</p>
        </div>
      </div>

      {{-- STAT --}}
      <div class="grid-3">
        <div class="stat s3">
          <div class="k">Total Peserta</div>
          <div class="v">{{ $totalPeserta }}</div>
          <div class="mini">Semua peserta</div>
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

      {{-- PESERTA PER WEBINAR --}}
      <section class="panel" id="cardPesertaPerWebinar">
        <div class="panel-header">
          <div>
            <h3 class="panel-title">Peserta Per Webinar</h3>
            <p class="panel-subtitle">Jumlah peserta terdaftar di setiap webinar</p>
          </div>
        </div>

        <div class="panel-content">
          @if($webinars->count() > 0)
            <div style="overflow-x: auto;">
              <table class="table-dashboard" style="width: 100%; border-collapse: collapse;">
                <thead>
                  <tr style="border-bottom: 2px solid var(--line); background: rgba(155,0,0,.04);">
                    <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: var(--ink);">No</th>
                    <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: var(--ink);">Webinar</th>
                    <th style="padding: 12px 16px; text-align: center; font-weight: 600; color: var(--ink);">Jumlah Peserta</th>
                    <th style="padding: 12px 16px; text-align: center; font-weight: 600; color: var(--ink);">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($webinars as $index => $webinar)
                    <tr style="border-bottom: 1px solid var(--line);">
                      <td style="padding: 14px 16px; color: var(--muted);">{{ $index + 1 }}</td>
                      <td style="padding: 14px 16px;">
                        <div style="font-weight: 600; color: var(--ink); margin-bottom: 4px;">{{ $webinar->judul }}</div>
                        <div style="font-size: 13px; color: var(--muted);">{{ \Carbon\Carbon::parse($webinar->tanggal)->translatedFormat('d F Y') }}</div>
                      </td>
                      <td style="padding: 14px 16px; text-align: center;">
                        <span style="display: inline-block; background: rgba(155,0,0,.10); color: var(--red-700); padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 14px;">
                          {{ $webinar->pesertas_count }} peserta
                        </span>
                      </td>
                      <td style="padding: 14px 16px; text-align: center;">
                        <button type="button" class="btn-lihat-peserta" data-webinar-id="{{ $webinar->id }}" data-webinar-title="{{ $webinar->judul }}" style="background: none; border: none; color: var(--red-700); cursor: pointer; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 6px; transition: all .2s ease;" onmouseover="this.style.background='rgba(155,0,0,.08)'" onmouseout="this.style.background='none'">
                          Lihat Peserta
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div style="padding: 40px; text-align: center; color: var(--muted);">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 12px; opacity: 0.5;">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="9" y1="9" x2="9" y2="15"></line>
                <line x1="15" y1="9" x2="15" y2="15"></line>
              </svg>
              <div style="font-weight: 500;">Belum ada webinar</div>
              <div style="font-size: 13px;">Mulai buat webinar untuk melihat data peserta</div>
            </div>
          @endif
        </div>
      </section>

      {{-- AKTIVITAS TERBARU --}}
      <section class="panel" id="cardPesertaPerWebinar"></section>
        <div class="panel-header">
          <div>
            <h3 class="panel-title">Aktivitas Terbaru</h3>
            <p class="panel-subtitle">Log aktivitas sistem 7 hari terakhir</p>
          </div>
          <div class="panel-actions">
            <a href="{{ route('admin.webinars.index') }}" class="btn-secondary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
              Kelola Webinar
            </a>
          </div>
        </div>

        <div class="activity-container">
          <div class="activity-item">
            <div class="activity-icon">
              <!-- Users (professional) -->
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
              </svg>
            </div>
            <div class="activity-content">
              <h4 class="activity-title">Pendaftaran Peserta</h4>
              <p class="activity-desc"><strong>{{ $totalPeserta }} peserta</strong> terdaftar di sistem</p>
              <span class="activity-meta">Total keseluruhan data</span>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-icon">
              <!-- Clipboard Check (professional) -->
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                <path d="M9 4h6a2 2 0 0 0-6 0z" />
                <path d="M9 14l2 2 4-4" />
              </svg>
            </div>
            <div class="activity-content">
              <h4 class="activity-title">Pengumpulan Evaluasi</h4>
              <p class="activity-desc"><strong>{{ $totalEvaluasi }} evaluasi</strong> berhasil dikumpulkan</p>
              <span class="activity-meta">Dari seluruh webinar yang telah dilaksanakan</span>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-icon">
              <!-- Award/Badge (professional) -->
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="8" r="6" />
                <path d="M15.5 13.5 18 22l-6-3-6 3 2.5-8.5" />
              </svg>
            </div>
            <div class="activity-content">
              <h4 class="activity-title">Penerbitan Sertifikat</h4>
              <p class="activity-desc"><strong>{{ $totalSertifikat }} sertifikat</strong> siap diunduh peserta</p>
              <span class="activity-meta">Berdasarkan asumsi 1 peserta = 1 sertifikat</span>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-icon">
              <!-- Settings (professional) -->
              <svg width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <path d="M12 1.75 13.4 4.2 16.1 4.9 17.6 2.9 20.1 5.4 18.1 7.1 18.7 9.8 21.25 10.9 21.25 13.1 18.7 14.2 18.1 16.9 
                20.1 18.6 17.6 21.1 16.1 19.1 13.4 19.8 12 22.25 10.6 19.8 7.9 19.1 6.4 21.1 3.9 18.6 5.9 16.9 5.3 14.2 2.75 13.1 
                2.75 10.9 5.3 9.8 5.9 7.1 3.9 5.4 6.4 2.9 7.9 4.9 10.6 4.2Z"/>
                <circle cx="12" cy="12" r="3.5"/>
              </svg>

            </div>
            <div class="activity-content">
              <h4 class="activity-title">Status Sistem</h4>
              <p class="activity-desc">Sistem evaluasi dan template sertifikat aktif</p>
              <span class="activity-meta">Siap digunakan untuk webinar mendatang</span>
            </div>
          </div>
        </div>
      </section>

    </main>
  </div>
</div>

<!-- Hidden CSRF Token for API calls -->
<input type="hidden" id="csrf-token" name="csrf-token" value="{{ csrf_token() }}">

<script>
// ================= CSRF =================
function getCsrfToken() {
  const metaToken = document.querySelector('meta[name="csrf-token"]');
  if (metaToken && metaToken.content) return metaToken.content;

  const hidden = document.querySelector('#csrf-token');
  if (hidden && hidden.value) return hidden.value;

  const inputToken = document.querySelector('input[name="_token"]');
  if (inputToken && inputToken.value) return inputToken.value;

  return null;
}

// ================= NAV ACTIVE (AMAN) =================
(function () {
  const navLinks = document.querySelectorAll('.navx a');
  const currentPath = window.location.pathname;

  navLinks.forEach(link => {
    const href = link.getAttribute('href') || '';
    link.classList.remove('active');

    if (
      (href.includes('/admin/dashboard') && currentPath.includes('/admin/dashboard')) ||
      (href.includes('/admin/webinars') && currentPath.includes('/admin/webinars')) ||
      (href.includes('/admin/form-datadiri') && currentPath.includes('/admin/form-datadiri')) ||
      (href.includes('/admin/evaluasi') && currentPath.includes('/admin/evaluasi')) ||
      (href.includes('/admin/template-sertifikat') && currentPath.includes('/admin/template-sertifikat')) ||
      (href.includes('/admin/laporan/evaluasi') && currentPath.includes('/admin/laporan/evaluasi')) ||
      (href.includes('/admin/profil') && currentPath.includes('/admin/profil'))
    ) {
      link.classList.add('active');
    }
  });
})();

// ================= MODAL CLEANUP =================
function cleanupModalArtifacts() {
  document.querySelectorAll('.modal-backdrop').forEach((el, idx) => {
    if (idx > 0) el.remove();
  });

  const anyModalShown = document.querySelector('.modal.show');
  if (!anyModalShown) {
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('overflow');
    document.body.style.removeProperty('padding-right');
  }
}
document.addEventListener('hidden.bs.modal', cleanupModalArtifacts);

// Tutup modal A -> setelah hidden -> buka modal B
function showModalAfterHiding(parentModalId, nextModalId) {
  const parentEl = document.getElementById(parentModalId);
  const nextEl = document.getElementById(nextModalId);
  if (!parentEl || !nextEl) return;

  const parent = bootstrap.Modal.getOrCreateInstance(parentEl);

  parentEl.addEventListener('hidden.bs.modal', function onHidden() {
    parentEl.removeEventListener('hidden.bs.modal', onHidden);
    cleanupModalArtifacts();
    bootstrap.Modal.getOrCreateInstance(nextEl).show();
  });

  parent.hide();
}

// ================= STATE =================
let currentWebinarId = null;
let currentWebinarTitle = null;

let selectedPesertaId = null;
let selectedPesertaBtn = null;

let selectedWebinarId = null;

// ================= FETCH LIST PESERTA =================
function loadModalPeserta(webinarId) {
  fetch(`/admin/api/webinar/${webinarId}/peserta?_ts=${Date.now()}`, {
    method: 'GET',
    cache: 'no-store',
    headers: {
      'Accept': 'application/json',
      'Cache-Control': 'no-cache',
      'Pragma': 'no-cache',
    }
  })
    .then(res => {
      if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
      return res.json();
    })
    .then(data => {
      const container = document.getElementById('modalPesertaList');

      if (!data.pesertas || data.pesertas.length === 0) {
        container.innerHTML =
          '<div style="text-align:center; padding:20px; color: var(--muted);">Belum ada peserta</div>';
        return;
      }

      let html = `
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr style="background: rgba(155,0,0,.08); border-bottom: 1px solid var(--line);">
              <th style="padding: 10px; text-align:left; font-size:13px; font-weight:600; color: var(--ink);">No</th>
              <th style="padding: 10px; text-align:left; font-size:13px; font-weight:600; color: var(--ink);">Nama Peserta</th>
              <th style="padding: 10px; text-align:left; font-size:13px; font-weight:600; color: var(--ink);">Email</th>
              <th style="padding: 10px; text-align:center; font-size:13px; font-weight:600; color: var(--ink);">Aksi</th>
            </tr>
          </thead>
          <tbody>
      `;

      data.pesertas.forEach((peserta, idx) => {
        html += `
          <tr style="border-bottom: 1px solid var(--line);">
            <td style="padding:10px; font-size:13px; color: var(--muted);">${idx + 1}</td>
            <td style="padding:10px; font-size:13px; color: var(--ink); font-weight:500;">${peserta.nama_peserta || '-'}</td>
            <td style="padding:10px; font-size:13px; color: var(--muted);">${peserta.email || '-'}</td>
            <td style="padding:10px; text-align:center;">
              <button type="button"
                class="btn-hapus-peserta-modal"
                data-peserta-id="${peserta.id}"
                data-peserta-name="${peserta.nama_peserta || ''}"
                style="background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); color:#dc2626; padding:4px 10px; border-radius:4px; font-size:12px; cursor:pointer;">
                🗑️ Hapus
              </button>
            </td>
          </tr>
        `;
      });

      html += `</tbody></table>`;
      container.innerHTML = html;

      // bind tombol hapus 
      container.querySelectorAll('.btn-hapus-peserta-modal').forEach(btn => {
        btn.addEventListener('click', function () {
          selectedPesertaBtn = this; // simpan tombol yang diklik
          showDeletePesertaModal(this.dataset.pesertaId, this.dataset.pesertaName);
        });
      });
    })
    .catch(err => {
      document.getElementById('modalPesertaList').innerHTML =
        `<div style="text-align:center; padding:20px; color:#dc2626;">Gagal memuat data: ${err.message}</div>`;
    });
}

// ================= OPEN MODAL LIST PESERTA =================
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.btn-lihat-peserta').forEach(btn => {
    btn.addEventListener('click', function () {
      currentWebinarId = this.dataset.webinarId;
      currentWebinarTitle = this.dataset.webinarTitle;

      const modalEl = document.getElementById('modalDaftarPeserta');
      modalEl.querySelector('.modal-title').textContent = `Daftar Peserta - ${currentWebinarTitle}`;

      document.getElementById('modalPesertaList').innerHTML =
        '<div style="text-align:center; padding:20px; color: var(--muted);">Memuat data...</div>';

      bootstrap.Modal.getOrCreateInstance(modalEl).show();
      loadModalPeserta(currentWebinarId);
    });
  });

  const modalPeserta = document.getElementById('modalDaftarPeserta');
  if (modalPeserta) {
    const footer = modalPeserta.querySelector('.modal-footer');
    if (footer && !footer.querySelector('.btn-delete-all-from-modal')) {
      const deleteAllBtn = document.createElement('button');
      deleteAllBtn.type = 'button';
      deleteAllBtn.className = 'btn btn-danger btn-delete-all-from-modal';
      deleteAllBtn.innerHTML = '<span style="margin-right:4px;">🗑️</span>Hapus Semua Peserta';
      deleteAllBtn.addEventListener('click', function () {
      // 1) set state hapus semua 
      selectedWebinarId = currentWebinarId;

      const nameEl = document.getElementById('namaWebinarDelete');
      if (nameEl) nameEl.textContent = currentWebinarTitle || '-';

      // 2) tutup modal daftar
      const daftarEl = document.getElementById('modalDaftarPeserta');
      const delAllEl = document.getElementById('modalDeleteAll');
      if (!daftarEl || !delAllEl) return;

      const daftarModal = bootstrap.Modal.getOrCreateInstance(daftarEl);

      // 3) setelah modal daftar benar2 tertutup, baru buka modal delete all
      daftarEl.addEventListener('hidden.bs.modal', function onHidden() {
        daftarEl.removeEventListener('hidden.bs.modal', onHidden);
        bootstrap.Modal.getOrCreateInstance(delAllEl).show();
      });

      daftarModal.hide();
    });


      const closeBtn = footer.querySelector('.btn-secondary');
      if (closeBtn) footer.insertBefore(deleteAllBtn, closeBtn);
      else footer.appendChild(deleteAllBtn);
    }
  }
});

// ================= DELETE 1 PESERTA =================
function showDeletePesertaModal(pesertaId, pesertaName) {
  selectedPesertaId = pesertaId;

  const nameEl = document.getElementById('namaPesertaDelete');
  if (nameEl) nameEl.textContent = pesertaName || '-';

  // tutup daftar -> buka delete
  showModalAfterHiding('modalDaftarPeserta', 'modalDeletePeserta');
}

document.addEventListener('DOMContentLoaded', function () {
  const confirmBtn = document.getElementById('confirmDeletePesertaBtn');
  if (!confirmBtn) return;

  confirmBtn.addEventListener('click', async function () {
    if (!selectedPesertaId) return;

    const token = getCsrfToken();
    if (!token) return alert('CSRF token tidak ditemukan.');

    confirmBtn.disabled = true;
    confirmBtn.textContent = 'Menghapus...';

    try {
      const res = await fetch(`/admin/dashboard/peserta/${selectedPesertaId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
      });

      let payload = {};
      try { payload = await res.json(); } catch {}

      if (!res.ok) {
        const msg = payload.message || `Gagal hapus (HTTP ${res.status})`;
        throw new Error(msg);
      }

      // simpan pesan sukses 
      sessionStorage.setItem('flash_success', payload.message || 'Data peserta berhasil dihapus');

      const delEl = document.getElementById('modalDeletePeserta');
      delEl.addEventListener('hidden.bs.modal', function onHidden() {
        delEl.removeEventListener('hidden.bs.modal', onHidden);
        window.location.reload();
      });

      bootstrap.Modal.getOrCreateInstance(delEl).hide();


    } catch (err) {
      alert(err.message || 'Terjadi kesalahan.');
    } finally {
      confirmBtn.disabled = false;
      confirmBtn.textContent = 'Ya, Hapus';
      selectedPesertaId = null;
      selectedPesertaBtn = null;
    }
  });
});

// ================= DELETE ALL PESERTA =================
document.addEventListener('DOMContentLoaded', function () {
  const confirmBtnAll = document.getElementById('confirmDeleteAllPesertaBtn');
  if (!confirmBtnAll) return;

  confirmBtnAll.addEventListener('click', async function () {
    if (!selectedWebinarId) return;

    const token = getCsrfToken();
    if (!token) return alert('CSRF token tidak ditemukan.');

    confirmBtnAll.disabled = true;
    confirmBtnAll.textContent = 'Menghapus...';

    try {
      const res = await fetch(`/admin/dashboard/webinar/${selectedWebinarId}/peserta`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
      });

      let payload = {};
      try { payload = await res.json(); } catch {}

      if (!res.ok) {
        const msg = payload.message || `Gagal hapus semua (HTTP ${res.status})`;
        throw new Error(msg);
      }

      // simpan pesan sukses 
      sessionStorage.setItem(
        'flash_success',
        payload.message || 'Semua data peserta webinar berhasil dihapus'
      );

      // tutup modal -> setelah hidden -> reload page
      const delAllEl = document.getElementById('modalDeleteAll');
      const modal = bootstrap.Modal.getOrCreateInstance(delAllEl);

      let reloaded = false;
      const doReload = () => {
        if (reloaded) return;
        reloaded = true;
        window.location.reload();
      };

      delAllEl.addEventListener('hidden.bs.modal', function onHidden() {
        delAllEl.removeEventListener('hidden.bs.modal', onHidden);
        doReload();
      });

  
      modal.hide();
      setTimeout(() => {
        if (reloaded) return;

        delAllEl.classList.remove('show');
        delAllEl.style.display = 'none';
        delAllEl.setAttribute('aria-hidden', 'true');

        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');

        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

        doReload();
      }, 700);

    } catch (err) {
      alert(err.message || 'Terjadi kesalahan.');
    } finally {
      confirmBtnAll.disabled = false;
      confirmBtnAll.textContent = 'Ya, Hapus Semua';
      selectedWebinarId = null;
    }
  });
});


</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const msg = sessionStorage.getItem('flash_success');
  if (!msg) return;

  sessionStorage.removeItem('flash_success');

  const wrap = document.createElement('div');
  wrap.style.position = 'fixed';
  wrap.style.top = '20px';
  wrap.style.left = '50%';
  wrap.style.transform = 'translateX(-50%)';
  wrap.style.zIndex = '9999';
  wrap.style.width = 'auto';
  wrap.style.maxWidth = '700px';

  wrap.innerHTML = `
    <div class="alert alert-success alert-dismissible fade show" role="alert"
        style="
          border-radius:12px;
          box-shadow:0 10px 30px rgba(0,0,0,.12);
          margin:0;
          padding:12px 60px 12px 18px;
          position:relative;
        ">
      ${msg}
      <button type="button"
              class="btn-close"
              data-bs-dismiss="alert"
              aria-label="Close"
              style="
                position:absolute;
                right:16px;
                top:50%;
                transform:translateY(-50%);
              ">
      </button>
    </div>
  `;


  document.querySelectorAll('.alert.alert-success').forEach(el => {
    try { bootstrap.Alert.getOrCreateInstance(el).close(); } catch(e) { el.remove(); }
  });

  const existing = document.getElementById('flash_success_toast');
  if (existing) existing.remove();
  wrap.id = 'flash_success_toast';

  document.body.appendChild(wrap);

});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
  // auto close alert session success/error
  setTimeout(() => {
    document.querySelectorAll('.alert').forEach((el) => {
      try {
        bootstrap.Alert.getOrCreateInstance(el).close();
      } catch (e) {
        el.remove();
      }
    });
  }, 3000);
});
</script>


<!-- Modal: Daftar Peserta per Webinar -->
<div class="modal fade" id="modalDaftarPeserta" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Daftar Peserta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="modalPesertaList">
        <div style="text-align: center; padding: 20px; color: var(--muted);">Memuat data...</div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Hapus Peserta Tunggal -->
<div class="modal fade" id="modalDeletePeserta" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger fw-bold">Hapus Peserta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p class="mb-2">Hapus peserta ini? Data evaluasi terkait juga akan dihapus.</p>

        <div class="alert alert-danger mb-0">
          <strong id="namaPesertaDelete">Nama Peserta</strong>
          <div class="small text-muted mt-1">Data yang sudah dihapus tidak dapat dikembalikan.</div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

        <button type="button" id="confirmDeletePesertaBtn" class="btn btn-danger">
          Ya, Hapus
        </button>

      </div>
    </div>
  </div>
</div>

<!-- Modal: Hapus Semua Peserta per Webinar -->
<div class="modal fade" id="modalDeleteAll" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger fw-bold">Hapus Semua Peserta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p class="mb-2">Anda akan menghapus SEMUA peserta pada webinar berikut:</p>

        <div class="alert alert-danger mb-0">
          <strong id="namaWebinarDelete">Judul Webinar</strong>
          <div class="small text-muted mt-1">Tindakan ini akan menghapus semua data peserta dan evaluasi terkait.</div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

        <form id="formDeleteAllPeserta">
          @csrf
          <button type="button" id="confirmDeleteAllPesertaBtn" class="btn btn-danger">
            Ya, Hapus Semua
          </button>
        </form>

      </div>
    </div>
  </div>
</div>

@endsection