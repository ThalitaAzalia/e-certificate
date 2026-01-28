@extends('layouts.app')

@section('title', 'Form Absensi Webinar')

@push('head')
<style>
  :root{
    --red-900:#6f0000;
    --red-850:#7a0000;
    --red-800:#9b0000;
    --red-700:#b10000;

    --ink:#1b1b1b;
    --muted:#6b7280;

    --card-radius:28px;
  }

  /* BACKGROUND */
  body{
    margin:0;
    background: #ffe9ee;
    min-height: 100vh;
  }

  body::before{
    content:"";
    position:fixed;
    inset:0;
    pointer-events:none;
    opacity:.55;
    background-image:
      radial-gradient(rgba(155,0,0,.08) 1px, transparent 1px),
      radial-gradient(rgba(155,0,0,.06) 1px, transparent 1px),
      repeating-linear-gradient(135deg, rgba(155,0,0,.04) 0 1px, transparent 1px 10px);
    background-size: 42px 42px, 64px 64px, 18px 18px;
    background-position: 0 0, 18px 18px, 0 0;
    z-index: -1;
  }

  /* ====== PAGE WRAP ====== */
  .absensi-stage{
    min-height: calc(100vh - 60px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding: 28px 16px;
    position:relative;
  }

  /* ====== PHONE CANVAS ====== */
  .phone{
    width: min(420px, 100%);
    border-radius: 34px;
    overflow:hidden;
    background: #fff;
    position:relative;
    box-shadow:
      0 30px 85px rgba(0,0,0,.22),
      0 0 0 1px rgba(0,0,0,.06),
      0 0 0 10px rgba(155,0,0,.04);
  }

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
    font-size: 16px;
  }

  /* ====== CARD WRAP ====== */
  .card-wrap{
    position:relative;
    margin-top: -64px;
    padding: 0 16px 18px;
    z-index:2;
  }

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

  .cardx .card-body{
    padding: 18px 18px 20px;
    position:relative;
  }

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
    white-space: nowrap;
  }

  /* ====== ANIM PANEL ====== */
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
  .anim-panel svg{
    display:block;
    width:100%;
    height: 160px;
  }

  /* ====== FORM ====== */
  .form-group { margin-bottom: 18px; position: relative; }

  .form-label{
    display: block;
    font-weight: 900;
    font-size: 13px;
    color: rgba(27,27,27,.85);
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }

  .input-wrapper{ position: relative; }

  .inputx{
    border-radius: 14px;
    border: 1.5px solid rgba(0,0,0,.12);
    padding: 14px 16px;
    background: #fff;
    outline: none;
    width:100%;
    box-shadow: 0 8px 20px rgba(0,0,0,.04);
    font-size: 15px;
    font-weight: 500;
    color: var(--ink);
    transition: all 0.2s ease;
  }
  .inputx::placeholder{
    color: rgba(107, 114, 128, 0.6);
    font-weight: 400;
  }
  .inputx:focus{
    border-color: var(--red-800);
    box-shadow:
      0 0 0 4px rgba(155,0,0,.15),
      0 12px 28px rgba(155,0,0,.12);
    transform: translateY(-1px);
  }

  /* invalid highlight (tanpa JS) */
  .inputx:invalid:focus{
    border-color: #ef4444;
    box-shadow: 0 0 0 4px rgba(239,68,68,.14);
  }

  /* Icon inside input */
  .input-icon{
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    color: rgba(155,0,0,.7);
    pointer-events: none;
  }
  .inputx.has-icon{ padding-left: 46px; }

  textarea.inputx{
    min-height: 110px;
    resize: vertical;
    padding-top: 12px;
    padding-bottom: 12px;
  }
  textarea.inputx.has-icon{
    padding-left: 46px;
  }

  /* ====== BUTTON ====== */
  .btn-red{
    width:100%;
    margin-top: 18px;
    border:0;
    border-radius: 14px;
    padding: 16px 14px;
    color:#fff;
    font-weight: 900;
    font-size: 15px;
    letter-spacing: 0.3px;
    background: linear-gradient(135deg, var(--red-850), var(--red-700));
    box-shadow: 0 16px 34px rgba(155,0,0,.26);
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .btn-red:hover{
    filter: brightness(1.08);
    box-shadow: 0 20px 40px rgba(155,0,0,.32);
    transform: translateY(-2px);
    color:#fff;
  }
  .btn-red:active{ transform: translateY(0); }

  /* ====== ALERTS ====== */
  .alertx{
    border-radius: 14px;
    padding: 14px 16px;
    margin-bottom: 16px;
    border: 1px solid;
    font-weight: 600;
    font-size: 14px;
  }
  .alertx.success{
    background: rgba(21, 128, 61, 0.1);
    border-color: rgba(21, 128, 61, 0.3);
    color: #166534;
  }
  .alertx.error{
    background: rgba(239, 68, 68, 0.1);
    border-color: rgba(239, 68, 68, 0.3);
    color: #dc2626;
  }
  .alertx ul{ margin: 8px 0 0 0; padding-left: 20px; }
  .alertx li{ margin-bottom: 4px; }

  /* field error text */
  .err{
    display:block;
    margin-top: 8px;
    font-size: 12px;
    font-weight: 700;
    color: #dc2626;
  }

  /* ====== INFO PILLS ====== */
  .info-pills{
    display:flex;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 16px;
  }
  .pill{
    background: rgba(255,255,255,.9);
    border: 1px solid rgba(155,0,0,.14);
    border-radius: 999px;
    padding: 8px 12px;
    font-size: 11px;
    font-weight: 700;
    color: rgba(27,27,27,.8);
    display: flex;
    align-items: center;
    gap: 6px;
  }

  /* ====== FOOTER ====== */
  .foot{
    text-align:center;
    font-size: 12px;
    color: rgba(0,0,0,.55);
    padding: 10px 18px 18px;
    margin-top: 10px;
    border-top: 1px solid rgba(0,0,0,.06);
  }
  .foot a{
    color: var(--red-800);
    font-weight: 900;
    text-decoration:none;
  }
  .foot a:hover{ text-decoration: underline; }

  /* ====== ANIMATIONS (SVG) ====== */
  @keyframes floaty { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-4px)} }
  .floaty{ animation: floaty 2.6s ease-in-out infinite; }

  @keyframes checkIn {
    0% { transform: translateY(10px) scale(0.8); opacity: 0; }
    70% { transform: translateY(-5px) scale(1.1); opacity: 1; }
    100% { transform: translateY(0) scale(1); opacity: 1; }
  }
  .check-in { animation: checkIn 1.2s ease-out; }

  @keyframes peopleFloat {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-8px) rotate(2deg); }
  }
  .people-float { animation: peopleFloat 3s ease-in-out infinite; }
</style>
@endpush

@section('content')
<div class="absensi-stage">
  <div class="phone">

    {{-- HERO --}}
    <div class="hero">
      <div class="blob b1"></div>
      <div class="blob b2"></div>
      <div class="blob b3"></div>

      <h1>Hello!</h1>
      <p>Isi data absensi webinar Anda dengan benar</p>
    </div>

    {{-- CARD --}}
    <div class="card-wrap">
      <div class="cardx">
        <div class="card-head">
          <h2>Absensi Webinar</h2>
          <span class="badge-soft">E-Sertifikat</span>
        </div>

        <div class="card-body">

          {{-- ANIMASI --}}
          <div class="anim-panel">
            <svg viewBox="0 0 360 180" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <defs>
                <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0" stop-color="#ffffff" stop-opacity=".9"/>
                  <stop offset="1" stop-color="#ffd9dc" stop-opacity=".35"/>
                </linearGradient>
              </defs>
              <rect x="0" y="0" width="360" height="180" fill="url(#g)"/>

              <g class="floaty">
                <rect x="50" y="60" width="260" height="80" rx="20" fill="#fff" stroke="rgba(155,0,0,.18)"/>
                <rect x="70" y="75" width="40" height="50" rx="10" fill="rgba(155,0,0,.25)"/>
                <rect x="130" y="75" width="40" height="50" rx="10" fill="rgba(155,0,0,.45)"/>
                <rect x="190" y="75" width="40" height="50" rx="10" fill="rgba(155,0,0,.70)"/>
                <rect x="250" y="75" width="40" height="50" rx="10" fill="rgba(155,0,0,.35)"/>
              </g>

              <g class="people-float">
                <circle cx="40" cy="120" r="12" fill="rgba(155,0,0,.65)"/>
                <rect x="34" y="132" width="12" height="16" rx="6" fill="rgba(155,0,0,.55)"/>

                <circle cx="310" cy="120" r="10" fill="rgba(155,0,0,.45)"/>
                <rect x="306" y="130" width="8" height="14" rx="4" fill="rgba(155,0,0,.35)"/>

                <circle cx="340" cy="140" r="8" fill="rgba(155,0,0,.30)"/>
                <rect x="336" y="148" width="6" height="10" rx="3" fill="rgba(155,0,0,.25)"/>
              </g>

              <g class="check-in">
                <path d="M180,95 L200,115 L240,85" fill="none" stroke="rgba(155,0,0,.85)" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
              </g>

              <path d="M0 156 C60 138 120 168 180 152 C240 136 300 166 360 148 L360 180 L0 180 Z"
                    fill="rgba(155,0,0,.08)"/>
            </svg>
            <div class="caption">Proses absensi berjalan…</div>
          </div>

          {{-- ALERTS --}}
          @if(session('success'))
            <div class="alertx success">✅ {{ session('success') }}</div>
          @endif

          @if ($errors->any())
            <div class="alertx error">
              <div style="font-weight: 800;">Periksa lagi ya:</div>
              <ul>
                @foreach ($errors->all() as $err)
                  <li>{{ $err }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          {{-- FORM (✅ LOGIC DATABASE TETAP PAKAI $fields) --}}
          <form method="POST" action="{{ url('/absensi') }}">
            @csrf

            {{-- SATU-SATUNYA WEBINAR ID (DARI URL) --}}
            <input type="hidden" name="webinar_id" value="{{ request()->query('webinar_id') }}">

            @foreach ($fields as $field)
              @php
                // icon hanya tampilan, TIDAK mengubah database
                $iconSvg = 'user';
                if ($field->type === 'email') $iconSvg = 'mail';
                elseif ($field->type === 'tel') $iconSvg = 'phone';
                elseif ($field->type === 'number') $iconSvg = 'hash';
                elseif ($field->type === 'date') $iconSvg = 'calendar';
                elseif ($field->type === 'textarea') $iconSvg = 'note';
                else $iconSvg = 'user';

                $labelLower = strtolower($field->label ?? '');
                $keyLower   = strtolower($field->field_key ?? '');

                $ph = $field->placeholder; // tetap pakai dari DB kalau sudah ada
                if (empty($ph)) {
                  if ($field->type === 'email' || str_contains($labelLower, 'email') || str_contains($keyLower, 'email')) {
                    $ph = 'Masukkan email aktif';
                  } elseif ($field->type === 'tel' || str_contains($labelLower, 'handphone') || str_contains($labelLower, 'hp') || str_contains($keyLower, 'phone') || str_contains($keyLower, 'hp')) {
                    $ph = 'Contoh: 08xxxxxxxxxxx';
                  } elseif (str_contains($labelLower, 'nama') || str_contains($keyLower, 'nama')) {
                    $ph = 'Masukkan nama lengkap';
                  } else {
                    $ph = ''; // biarkan kosong kalau bukan field yang kamu minta
                  }
                }
              @endphp

              <div class="form-group">
                <label class="form-label" for="f_{{ $field->field_key }}">
                  {{ $field->label }}
                  @if ($field->required) <span style="color:#dc2626">*</span> @endif
                </label>

                <div class="input-wrapper">
                  {{-- icon --}}
                  @if($iconSvg === 'user')
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
                    </svg>
                  @elseif($iconSvg === 'mail')
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                      <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"/>
                    </svg>
                  @elseif($iconSvg === 'phone')
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                      <path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z" fill="currentColor"/>
                    </svg>
                  @elseif($iconSvg === 'hash')
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                      <path d="M10 3L8 21M16 3l-2 18M4 8h18M3 16h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                  @elseif($iconSvg === 'calendar')
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                      <path d="M7 2v3M17 2v3M4 7h16M5 5h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                  @else
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                      <path d="M4 4h16v16H4V4Zm3 4h10M7 12h10M7 16h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                  @endif

                  @if ($field->type === 'textarea')
                    <textarea
                      id="f_{{ $field->field_key }}"
                      name="{{ $field->field_key }}"
                      class="inputx has-icon"
                      placeholder="{{ $ph }}"
                      {{ $field->required ? 'required' : '' }}
                    >{{ old($field->field_key) }}</textarea>
                  @else
                    <input
                      id="f_{{ $field->field_key }}"
                      type="{{ $field->type }}"
                      name="{{ $field->field_key }}"
                      class="inputx has-icon"
                      placeholder="{{ $ph }}"
                      value="{{ old($field->field_key) }}"
                      {{ $field->required ? 'required' : '' }}
                    >
                  @endif
                </div>

                @error($field->field_key)
                  <small class="err">{{ $message }}</small>
                @enderror
              </div>
            @endforeach

            <button type="submit" class="btn-red">
              Kirim Absensi
            </button>

            <div class="info-pills">
              <span class="pill">🔒 Data aman</span>
              <span class="pill">⏱ Cepat & mudah</span>
              <span class="pill">📄 Lanjut evaluasi</span>
            </div>
          </form>

          <div class="foot">
            <p style="margin:0;">
              Sudah mengisi? <a href="{{ url('/evaluasi') }}">Lanjut ke Evaluasi</a>
            </p>
            <p style="margin-top: 6px; font-size: 11px; opacity: 0.6;">
              © {{ date('Y') }} E-Sertifikat System
            </p>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>
@endsection
