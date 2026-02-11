@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
  :root{
    --red-900:#6f0000;
    --red-850:#7a0000;
    --red-800:#9b0000;
    --red-700:#b10000;
    --red-600:#d11a1a;

    --rose-50:#fff5f5;
    --rose-100:#ffe9ea;

    --ink:#1b1b1b;
    --muted:#6b7280;

    --card-radius:28px;
  }

  /* ✅ BACKGROUND page: ga kosong, ada motif + glow */
  body{
    margin:0;
    background:
      radial-gradient(900px 520px at 25% 25%, rgba(155,0,0,.12), transparent 60%),
      radial-gradient(850px 520px at 80% 70%, rgba(155,0,0,.10), transparent 55%),
      linear-gradient(180deg, #ffffff 0%, #ffffff 35%, #f6f7f9 100%);
  }

  /* ====== PAGE WRAP ====== */
  .login-stage{
    min-height: calc(100vh - 60px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding: 28px 16px;
    position:relative;
  }

  /* ✅ motif topographic halus (biar gak kosong) */
  .login-stage::before{
    content:"";
    position:absolute;
    inset:0;
    pointer-events:none;
    opacity:.55;
    background-image:
      radial-gradient(rgba(155,0,0,.08) 1px, transparent 1px),
      radial-gradient(rgba(155,0,0,.06) 1px, transparent 1px),
      repeating-linear-gradient(135deg, rgba(155,0,0,.04) 0 1px, transparent 1px 10px);
    background-size: 42px 42px, 64px 64px, 18px 18px;
    background-position: 0 0, 18px 18px, 0 0;
    mask-image: radial-gradient(circle at 50% 35%, #000 0 55%, transparent 72%);
  }

  /* ====== PHONE CANVAS ====== */
  .phone{
    width: min(420px, 100%);
    border-radius: 34px;
    overflow:hidden;
    background: #fff;
    position:relative;

    /* ✅ lebih jelas: ring + shadow */
    box-shadow:
      0 30px 85px rgba(0,0,0,.22),
      0 0 0 1px rgba(0,0,0,.06),
      0 0 0 10px rgba(155,0,0,.04);
  }

  /* ✅ glow halus belakang phone */
  .phone::before{
    content:"";
    position:absolute;
    inset:-60px;
    background:
      radial-gradient(420px 260px at 30% 15%, rgba(155,0,0,.25), transparent 60%),
      radial-gradient(420px 260px at 80% 60%, rgba(155,0,0,.18), transparent 60%);
    filter: blur(20px);
    opacity:.55;
    z-index:0;
    pointer-events:none;
  }

  /* ====== TOP HERO ====== */
  .hero{
    position:relative;
    padding: 32px 24px 90px;
    color:#fff;
    background:
      radial-gradient(1200px 400px at 50% -40%, rgba(255,255,255,.18), transparent 60%),
      linear-gradient(135deg, var(--red-850), var(--red-800));
    overflow:hidden;
    z-index:1;
  }

  .hero::before{
    content:"";
    position:absolute;
    inset:0;
    background-image:
      radial-gradient(rgba(255,255,255,.13) 1px, transparent 1px),
      radial-gradient(rgba(255,255,255,.10) 1px, transparent 1px);
    background-size: 46px 46px, 74px 74px;
    background-position: 0 0, 22px 22px;
    opacity:.20;
    pointer-events:none;
  }

  .blob{
    position:absolute;
    border-radius: 999px;
    opacity:.85;
    mix-blend-mode: screen;
  }
  .blob.b1{ width:220px;height:220px;background:rgba(255,255,255,.14);top:-120px;left:-70px; }
  .blob.b2{ width:260px;height:260px;background:rgba(255,255,255,.10);top:-110px;right:-120px; }
  .blob.b3{ width:180px;height:180px;background:rgba(255,255,255,.08);bottom:-120px;left:90px; }

  .hero h1{
    position:relative;
    font-weight: 900;
    margin:0 0 6px 0;
    letter-spacing:.2px;
    font-size: 34px;
    z-index:2;
  }
  .hero p{
    position:relative;
    margin:0;
    opacity:.95;
    z-index:2;
    font-weight: 500;
  }

  /* ====== CARD WRAP ====== */
  .card-wrap{
    position:relative;
    margin-top: -64px;
    padding: 0 16px 18px;
    z-index:2;
  }

  /* ✅ CARD lebih jelas: border + shadow + ring */
  .cardx{
    border-radius: var(--card-radius);
    border: 1px solid rgba(155,0,0,.10);
    background:
      linear-gradient(180deg, rgba(255,245,245,.65), rgba(255,255,255,1) 42%);
    box-shadow:
      0 28px 75px rgba(122,0,0,.20),
      0 0 0 6px rgba(155,0,0,.04);
    overflow:hidden;
    position:relative;
  }

  /* ✅ subtle highlight di card */
  .cardx::before{
    content:"";
    position:absolute;
    inset:0;
    background:
      radial-gradient(240px 160px at 22% 15%, rgba(155,0,0,.10), transparent 60%),
      radial-gradient(260px 180px at 85% 35%, rgba(155,0,0,.06), transparent 60%);
    pointer-events:none;
    opacity:.9;
  }

  .cardx .card-body{ padding: 18px 18px 20px; position:relative; }

  .card-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 12px;
    padding: 16px 18px 0;
    position:relative;
  }

  .card-head h2{
    margin:0;
    font-weight: 900;
    color: var(--ink);
    font-size: 22px;
  }

  .badge-soft{
    background: rgba(155,0,0,.10);
    color: var(--red-800);
    font-weight: 900;
    border: 1px solid rgba(155,0,0,.16);
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
  }

  /* ====== ANIMATION PANEL ====== */
  .anim-panel{
    margin: 12px 0 14px;
    border-radius: 18px;
    background: linear-gradient(180deg, rgba(155,0,0,.09), rgba(155,0,0,.03));
    border: 1px solid rgba(155,0,0,.14);
    overflow:hidden;
    position:relative;
    box-shadow: 0 14px 30px rgba(155,0,0,.10);
  }
  .anim-panel .caption{
    position:absolute;
    left: 14px;
    bottom: 12px;
    font-size: 12px;
    color: rgba(27,27,27,.72);
    font-weight: 800;
    background: rgba(255,255,255,.78);
    border: 1px solid rgba(155,0,0,.12);
    padding: 6px 10px;
    border-radius: 999px;
    backdrop-filter: blur(6px);
  }
  .anim-panel svg{ display:block; width:100%; height: 160px; }

  /* ====== INPUTS ====== */
  .form-label{
    font-weight: 900;
    font-size: 12px;
    color: rgba(27,27,27,.82);
    margin-bottom: 6px;
  }

  .inputx{
    border-radius: 14px;
    border: 1px solid rgba(0,0,0,.08);
    padding: 12px 14px;
    background: #fff;
    outline: none;
    width:100%;
    box-shadow: 0 10px 22px rgba(0,0,0,.03);
  }
  .inputx:focus{
    border-color: rgba(155,0,0,.60);
    box-shadow: 0 0 0 4px rgba(155,0,0,.12);
  }

  /* ====== BUTTON ====== */
  .btn-red{
    width:100%;
    margin-top: 30px;
    border:0;
    border-radius: 14px;
    padding: 12px 14px;
    color:#fff;
    font-weight: 900;
    background: linear-gradient(135deg, var(--red-850), var(--red-700));
    box-shadow: 0 16px 34px rgba(155,0,0,.26);
    transition: transform .12s ease, filter .12s ease;
  }
  .btn-red:hover{ filter: brightness(1.03); }
  .btn-red:active{ transform: translateY(1px); }

  /* ====== SOCIAL ====== */
  .divider{
    display:flex;
    align-items:center;
    gap: 10px;
    margin: 16px 0 12px;
    color: rgba(0,0,0,.35);
    font-weight: 900;
    font-size: 12px;
    position:relative;
  }
  .divider::before, .divider::after{
    content:"";
    height:1px;
    flex:1;
    background: rgba(0,0,0,.10);
  }

  .social{
    display:flex;
    gap: 10px;
    justify-content:center;
  }
  .social button{
    border: 1px solid rgba(0,0,0,.08);
    background: #fff;
    border-radius: 14px;
    width: 54px;
    height: 44px;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    transition: .15s;
    box-shadow: 0 10px 18px rgba(0,0,0,.04);
  }
  .social button:hover{
    border-color: rgba(155,0,0,.25);
    box-shadow: 0 14px 24px rgba(155,0,0,.12);
    transform: translateY(-1px);
  }

  /* ✅ footer dihapus kalau kamu sudah hapus register */
  .foot{
    text-align:center;
    font-size: 12px;
    color: rgba(0,0,0,.55);
    padding: 10px 18px 18px;
  }
  .foot a{
    color: var(--red-800);
    font-weight: 900;
    text-decoration:none;
  }

  /* ====== SVG ANIMATION ====== */
  @keyframes blink { 0%,20%,100%{opacity:.25} 10%{opacity:1} }
  .win{ animation: blink 2.2s infinite; }
  .win.w2{ animation-delay:.2s; }
  .win.w3{ animation-delay:.45s; }
  .win.w4{ animation-delay:.7s; }

  @keyframes point {
    0%,100%{ transform: rotate(-10deg) translate(0,0); }
    50%{ transform: rotate(8deg) translate(2px,-1px); }
  }
  .arm{ transform-origin: 260px 78px; animation: point 1.8s ease-in-out infinite; }

  @keyframes floaty { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-4px)} }
  .floaty{ animation: floaty 2.6s ease-in-out infinite; }
</style>


<div class="login-stage">
  <div class="phone">

    {{-- HERO --}}
    <div class="hero">
      <div class="blob b1"></div>
      <div class="blob b2"></div>
      <div class="blob b3"></div>

      <h1>Portal Administrasi</h1>
      <p>Silakan masuk untuk mengakses sistem</p>
    </div>

    {{-- CARD --}}
    <div class="card-wrap">
      <div class="card cardx">
        <div class="card-head">
          <h2>Login</h2>
          <span class="badge-soft">E-Sertifikat</span>
        </div>

        <div class="card-body">

          {{-- ANIMASI (GEDUNG + ORANG PRESENTASI) --}}
          <div class="anim-panel">
            <svg viewBox="0 0 360 180" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <!-- soft background -->
              <defs>
                <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0" stop-color="#ffffff" stop-opacity=".9"/>
                  <stop offset="1" stop-color="#ffd9dc" stop-opacity=".35"/>
                </linearGradient>
              </defs>
              <rect x="0" y="0" width="360" height="180" fill="url(#g)"/>

              <!-- chart board -->
              <g class="floaty">
                <rect x="190" y="30" rx="14" ry="14" width="150" height="92" fill="#fff" stroke="rgba(155,0,0,.18)"/>
                <rect x="208" y="50" width="22" height="50" rx="8" fill="rgba(155,0,0,.25)"/>
                <rect x="238" y="62" width="22" height="38" rx="8" fill="rgba(155,0,0,.45)"/>
                <rect x="268" y="44" width="22" height="56" rx="8" fill="rgba(155,0,0,.70)"/>
                <rect x="298" y="70" width="22" height="30" rx="8" fill="rgba(155,0,0,.35)"/>
              </g>

              <!-- buildings -->
              <g>
                <rect x="22" y="58" width="88" height="96" rx="14" fill="rgba(155,0,0,.14)" stroke="rgba(155,0,0,.18)"/>
                <rect x="120" y="42" width="62" height="112" rx="14" fill="rgba(155,0,0,.10)" stroke="rgba(155,0,0,.16)"/>
                <!-- windows -->
                <g fill="rgba(155,0,0,.60)">
                  <rect class="win w1" x="40" y="78" width="16" height="14" rx="4"/>
                  <rect class="win w2" x="66" y="78" width="16" height="14" rx="4"/>
                  <rect class="win w3" x="40" y="102" width="16" height="14" rx="4"/>
                  <rect class="win w4" x="66" y="102" width="16" height="14" rx="4"/>

                  <rect class="win w2" x="136" y="64" width="14" height="12" rx="4" opacity=".7"/>
                  <rect class="win w3" x="156" y="64" width="14" height="12" rx="4" opacity=".55"/>
                  <rect class="win w4" x="136" y="84" width="14" height="12" rx="4" opacity=".45"/>
                  <rect class="win w1" x="156" y="84" width="14" height="12" rx="4" opacity=".7"/>
                </g>
              </g>

              <!-- presenter -->
              <g>
                <!-- body -->
                <circle cx="160" cy="132" r="16" fill="rgba(155,0,0,.85)"/>
                <rect x="146" y="148" width="28" height="24" rx="12" fill="rgba(155,0,0,.75)"/>
                <!-- arm pointing -->
                <g class="arm">
                  <rect x="170" y="142" width="44" height="10" rx="5" fill="rgba(155,0,0,.65)"/>
                  <circle cx="215" cy="147" r="6" fill="rgba(155,0,0,.85)"/>
                </g>
                <!-- pointer dot -->
                <circle cx="206" cy="68" r="5" fill="rgba(155,0,0,.85)"/>
              </g>

              <!-- ground -->
              <path d="M0 156 C60 138 120 168 180 152 C240 136 300 166 360 148 L360 180 L0 180 Z"
                    fill="rgba(155,0,0,.08)"/>
            </svg>

            <div class="caption">Presentasi berjalan…</div>
          </div>

          {{-- FORM --}}
          <form method="POST" action="{{ url('/admin/login') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label">Username</label>
              <input class="inputx" type="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="mb-2">
              <label class="form-label">Password</label>
              <input class="inputx" type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-red">Login</button>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection