@extends('layouts.app')

@section('title', 'Evaluasi Kegiatan')

@section('content')

<style>
:root{
  --red-main:#9b0000;
  --red-dark:#7a0000;
  --card-radius:18px;
}

body{
  margin:0;
  background:#f4f6f8;
}

.top-hero{
  position:relative;
  min-height:320px;
  padding:70px 18px 0;
  color:#fff;
  background:linear-gradient(135deg,var(--red-dark),var(--red-main));
}

.hero-content{
  max-width:920px;
  margin:0 auto;
  text-align:center;
}

.wave-smooth{
  position:absolute;
  bottom:-1px;
  left:0;
  width:100%;
  height:160px;
}

.form-wrap{
  margin-top:-95px;
}

.evaluation-card{
  border-radius:var(--card-radius);
  box-shadow:0 22px 55px rgba(0,0,0,.16);
}

.question-box{
  background:#fbfbfb;
  border:1px solid #eee;
  border-left:6px solid var(--red-main);
  border-radius:14px;
  padding:18px;
}

.rating-group{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
}

.rating-pill{
  display:flex;
  align-items:center;
  gap:10px;
  padding:10px 14px;
  border-radius:999px;
  border:1px solid #ddd;
  cursor:pointer;
  background:#fff;
}

.rating-pill input{
  position:absolute;
  opacity:0;
}

.rating-pill:has(input:checked){
  border-color:var(--red-main);
  background:rgba(155,0,0,.1);
}

.rating-dot{
  width:34px;
  height:34px;
  border-radius:50%;
  border:2px solid var(--red-main);
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:700;
}

.rating-pill:has(input:checked) .rating-dot{
  background:var(--red-main);
  color:#fff;
}

.btn-red{
  background:linear-gradient(135deg,var(--red-dark),var(--red-main));
  border:0;
  border-radius:14px;
  padding:14px;
  font-weight:700;
  color:#fff;
}
</style>

{{-- HERO --}}
<section class="top-hero">
  <div class="hero-content">
    <h1 class="fw-bold">Evaluasi Kegiatan</h1>
    <p>Silakan isi evaluasi berikut.</p>
  </div>

  <svg class="wave-smooth" viewBox="0 0 1440 320" preserveAspectRatio="none">
    <path fill="#fff"
      d="M0,224 C240,288 480,288 720,240 C960,192 1200,96 1440,144 L1440,320 L0,320 Z">
    </path>
  </svg>
</section>

<div class="container form-wrap" style="max-width:920px;">
  <div class="card evaluation-card">
    <div class="card-body p-4 p-md-5">

      <form method="POST" action="{{ url('/evaluasi') }}">
        @csrf

        @forelse($questions as $q)
          <div class="question-box mb-4">
            <label class="fw-semibold mb-3 d-block">
              {{ $loop->iteration }}. {{ $q->question }}
            </label>

            {{-- TEXT --}}
            @if($q->type === 'text')
              <input class="form-control"
                     name="answers[{{ $q->id }}]"
                     value="{{ old('answers.'.$q->id) }}">

            {{-- TEXTAREA --}}
            @elseif($q->type === 'textarea')
              <textarea class="form-control"
                        rows="4"
                        name="answers[{{ $q->id }}]">{{ old('answers.'.$q->id) }}</textarea>

            {{-- RATING --}}
            @elseif($q->type === 'rating')
              <div class="rating-group">
                @for($i=1;$i<=5;$i++)
                  <label class="rating-pill">
                    <input type="radio"
                           name="answers[{{ $q->id }}]"
                           value="{{ $i }}">
                    <span class="rating-dot">{{ $i }}</span>
                    <span>
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
          </div>
        @empty
          <div class="text-muted">Belum ada pertanyaan evaluasi.</div>
        @endforelse

        <button class="btn btn-red w-100 mt-3">
          Kirim Evaluasi
        </button>

      </form>

    </div>
  </div>
</div>

@endsection
