@extends('layouts.app')

@section('title', 'Laporan Evaluasi')

@push('head')
<style>
  :root {
    --brand: #b91c1c;
    --brand-2: #dc2626;
    --brand-3: #991b1b;
    --bg-page: #fafafa;
    --bg-card: #ffffff;
    --border-soft: rgba(185, 28, 28, 0.12);
  }

  body { 
    background: var(--bg-page); 
    font-family: 'Inter', -apple-system, sans-serif;
  }

  .page-title {
    font-weight: 900;
    letter-spacing: -0.025em;
    color: var(--brand-3);
    font-size: 1.75rem;
  }

  .card-soft {
    background: var(--bg-card) !important;
    border: 1px solid var(--border-soft);
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(185, 28, 28, 0.05);
    overflow: visible !important; /* ✅ FIX supaya footer/pagination gak kepotong */
  }

  .card-soft .card-body{
    overflow: visible !important; /* ✅ FIX tambahan */
  }

  .btn-brand {
    background: var(--brand);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
  }

  .btn-brand:hover { background: var(--brand-2); }

  .btn-ghost {
    border: 1px solid rgba(185, 28, 28, 0.2);
    background: white;
    color: var(--brand);
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
  }

  .btn-ghost:hover { background: rgba(185, 28, 28, 0.05); }

  .btn-excel {
    background: #21a366;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
  }

  .btn-excel:hover { background: #185c37; color: white; }

  .badge-pill {
    border-radius: 50px;
    padding: 0.25rem 0.5rem;
    font-weight: 600;
    font-size: 0.75rem;
  }

  /* FIX: class jangan pakai huruf kapital & tanda '-' yang aneh */
  .badge-average {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    border: 1px solid rgba(46, 125, 50, 0.2);
  }

  .badge-text {
    background: rgba(156, 163, 175, 0.1);
    color: #6b7280;
    border: 1px solid rgba(156, 163, 175, 0.2);
  }

  .badge-excellent {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.2);
  }

  .badge-good {
    background: rgba(251, 191, 36, 0.1);
    color: #d97706;
    border: 1px solid rgba(251, 191, 36, 0.2);
  }

  .badge-fair {
    background: rgba(248, 113, 113, 0.1);
    color: #dc2626;
    border: 1px solid rgba(248, 113, 113, 0.2);
  }

  .form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
  }

  .form-control:focus, .form-select:focus {
    border-color: var(--brand);
    box-shadow: 0 0 0 2px rgba(185, 28, 28, 0.1);
  }

  .table-header {
    background: rgba(185, 28, 28, 0.05);
    color: var(--brand-3);
    font-weight: 600;
    font-size: 0.75rem;
  }

  .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  }

  .score {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 46px;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.875rem;
    border: 1px solid rgba(185, 28, 28, 0.2);
    background: rgba(185, 28, 28, 0.06);
    color: var(--brand-3);
  }

  .score.excellent {
    background: rgba(34, 197, 94, 0.1);
    border-color: rgba(34, 197, 94, 0.2);
    color: #16a34a;
  }

  .score.good {
    background: rgba(251, 191, 36, 0.1);
    border-color: rgba(251, 191, 36, 0.2);
    color: #d97706;
  }

  .score.fair {
    background: rgba(248, 113, 113, 0.1);
    border-color: rgba(248, 113, 113, 0.2);
    color: #dc2626;
  }

  .chip {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.75rem;
    background: rgba(185, 28, 28, 0.08);
    border: 1px solid rgba(185, 28, 28, 0.15);
    color: var(--brand-3);
  }

  .chip.success {
    background: rgba(34, 197, 94, 0.1);
    border-color: rgba(34, 197, 94, 0.2);
    color: #16a34a;
  }

  .chip.info {
    background: rgba(59, 130, 246, 0.1);
    border-color: rgba(59, 130, 246, 0.2);
    color: #2563eb;
  }

  .wave-card {
    background: white;
    border: 1px solid var(--border-soft);
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1rem;
  }

  .wave-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
  }

  .wave-title {
    font-weight: 600;
    color: var(--brand-3);
    font-size: 0.9375rem;
    margin: 0;
  }

  .wave-sub {
    color: #6b7280;
    font-size: 0.8125rem;
    margin: 0;
  }

  .wave-shell {
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid rgba(185, 28, 28, 0.08);
    padding: 1rem;
  }

  .wave-legend {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 1rem;
    font-size: 0.75rem;
    color: #6b7280;
  }

  .wave-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 0.375rem;
  }

  .wave-note {
    margin-top: 1rem;
    font-size: 0.75rem;
    color: #6b7280;
    padding: 0.75rem;
    background: rgba(185, 28, 28, 0.03);
    border-radius: 6px;
    border-left: 3px solid var(--brand);
  }

  .webinar-link {
    display: block;
    padding: 0;
    border: none;
    background: transparent;
    border-radius: 0;
    color: inherit;
    font-weight: 600;
    text-decoration: none;
    transition: none;
  }

  .webinar-link:hover { background: transparent; color: inherit; transform: none; }

  .subtxt {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
  }

  .metric-card {
    background: white;
    border: 1px solid var(--border-soft);
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
  }

  .metric-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--brand-3);
    line-height: 1.2;
  }

  .metric-label {
    font-size: 0.8125rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
  }

  .empty-state {
    padding: 2rem 1rem;
    text-align: center;
    background: white;
    border-radius: 12px;
    border: 1px solid var(--border-soft);
  }

  .empty-state-icon {
    font-size: 2rem;
    color: #9ca3af;
    margin-bottom: 0.75rem;
    opacity: 0.5;
  }

  .empty-state-title {
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.5rem;
  }

  .empty-state-description {
    color: #9ca3af;
    font-size: 0.875rem;
    max-width: 300px;
    margin: 0 auto 1rem;
  }

  .progress-bar-custom {
    height: 6px;
    background: rgba(185, 28, 28, 0.1);
    border-radius: 3px;
    overflow: hidden;
    margin: 0.5rem 0;
  }

  .progress-fill {
    height: 100%;
    background: var(--brand);
    border-radius: 3px;
    transition: width 0.3s ease;
  }

  .table-analytics {
    --bs-table-bg: transparent;
    --bs-table-striped-bg: rgba(185, 28, 28, 0.02);
    --bs-table-hover-bg: rgba(185, 28, 28, 0.04);
  }

  .table-analytics thead th {
    background: rgba(185, 28, 28, 0.05);
    color: var(--brand-3);
    font-weight: 600;
    font-size: 0.8125rem;
    border-bottom: 2px solid rgba(185, 28, 28, 0.1);
  }

  .table-analytics tbody tr {
    transition: background-color 0.2s ease;
  }

  .table-analytics tbody tr:hover {
    background: rgba(185, 28, 28, 0.03);
  }
  /* ==== Compact card grafik (mirip screenshot) ==== */
  .wave-card-compact{
    padding: 14px 16px !important;
  }

  .wave-head-compact{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    margin-bottom:10px;
  }

  .wave-shell-compact{
    background: #ffffff;
    border: 1px solid rgba(185,28,28,.10);
    border-radius: 10px;
    padding: 10px 12px 6px;
  }

  .chart-wrap{
    height: 120px;          /* ini yang bikin pendek kayak gambar */
    position: relative;
  }

  /* Biar label bawah chart gak “nabrak” */
  #waveChart{
    width: 100% !important;
    height: 100% !important;
  }
  /* ===== SHINE EFFECT: Export Excel ===== */
  .btn-excel {
    position: relative;
    overflow: hidden;
  }

  /* layer kilap */
  .btn-excel::before {
    content: "";
    position: absolute;
    top: 0;
    left: -120%;
    width: 60%;
    height: 100%;
    background: linear-gradient(
      120deg,
      transparent,
      rgba(255, 255, 255, 0.45),
      transparent
    );
    transition: all 0.6s ease;
  }

  /* saat hover */
  .btn-excel:hover::before {
    left: 120%;
  }

  /* feel klik */
  .btn-excel:hover {
    box-shadow: 0 10px 18px rgba(33, 163, 102, 0.30);
    transform: translateY(-2px);
  }

  .btn-excel:active {
    transform: translateY(0) scale(0.97);
    box-shadow: 0 6px 12px rgba(33, 163, 102, 0.25);
  }

  /* Pagination arrow styling */
  .pagination .page-link i {
    font-size: 0.5rem !important;
    width: 0.5rem !important;
    height: 0.5rem !important;
    transform: scale(0.6);
  }

  .pagination .page-link {
    padding: 0.35rem 0.5rem !important;
    font-size: 0.75rem !important;
  }

  .table-responsive {
    padding-left: 8px;
    padding-right: 4px;
    overflow-x: auto;
    overflow-y: visible !important; /* ✅ FIX */
    padding-bottom: 10px;           /* ✅ FIX biar pagination aman */
  }


  /* kasih ruang untuk kolom pertama */
  .table-analytics th:first-child,
  .table-analytics td:first-child {
    padding-left: 14px !important;
  }

  /* biar header gak nempel */
  .table-analytics thead th {
    white-space: nowrap;
  }

  .card-soft > .card-body {
    padding-left: 1.25rem;
    padding-right: 1.25rem;
  }

  .table-footer{
    padding: 18px 22px 18px !important; 
    overflow: visible !important;
  }

  .table-footer nav{
    margin-left: auto;       /* dorong pagination ke kanan */
    padding-left: 12px;      /* jarak dari teks */
  }
  
  .table-footer .pagination{
    margin-right: 6px;       /* ruang kanan ekstra */
  }

  /* ===== Header Card (Laporan Evaluasi) ===== */
  .header-card{
    background: linear-gradient(180deg, rgba(185,28,28,.06), rgba(255,255,255,1));
    border: 1px solid rgba(185,28,28,.14);
    border-radius: 16px;
    padding: 18px 18px;
    box-shadow: 0 10px 26px rgba(185,28,28,.06);
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    will-change: transform;
  }

  .header-card:hover{
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 18px 40px rgba(185,28,28,.10);
    border-color: rgba(185,28,28,.22);
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

@php
    use Illuminate\Support\Str;
@endphp

<div class="container py-4">

  {{-- HEADER --}}
  <div class="header-card mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
      <div>
        <h1 class="page-title mb-2">Laporan Evaluasi</h1>
        <p class="text-muted mb-0">
          Analisis evaluasi peserta webinar. Klik judul webinar untuk melihat detail.
        </p>
      </div>

      <div class="actions">
        <button class="btn btn-excel d-flex align-items-center gap-1"
                data-bs-toggle="modal"
                data-bs-target="#modalExport">
          <i class="fas fa-file-excel fa-sm"></i>
          <span>Export Excel</span>
        </button>

        <a href="{{ url('/admin/dashboard') }}"
          class="btn btn-ghost d-flex align-items-center gap-1">
          <i class="fas fa-arrow-left fa-sm"></i>
          <span>Kembali</span>
        </a>
      </div>
    </div>
  </div>


  {{-- FILTER --}}
<form method="GET" action="{{ route('admin.laporan.evaluasi') }}">
  <div class="card card-soft mb-4">
    <div class="card-body">
      <div class="row g-3 align-items-end">
        {{-- Pilih Webinar --}}
        <div class="col-md-3">
          <label class="form-label fw-semibold">Pilih Webinar</label>
          <select name="webinar_id" class="form-select">
            <option value="">Semua webinar</option>
            @foreach($allWebinars as $w)
              <option value="{{ $w->id }}"
                {{ request('webinar_id') == $w->id ? 'selected' : '' }}>
                {{ $w->judul }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Tanggal Mulai --}}
        <div class="col-md-3">
          <label class="form-label fw-semibold">Tanggal Mulai</label>
          <input type="date"
                 name="start"
                 class="form-control"
                 value="{{ request('start') }}">
        </div>

        {{-- Tanggal Akhir --}}
        <div class="col-md-3">
          <label class="form-label fw-semibold">Tanggal Akhir</label>
          <input type="date"
                 name="end"
                 class="form-control"
                 value="{{ request('end') }}">
        </div>

        {{-- Actions --}}
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-brand flex-fill">
              Filter
            </button>

            <a href="{{ route('admin.laporan.evaluasi') }}" class="btn btn-ghost flex-fill">
              Reset
            </a>
      </div>
    </div>
  </div>
</form>

  {{-- Wave Chart --}}
  <div class="card card-soft mb-4">
    <div class="card-body wave-card-compact">
      <div class="wave-head-compact">
        <div>
          <h6 class="wave-title mb-1">Tren Rata-rata Evaluasi</h6>
          <p class="wave-sub mb-0">Rata-rata per webinar</p>
        </div>
      </div>

      <div class="wave-shell-compact">
        <div class="chart-wrap">
          <canvas id="waveChart"></canvas>
        </div>
      </div>
    </div>
  </div>


  {{-- TABLE: Ringkasan Evaluasi --}}
  <div class="card card-soft">
    <div class="card-body">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
        <div>
          <h5 class="fw-semibold mb-1">Ringkasan Evaluasi</h5>
          <p class="text-muted small">Detail respons evaluasi untuk setiap webinar</p>
        </div>

        <form method="GET" action="{{ route('admin.laporan.evaluasi') }}">
          {{-- PERTAHANKAN FILTER YANG SUDAH ADA --}}
          <input type="hidden" name="webinar_id" value="{{ request('webinar_id') }}">
          <input type="hidden" name="start" value="{{ request('start') }}">
          <input type="hidden" name="end" value="{{ request('end') }}">

          <select name="sort"
                  class="form-select"
                  style="min-width: 180px;"
                  onchange="this.form.submit()">
            <option value="">Urutkan</option>
            <option value="avg_desc" {{ request('sort') == 'avg_desc' ? 'selected' : '' }}>
              Rata-rata tertinggi
            </option>
            <option value="avg_asc" {{ request('sort') == 'avg_asc' ? 'selected' : '' }}>
              Rata-rata terendah
            </option>
            <option value="respon_desc" {{ request('sort') == 'respon_desc' ? 'selected' : '' }}>
              Respon terbanyak
            </option>
          </select>
        </form>

        </div>
      </div>

      @if($webinars->isEmpty())
        <div class="empty-state">
          <div class="empty-state-icon">
            <i class="fas fa-chart-bar"></i>
          </div>
          <h4 class="empty-state-title">Belum Ada Data Evaluasi</h4>
          <p class="empty-state-description">
            Tidak ada data evaluasi yang tersedia untuk filter yang dipilih.
          </p>
          <button class="btn btn-brand btn-sm" onclick="window.location.href='{{ route('admin.laporan.evaluasi') }}'">
            Reset Filter
          </button>
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-analytics table-hover align-middle">
            <thead class="table-header">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Webinar</th>
                <th style="width: 120px;">Periode</th>
                <th style="width: 120px;">Total Respon</th>
                <th style="width: 140px;">Rata-rata</th>
                <th style="width: 120px;" class="text-center">Detail</th>
              </tr>
            </thead>
            <tbody>
              @forelse($webinars as $index => $webinar)
              <tr>
                <td class="fw-semibold">{{ $index + 1 }}</td>

                <td>
                  <div class="fw-semibold">{{ $webinar->judul }}</div>
                  <div class="subtxt">
                    {{ Str::limit($webinar->deskripsi, 80) }}
                  </div>
                </td>

                <td>
                  <div class="fw-semibold">{{ \Carbon\Carbon::parse($webinar->tanggal)->format('M Y') }}</div>
                  <div class="subtxt">{{ \Carbon\Carbon::parse($webinar->tanggal)->format('d M Y') }}</div>
                </td>

                <td>
                  <span class="chip">
                    <b>{{ $webinar->total_respon ?? 0 }}</b> respon
                  </span>
                </td>

                <td>
                  @php $avg = round($webinar->rata_rating ?? 0, 2); @endphp

                  @if($avg >= 4.5)
                    <span class="score excellent">{{ $avg }}</span>
                  @elseif($avg >= 4)
                    <span class="score good">{{ $avg }}</span>
                  @elseif($avg >= 3)
                    <span class="score">{{ $avg }}</span>
                  @else
                    <span class="score fair">{{ $avg }}</span>
                  @endif
                </td>

                <td class="text-center">
                  <a href="{{ route('admin.laporan.evaluasi.peserta', $webinar->id) }}" class="btn btn-ghost btn-sm">
                    <i class="fas fa-users fa-sm"></i> Peserta
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">
                  <i class="fas fa-inbox fa-lg mb-2"></i>
                  <div>Tidak ada data evaluasi</div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        <div class="table-footer d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-4 pt-3 border-top">
          <div class="text-muted small">
            Menampilkan {{ $webinars->count() }} dari {{ $allWebinars->count() }} webinar
          </div>
          <nav aria-label="pagination">
            <ul class="pagination mb-0">
              <li class="page-item disabled">
                <a class="page-link" href="#"><i class="fas fa-chevron-left fa-xs"></i></a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#"><i class="fas fa-chevron-right fa-xs"></i></a>
              </li>
            </ul>
          </nav>
        </div>
      @endif
    </div>
  </div>

</div>

{{-- Modal: Export Excel --}}
<div class="modal fade" id="modalExport" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Export ke Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        

        @php
          $selectedWebinar = null;
          if (request('webinar_id')) {
            $selectedWebinar = $allWebinars->firstWhere('id', (int) request('webinar_id'));
          }

          $startLabel = request('start') ? \Carbon\Carbon::parse(request('start'))->format('d M Y') : null;
          $endLabel = request('end') ? \Carbon\Carbon::parse(request('end'))->format('d M Y') : null;
        @endphp

        <div class="card-soft p-3 mb-3">
          <div class="small text-muted">Filter saat ini</div>
          <div class="fw-semibold">
            {{ $selectedWebinar ? $selectedWebinar->judul : 'Semua Webinar' }}
          </div>
          <div class="small text-muted">
            @if($startLabel && $endLabel)
              {{ $startLabel }} – {{ $endLabel }}
            @elseif($startLabel)
              Mulai {{ $startLabel }}
            @elseif($endLabel)
              Sampai {{ $endLabel }}
            @else
              Semua tanggal
            @endif
          </div>
        </div>

        <div class="alert alert-light border">
          <div class="d-flex align-items-start">
            <i class="fas fa-info-circle text-primary mt-1 me-2"></i>
            <div class="small">
              File Excel akan mencakup semua data evaluasi, termasuk rating detail dan komentar peserta.
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost" data-bs-dismiss="modal">Batal</button>
        <a href="{{ route('admin.laporan.evaluasi.export', request()->query()) }}" class="btn btn-excel">
          Mulai Export
        </a>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
  (function () {
    const el = document.getElementById('waveChart');
    if (!el) return;

    const labels = @json($chartLabels);
    const dataMain = @json($chartRatings);

    const dataTrend = dataMain.map((v, i, arr) => {
      if (i === 0) return v;
      return ((arr[i - 1] + v) / 2).toFixed(2);
    });

    const ctx = el.getContext('2d');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels,
        datasets: [
          {
            label: 'Rata-rata',
            data: dataMain,
            borderWidth: 2,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: 'rgba(185, 28, 28, 1)',
            pointBorderColor: 'white',
            pointBorderWidth: 1,
            fill: true,
            backgroundColor: 'rgba(185, 28, 28, 0.1)',
            borderColor: 'rgba(185, 28, 28, 0.85)'
          },
          {
            label: 'Tren',
            data: dataTrend,
            borderWidth: 1,
            tension: 0.4,
            pointRadius: 0,
            borderDash: [5, 5],
            fill: false,
            borderColor: 'rgba(185, 28, 28, 0.35)'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { intersect: false, mode: 'index' },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(30, 41, 59, 0.9)',
            titleColor: 'white',
            bodyColor: 'white',
            borderColor: 'rgba(185, 28, 28, 0.5)',
            borderWidth: 1,
            padding: 8,
            cornerRadius: 6,
            callbacks: {
              label: ctx => `Rata-rata: ${ctx.parsed.y.toFixed(2)} / 5`
            }
          }
        },
        scales: {
          y: {
            min: 0,
            max: 5,
            ticks: {
              stepSize: 2,
              color: '#6b7280',
              font: { size: 10 }
            },
            grid: { color: 'rgba(0, 0, 0, 0.06)' }
          },
          x: {
            grid: { display: false },
            ticks: {
              color: '#6b7280',
              font: { size: 10 },
              maxRotation: 0,
              minRotation: 0,
              autoSkip: true,
              maxTicksLimit: 5,
              padding: 6,
              callback: function(value) {
                const label = this.getLabelForValue(value);
                return label.length > 32 ? label.slice(0, 32) + '…' : label;
              }
            }
          }
        }

      }
    });

    document.querySelectorAll('.progress-fill').forEach(bar => {
      const width = bar.style.width;
      bar.style.width = '0';
      setTimeout(() => { bar.style.width = width; }, 300);
    });

  })();
</script>
@endpush

@endsection
