@extends('layouts.app')

@section('title', 'Detail Evaluasi Peserta')

@section('content')
<div class="container-fluid py-4 detail-evaluasi">
  <div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">

      {{-- HEADER (CARD) --}}
      <div class="gov-header-card">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3">
          <div>
            <div class="gov-breadcrumb">
              <a class="link-muted" href="{{ route('admin.laporan.evaluasi') }}">Laporan Evaluasi</a>
              <span class="sep">/</span>
              <a class="link-muted" href="{{ route('admin.laporan.evaluasi.peserta', $peserta->webinar_id) }}">Peserta</a>
              <span class="sep">/</span>
              <span class="fw-semibold text-dark">Detail Evaluasi</span>
            </div>

            <h1 class="gov-title">Detail Evaluasi Peserta</h1>
            <p class="gov-subtitle">Rincian identitas peserta dan jawaban evaluasi.</p>
          </div>

          <div class="gov-actions">
            <a href="{{ route('admin.laporan.evaluasi.peserta', $peserta->webinar_id) }}"
              class="btn btn-ghost d-flex align-items-center gap-2">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>
      </div>


      {{-- MAIN CARD --}}
      <div class="card border-0 shadow-sm card-soft">

        {{-- CARD HEADER --}}
        <div class="card-header bg-white py-4 border-bottom">
          <div class="d-flex align-items-center">
            <div class="avatar-lg avatar-brand rounded-circle d-flex align-items-center justify-content-center me-3">
              <i class="fas fa-user-check text-brand fa-lg"></i>
            </div>
            <div>
              <h2 class="h5 fw-bold mb-1">{{ $peserta->nama_peserta }}</h2>
              <p class="muted mb-0">
                <i class="fas fa-envelope me-1"></i>{{ $peserta->email }}
              </p>
            </div>
          </div>
        </div>

        <div class="card-body p-0">

          {{-- PESERTA INFO --}}
          <div class="p-4 border-bottom">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="d-flex align-items-start">
                  <div class="flex-shrink-0">
                    <span class="badge badge-soft">
                      <i class="fas fa-chalkboard-teacher me-1"></i>Webinar
                    </span>
                  </div>
                  <div class="ms-3">
                    <h6 class="mb-1 fw-semibold label-item small">Judul Webinar</h6>
                    <p class="mb-0">{{ $peserta->webinar->judul }}</p>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="d-flex align-items-start">
                  <div class="flex-shrink-0">
                    <span class="badge badge-soft">
                      <i class="fas fa-calendar-alt me-1"></i>Waktu
                    </span>
                  </div>
                  <div class="ms-3">
                    <h6 class="mb-1 fw-semibold label-item small">Tanggal Mengisi</h6>
                    <p class="mb-0">
                      {{ $peserta->created_at->translatedFormat('l, d F Y') }}
                      <br>
                      <small class="muted">{{ $peserta->created_at->format('H:i') }} WIB</small>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- EVALUASI SECTION --}}
          <div class="p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
              <h3 class="h5 fw-bold mb-0">
                <i class="fas fa-clipboard-check text-brand me-2"></i>
                Jawaban Evaluasi
              </h3>

              <div class="d-flex align-items-center gap-3">
                <span class="badge badge-soft">
                  {{ $questions->count() }} Pertanyaan
                </span>

              </div>
            </div>

            @forelse($questions as $index => $q)
              @php $ans = $peserta->evaluasiAnswers->where('evaluasi_question_id', $q->id)->first(); @endphp
              <div class="mb-4 pb-3 {{ !$loop->last ? 'border-bottom border-soft' : '' }}">
                <div class="d-flex align-items-start mb-2">
                  <span class="badge badge-soft rounded-pill me-2 badge-number-item">
                    {{ $loop->iteration }}
                  </span>
                  <div>
                    <h6 class="fw-semibold mb-1">{{ $q->question }}</h6>
                  </div>
                </div>

                <div class="ms-4 ps-3">
                  <div class="answer-box">
                    @if($ans && is_numeric($ans->answer) && $q->type === 'rating')
                      <div class="d-flex align-items-center flex-wrap">
                        <div class="rating-display">
                          @for($i = 1; $i <= ($q->rating_max ?? 5); $i++)
                            @if($i <= (int) $ans->answer)
                              <i class="fas fa-star text-warning me-1"></i>
                            @else
                              <i class="far fa-star text-secondary me-1"></i>
                            @endif
                          @endfor
                        </div>
                        <span class="ms-2 fw-semibold">({{ $ans->answer }}/{{ $q->rating_max ?? 5 }})</span>
                      </div>
                    @elseif($ans && $ans->answer)
                      <p class="mb-0">{{ $ans->answer }}</p>
                    @else
                      <span class="muted">Tidak ada jawaban</span>
                    @endif
                  </div>
                </div>
              </div>
            @empty
              <div class="text-center py-5">
                <div class="mb-3">
                  <i class="fas fa-clipboard-list fa-3x text-muted opacity-50"></i>
                </div>
                <h5 class="muted mb-2">Belum Ada Pertanyaan</h5>
                <p class="muted">Belum ada pertanyaan evaluasi yang terdaftar.</p>
              </div>
            @endforelse

            @if(!empty($showOrphan) && $showOrphan)

              @php
                $orphan = $peserta->evaluasiAnswers->filter(fn($a) => $a->question === null);
              @endphp
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('head')
<style>
  :root{
    --brand:#b91c1c;
    --brand-2:#dc2626;
    --brand-3:#991b1b;
    --bg-page:#fafafa;
    --bg-card:#ffffff;
    --border-soft: rgba(185,28,28,.12);
    --ink:#111827;
    --muted:#6b7280;
  }

  body{
    background: var(--bg-page);
    font-family: 'Inter', -apple-system, sans-serif;
  }

  .muted{ color: var(--muted) !important; }
  .text-brand{ color: var(--brand) !important; }
  .link-muted{ color: var(--muted); text-decoration:none; }
  .link-muted:hover{ color: var(--brand-3); text-decoration: underline; }

  .card-soft{
    background: var(--bg-card) !important;
    border: 1px solid var(--border-soft) !important;
    border-radius: 16px !important;
    box-shadow:
      0 18px 40px rgba(185,28,28,.06),
      0 6px 16px rgba(185,28,28,.05) !important;
  }

  .border-soft{ border-color: rgba(185,28,28,.14) !important; }

  .avatar-lg{ width: 60px; height: 60px; }
  .avatar-brand{
    background: rgba(185,28,28,.06) !important;
    border: 1px solid rgba(185,28,28,.14);
  }

  .btn-ghost{
    border: 1px solid rgba(185, 28, 28, 0.20);
    background: #fff;
    color: var(--brand);
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
  }
  .btn-ghost:hover{
    background: rgba(185, 28, 28, 0.05);
    color: var(--brand-3);
  }
  .btn-ghost:hover,
  .btn-ghost:focus,
  .btn-ghost:active{
    color: #111827;
  }

  .badge-soft{
    border-radius: 999px;
    padding: .35rem .65rem;
    font-weight: 800;
    font-size: .85rem;
    border:1px solid rgba(185,28,28,.18);
    background: rgba(185,28,28,.06);
    color: var(--brand-3);
  }

  .answer-box{
    background: rgba(185,28,28,.03);
    border: 1px solid rgba(185,28,28,.10);
    border-radius: 14px;
    padding: .85rem .9rem;
  }

  .rating-display{ font-size: 1.1rem; }

  .detail-evaluasi .badge-number-item{
    color: var(--ink) !important;
    border-color: #e5e7eb !important;
    background: #f9fafb !important;
  }

  .detail-evaluasi .label-item{
    color: var(--ink) !important;
    opacity: .85;
  }

    /* ===== GOV HEADER CARD ===== */
  .gov-header-card{
    background:#fff;
    border:1px solid rgba(185,28,28,.12);
    border-radius:14px;
    padding:18px 20px;
    box-shadow: 0 2px 10px rgba(15,23,42,.04);
    margin-bottom: 18px;
  }

  .gov-breadcrumb{
    font-size:.875rem;
    color:#6b7280;
    display:flex;
    gap:8px;
    flex-wrap:wrap;
    align-items:center;
    margin-bottom:10px;
  }

  .gov-breadcrumb .sep{ opacity:.6; }

  .gov-title{
    font-size:2.1rem;
    font-weight:900;
    letter-spacing:-.03em;
    color:#111827;
    margin:0;
    line-height:1.1;
  }

  .gov-subtitle{
    margin-top:8px;
    color:#6b7280;
    font-size:1rem;
    margin-bottom:0;
  }

  .gov-actions{
    display:flex;
    gap:.5rem;
    flex-wrap:wrap;
    justify-content:flex-end;
  }

  .gov-header-card{
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    will-change: transform;
  }

  .gov-header-card:hover{
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 16px 34px rgba(15,23,42,.10);
    border-color: rgba(185,28,28,.18);
  }

  @media (prefers-reduced-motion: reduce){
    .gov-header-card,
    .gov-header-card:hover{
      transition: none !important;
      transform: none !important;
    }
  }

</style>
@endpush
