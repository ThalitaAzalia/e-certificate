@extends('layouts.app')

@section('title', 'Evaluasi Kegiatan')

@section('content')

<style>
:root{
  --red-main:#9b0000;
  --red-dark:#7a0000;
  --red-light:#fff5f5;
  --red-soft:rgba(155,0,0,.08);
  --red-border:rgba(155,0,0,.15);
  --card-radius:18px;
}

/* ✅ BACKGROUND seperti login */
body{
  margin:0;
  background:#ffe9ee;
}

/* ✅ motif topographic */
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
  z-index:-1;
}

/* HERO */
.top-hero{
  position:relative;
  min-height:320px;
  padding:70px 18px 0;
  overflow:hidden;
  color:#fff;
  background:linear-gradient(135deg,var(--red-dark),var(--red-main));
}

.top-hero::before{
  content:"";
  position:absolute;
  inset:0;
  background-image:
    radial-gradient(rgba(255,255,255,.14) 1px, transparent 1px),
    radial-gradient(rgba(255,255,255,.10) 1px, transparent 1px);
  background-size:46px 46px, 74px 74px;
  background-position:0 0, 22px 22px;
  opacity:.22;
  pointer-events:none;
}

.hero-content{
  position:relative;
  max-width:920px;
  margin:0 auto;
  text-align:center;
  z-index:2;
}

.hero-title{
  font-weight:900;
  letter-spacing:.2px;
  margin-bottom:6px;
  font-size:34px;
}

.hero-subtitle{
  opacity:.95;
  max-width:720px;
  font-weight:500;
  font-size:16px;
  margin:0 auto;
}

.badge-hero{
  display:inline-block;
  padding:6px 16px;
  border-radius:999px;
  background:rgba(255,255,255,.18);
  border:1px solid rgba(255,255,255,.25);
  font-size:.9rem;
  font-weight:700;
  color:#fff;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

.wave-smooth{
  position:absolute;
  bottom:-1px;
  left:0;
  width:100%;
  height:160px;
  z-index:1;
}

/* form overlap */
.form-wrap{
  margin-top:-95px;
  position:relative;
  z-index:3;
}

/* ✅ CARD seperti login */
.evaluation-card{
  border-radius:28px;
  box-shadow:
    0 28px 75px rgba(122,0,0,.20),
    0 0 0 6px rgba(155,0,0,.04);
  border:1px solid rgba(155,0,0,.10);
  background:
    linear-gradient(180deg, rgba(255,245,245,.65), rgba(255,255,255,1) 42%);
  position:relative;
  overflow:hidden;
}

.evaluation-card::before{
  content:"";
  position:absolute;
  inset:0;
  background:
    radial-gradient(240px 160px at 22% 15%, rgba(155,0,0,.10), transparent 60%),
    radial-gradient(260px 180px at 85% 35%, rgba(155,0,0,.06), transparent 60%);
  pointer-events:none;
  opacity:.9;
}

/* question box */
.question-box{
  background:#fff;
  border:1px solid var(--red-border);
  border-left:6px solid var(--red-main);
  border-radius:16px;
  padding:20px;
  background: linear-gradient(180deg, rgba(255,245,245,.85), #fff 42%);
  box-shadow: 0 10px 30px rgba(155,0,0,.08);
  transition: all .2s ease;
  position:relative;
}

.question-box:hover{
  border-color: var(--red-main);
  box-shadow: 0 14px 35px rgba(155,0,0,.12);
  transform: translateY(-2px);
}

/* input style */
.form-control, .form-select{
  border-radius:14px;
  border:1.5px solid rgba(0,0,0,.12);
  padding:14px 16px;
  background:#fff;
  box-shadow: 0 8px 20px rgba(0,0,0,.04);
  font-size:15px;
  font-weight:500;
  color:#1b1b1b;
  transition: all .2s ease;
}

.form-control:focus, .form-select:focus{
  border-color: var(--red-main);
  box-shadow:
    0 0 0 4px rgba(155,0,0,.15),
    0 12px 28px rgba(155,0,0,.12);
  transform: translateY(-1px);
}

/* rating */
.rating-group{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
}

.rating-pill{
  display:inline-flex;
  align-items:center;
  gap:10px;
  border:2px solid rgba(155,0,0,.2);
  border-radius:999px;
  padding:10px 16px;
  cursor:pointer;
  transition:.18s;
  background:#fff;
  user-select:none;
  position:relative;
}

.rating-pill:hover{
  border-color: var(--red-main);
  background: var(--red-light);
  transform: translateY(-2px);
}

.rating-dot{
  width:36px;
  height:36px;
  border-radius:50%;
  border:2px solid var(--red-main);
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:900;
  color: var(--red-main);
  transition: all .2s ease;
}

.rating-pill:hover .rating-dot{
  background: var(--red-main);
  color:#fff;
}

/* hidden radio */
.visually-hidden-input{
  position:absolute !important;
  opacity:0 !important;
  width:1px;
  height:1px;
  margin:-1px;
  padding:0;
  overflow:hidden;
  clip: rect(0,0,0,0);
  border:0;
}

/* selected state (tanpa JS pun tetap works via :has untuk browser modern) */
.rating-pill:has(input:checked){
  border-color: var(--red-main);
  background: var(--red-light);
}
.rating-pill:has(input:checked) .rating-dot{
  background: var(--red-main);
  color:#fff;
}

/* button */
.btn-red{
  background: linear-gradient(135deg, var(--red-dark), var(--red-main));
  border:0;
  border-radius:14px;
  padding:16px;
  font-weight:900;
  font-size:15px;
  color:#fff;
  box-shadow: 0 16px 34px rgba(155,0,0,.26);
  transition: all .2s ease;
  width:100%;
  letter-spacing:.3px;
}

.btn-red:hover{
  filter: brightness(1.08);
  box-shadow: 0 20px 40px rgba(155,0,0,.32);
  transform: translateY(-2px);
  color:#fff;
}

.btn-red:active{ transform: translateY(0); }

/* alert */
.alert{
  border-radius:14px;
  border:2px solid;
}

.alert-success{
  background: rgba(21, 128, 61, 0.1);
  border-color: rgba(21, 128, 61, 0.3);
}

.alert-danger{
  background: rgba(239, 68, 68, 0.1);
  border-color: rgba(239, 68, 68, 0.3);
}
</style>

{{-- HERO --}}
<section class="top-hero">
  <div class="hero-content">
    <div class="badge-hero mb-3">Evaluasi</div>
    <h1 class="hero-title">Evaluasi Kegiatan</h1>
    <p class="hero-subtitle">
      Silakan isi evaluasi berikut. Masukan Anda membantu kami meningkatkan kualitas kegiatan selanjutnya.
    </p>
  </div>

  <svg class="wave-smooth" viewBox="0 0 1440 320" preserveAspectRatio="none" aria-hidden="true">
    <path fill="#fff"
      d="M0,224 C240,288 480,288 720,240 C960,192 1200,96 1440,144 L1440,320 L0,320 Z">
    </path>
  </svg>
</section>

<div class="container form-wrap" style="max-width:920px;">
  <div class="card evaluation-card">
    <div class="card-body p-4 p-md-5" style="position:relative; z-index:2;">

      {{-- optional: kalau controller kamu set session success / errors --}}
      @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger mb-4">
          <div class="fw-semibold mb-1">Mohon periksa kembali isian Anda:</div>
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ url('/evaluasi') }}" id="evaluationForm">
        @csrf

        <input type="text" name="website" style="display:none">
        
        @forelse($questions as $q)
          <div class="question-box mb-4">
            <label class="fw-bold mb-2 d-block" style="font-size:1.05rem;">
              {{ $loop->iteration }}. {{ $q->question }}
            </label>

            {{-- TEXT --}}
            @if($q->type === 'text')
              <input type="text"
                     class="form-control"
                     name="answers[{{ $q->id }}]"
                     placeholder="Tuliskan jawaban Anda"
                     value="{{ old('answers.'.$q->id) }}">

            {{-- TEXTAREA --}}
            @elseif($q->type === 'textarea')
              <textarea class="form-control"
                        rows="4"
                        name="answers[{{ $q->id }}]"
                        placeholder="Tuliskan masukan/saran Anda">{{ old('answers.'.$q->id) }}</textarea>

            {{-- RATING --}}
            @elseif($q->type === 'rating')
              <div class="rating-group">
                @for($i=1;$i<=5;$i++)
                  <label class="rating-pill">
                    <input type="radio"
                           name="answers[{{ $q->id }}]"
                           value="{{ $i }}"
                           class="visually-hidden-input"
                           @checked(old('answers.'.$q->id) == $i)>

                    <span class="rating-dot">{{ $i }}</span>
                    <span class="text-muted" style="font-size:.95rem;">
                      @if($i==1) Sangat Tidak Puas
                      @elseif($i==2) Tidak Puas
                      @elseif($i==3) Cukup
                      @elseif($i==4) Puas
                      @else Sangat Puas
                      @endif
                    </span>
                  </label>
                @endfor
              </div>
            @endif

            @error('answers.'.$q->id)
              <small class="text-danger d-block mt-2">{{ $message }}</small>
            @enderror
          </div>
        @empty
          <div class="text-muted">Belum ada pertanyaan evaluasi.</div>
        @endforelse

        <button type="submit" class="btn btn-red w-100 mt-4">
          Kirim Evaluasi
        </button>

        <div class="text-center text-muted mt-4" style="font-size:.9rem;">
          Terima kasih atas waktu dan masukan Anda.
        </div>

      </form>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('evaluationForm');
  if (!form) return;

  form.addEventListener('submit', function() {
    const submitBtn = this.querySelector('button[type="submit"]');
    if (!submitBtn) return;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
  });
});
</script>

@endsection
