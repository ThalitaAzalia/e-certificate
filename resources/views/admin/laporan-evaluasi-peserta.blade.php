@extends('layouts.app')

@section('title', 'Peserta Evaluasi')

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

  .page-title{
    font-weight:900;
    letter-spacing:-.025em;
    color: var(--brand-3);
    font-size: 1.75rem;
  }
  .muted{ color: var(--muted); }
  .rounded-16{ border-radius:16px; }

  .card-soft{
    background: var(--bg-card) !important;
    border: 1px solid var(--border-soft);
    border-radius: 16px;
    box-shadow:
      0 18px 40px rgba(185,28,28,.06),
      0 6px 16px rgba(185,28,28,.05);
  }

  .btn-brand{
    background: var(--brand);
    color:#fff;
    border:none;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
  }
  .btn-brand:hover{ background: var(--brand-2); color:#fff; }

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
 
  .btn-ghost{
    color: var(--brand); 
  }

  .btn-ghost:hover,
  .btn-ghost:focus{
    color: #111827;
  }

  .btn-ghost:active{
    color: #111827;
  }

  .btn-outline-brand{
    border: 1px solid rgba(185, 28, 28, 0.20);
    background: #fff;
    color: var(--brand);
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
  }
  .btn-outline-brand:hover{
    background: rgba(185, 28, 28, 0.05);
    color: var(--brand-3);
  }

  .btn.btn-sm.btn-outline-brand{
    padding: .35rem .9rem;
    font-size: .875rem;
  }

  .chip{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:.35rem .65rem;
    border-radius:999px;
    font-weight:800;
    font-size:.85rem;
    border:1px solid rgba(185,28,28,.18);
    background: rgba(185,28,28,.06);
    color: var(--brand-3);
  }

  .divider-soft{
    height:1px;
    background: rgba(185,28,28,.14);
    border-radius:999px;
  }

  .toolbar-mini{
    display:flex;
    gap:10px;
    flex-wrap: wrap;
    align-items:center;
    justify-content: space-between;
  }

  /* table */
  .table td, .table th{ vertical-align: middle; }
  .table-header{
    background: rgba(185, 28, 28, 0.05);
    color: var(--brand-3);
    font-weight: 800;
    font-size: .75rem;
    letter-spacing: .02em;
    text-transform: uppercase;
  }
  .table > :not(caption) > * > *{ padding: .9rem .95rem; }
  .table-hover tbody tr:hover{
    background: rgba(185,28,28,.03);
  }

  .avatar-sm{
    width: 36px;
    height: 36px;
    border-radius: 999px;
    display:flex;
    align-items:center;
    justify-content:center;
    background: rgba(185,28,28,.06);
    border: 1px solid rgba(185,28,28,.14);
    color: var(--brand-3);
    flex-shrink: 0;
    font-weight: 900;
    font-size: .9rem;
    text-transform: uppercase;
    letter-spacing: .02em;
  }

  .link-muted{
    color: var(--muted);
    text-decoration: none;
  }
  .link-muted:hover{ color: var(--brand-3); }

  .name-stack .fw-semibold{ line-height: 1.1; }

  .footer-note{
    display:flex;
    align-items:center;
    justify-content: space-between;
    gap: .75rem;
    flex-wrap: wrap;
  }
  
  /* ===== Header Card ===== */
  .header-card{
    background: linear-gradient(180deg, rgba(185,28,28,.06), rgba(255,255,255,1));
    border: 1px solid rgba(185,28,28,.14);
    border-radius: 16px;
    padding: 18px 18px;
    box-shadow: 0 10px 26px rgba(185,28,28,.06);
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    will-change: transform;
    margin-bottom: 18px;
  }

  .header-card:hover{
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 18px 40px rgba(185,28,28,.10);
    border-color: rgba(185,28,28,.22);
  }

  .header-card .breadcrumb-mini{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    margin-top: 6px;
    font-size: .95rem;
  }

  .header-card .breadcrumb-mini .sep{
    color: rgba(107,114,128,.9);
  }

  .header-card .actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    align-items:center;
    justify-content:flex-end;
  }


</style>
@endpush

@section('content')
<div class="container py-3">

  {{-- Header (CARD) --}}
  <div class="header-card">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
      <div>
        <h1 class="page-title mb-1">Daftar Peserta Evaluasi</h1>

        <div class="breadcrumb-mini">
          <a class="link-muted" href="{{ route('admin.laporan.evaluasi') }}">Laporan Evaluasi</a>
          <span class="sep">/</span>
          <span class="fw-semibold" style="color:var(--ink);">
            {{ $webinar->judul ?? 'Webinar' }}
          </span>
        </div>
      </div>

      <div class="actions">
        <span class="chip">
          <i class="fas fa-users fa-sm"></i> {{ $pesertas->count() }} Peserta
        </span>

        <a href="{{ route('admin.laporan.evaluasi') }}" class="btn btn-ghost d-flex align-items-center gap-2">
          <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
      </div>
    </div>
  </div>


  {{-- Webinar info --}}
  <div class="card card-soft rounded-16 mb-4">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar-sm" style="width:44px;height:44px;">
            <i class="fas fa-chalkboard-teacher"></i>
          </div>
          <div>
            <div class="fw-semibold">Informasi Webinar</div>
            <div class="muted">{{ $webinar->judul ?? '-' }}</div>
          </div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
          @if(!empty($webinar->tanggal))
            <span class="chip">
              <i class="fas fa-calendar-alt fa-sm"></i>
              {{ \Carbon\Carbon::parse($webinar->tanggal)->translatedFormat('d F Y') }}
            </span>
          @endif
          @if(!empty($webinar->jam))
            <span class="chip">
              <i class="fas fa-clock fa-sm"></i>
              {{ $webinar->jam }}
            </span>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- Main table --}}
  <div class="card card-soft rounded-16">
    <div class="card-body">

      <div class="toolbar-mini mb-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <div class="fw-semibold">Daftar Peserta</div>
          <span class="chip">{{ $pesertas->count() }} data</span>
        </div>
      </div>

      @if($pesertas->isEmpty())
        <div class="text-center py-5">
          <div class="fw-semibold mb-1">Belum Ada Data Evaluasi</div>
          <div class="muted">Tidak ada peserta yang telah mengisi evaluasi webinar ini.</div>
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-header">
              <tr>
                <th style="width:60px;" class="text-center">No</th>
                <th>Nama Peserta</th>
                <th>Email</th>
                <th>Waktu Absensi</th>
                <th style="width:140px;" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pesertas as $i => $peserta)
                @php
                  $absenText = '-';
                  if (!empty($peserta->waktu_absen)) {
                    try {
                      $absenText = \Carbon\Carbon::parse($peserta->waktu_absen)->translatedFormat('d F Y, H:i');
                    } catch (\Throwable $e) {
                      $absenText = (string) $peserta->waktu_absen;
                    }
                  }
                @endphp
                <tr>
                  <td class="text-center text-muted fw-semibold">{{ $i + 1 }}</td>

                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <div class="name-stack">
                        <div class="fw-semibold">{{ $peserta->nama_peserta ?? '-' }}</div>
                      </div>
                    </div>
                  </td>

                  <td>
                    @if(!empty($peserta->email))
                      <a href="mailto:{{ $peserta->email }}" class="link-muted">
                        <span class="text-nowrap">{{ $peserta->email }}</span>
                      </a>
                    @else
                      <span class="muted">-</span>
                    @endif
                  </td>

                  <td>
                    <span class="text-nowrap">{{ $absenText }}</span>
                  </td>

                  <td class="text-center">
                    <a href="{{ route('admin.laporan.evaluasi.detail', $peserta->id) }}"
                       class="btn btn-sm btn-outline-brand">
                      Detail
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="divider-soft my-3"></div>

        <div class="footer-note">
          <div class="muted small">
            <i class="fas fa-info-circle me-1"></i>
            Menampilkan {{ $pesertas->count() }} peserta yang telah mengisi evaluasi
          </div>
        </div>
      @endif

    </div>
  </div>

</div>
@endsection
