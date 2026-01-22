@extends('layouts.app')

@section('title', 'Laporan Evaluasi')

@push('head')
<style>
  :root{
    --brand:#b91c1c;
    --brand-2:#dc2626;
    --brand-3:#991b1b;

    --bg-page:#f7e8e8;
    --bg-card:#fff5f5;
    --border-soft: rgba(185,28,28,.18);
    --ink:#111827;
    --muted:#6b7280;
  }

  body{ background: var(--bg-page); }

  .page-title{ font-weight:900; letter-spacing:-.2px; color:var(--brand-3); }
  .muted{ color: var(--muted); }
  .rounded-16{ border-radius:16px; }

  .card-soft{
    background: var(--bg-card) !important;
    border: 1px solid var(--border-soft);
    box-shadow:
      0 20px 45px rgba(185,28,28,.08),
      0 6px 16px rgba(185,28,28,.06);
  }

  .btn-brand{
    background: var(--brand);
    color:#fff;
    border:none;
  }
  .btn-brand:hover{ background: var(--brand-2); color:#fff; }

  .btn-ghost{
    border:1px solid rgba(185,28,28,.35);
    background: rgba(255,255,255,.65);
    color: var(--brand);
  }
  .btn-ghost:hover{ background: rgba(185,28,28,.08); color: var(--brand-3); }

  .btn-excel{
    border: 1px solid rgba(46,125,50,.28);
    background: rgba(232,245,233,.85);
    color:#2e7d32;
    font-weight:900;
  }
  .btn-excel:hover{
    background: rgba(232,245,233,1);
    color:#1b5e20;
  }

  .form-control:focus, .form-select:focus{
    border-color: rgba(185,28,28,.55);
    box-shadow: 0 0 0 .25rem rgba(185,28,28,.18);
  }

  .hint{ font-size:.875rem; color: var(--muted); }
  .divider-soft{ height:1px; background: rgba(185,28,28,.14); border-radius:999px; }

  thead tr{ background: rgba(185,28,28,.06); }
  .table td, .table th{ vertical-align: middle; }

  .chip{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 10px;
    border-radius:999px;
    background: rgba(185,28,28,.08);
    border: 1px solid rgba(185,28,28,.14);
    color: var(--brand-3);
    font-weight:900;
    font-size:12px;
    white-space:nowrap;
  }

  .score{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:46px;
    padding:6px 10px;
    border-radius:999px;
    font-weight:1000;
    background: rgba(185,28,28,.10);
    border: 1px solid rgba(185,28,28,.20);
    color: var(--brand-3);
  }

  .score.good{
    background: rgba(46,125,50,.10);
    border-color: rgba(46,125,50,.20);
    color:#2e7d32;
  }

  .score.mid{
    background: rgba(255,193,7,.15);
    border-color: rgba(255,193,7,.25);
    color:#8a6d00;
  }

  /* ====== Clickable Webinar Chip ====== */
  .webinar-link{
    /* ✅ DIUBAH: jadi teks seperti kolom peserta (tanpa tampilan button/pill) */
    display:block;
    padding:0;
    border:none;
    background: transparent;
    border-radius:0;
    color: var(--ink);
    font-weight:900;
    text-decoration:none;
    transition:none;
  }
  .webinar-link:hover{
    /* ✅ DIUBAH: hilangkan efek hover button */
    background: transparent;
    color: var(--ink);
    transform:none;
  }
  .webinar-link .dot{
    /* ✅ DIUBAH: hilangkan dot */
    display:none;
  }
  .subtxt{ font-size:12px; color: var(--muted); font-weight:800; margin-top:6px; }

  /* ====== WAVE CHART ====== */
  .wave-card{
    background: rgba(255,255,255,.70);
    border: 1px solid rgba(185,28,28,.18);
    border-radius: 18px;
    padding: 14px;
    overflow:hidden;
  }
  .wave-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 10px;
    margin-bottom: 10px;
  }
  .wave-title{
    margin:0;
    font-weight:1000;
    color: var(--ink);
    font-size: 14px;
  }
  .wave-sub{
    margin:0;
    color: var(--muted);
    font-weight: 800;
    font-size: 12px;
  }
  .wave-shell{
    background:
      radial-gradient(600px 240px at 80% -10%, rgba(185,28,28,.10), transparent 60%),
      linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,255,255,.65));
    border-radius: 16px;
    border: 1px solid rgba(185,28,28,.12);
    padding: 10px 10px 6px;
  }
  .wave-legend{
    display:flex;
    gap: 10px;
    flex-wrap:wrap;
    margin-top: 10px;
    color: var(--muted);
    font-weight: 800;
    font-size: 12px;
  }
  .wave-dot{
    width:10px;height:10px;border-radius:999px;
    display:inline-block;
    margin-right:6px;
  }
  .wave-note{
    margin-top: 10px;
    font-size: 12px;
    color: var(--muted);
    font-weight: 800;
  }
</style>
@endpush

@section('content')

@php
    use Illuminate\Support\Str;
@endphp

<div class="container py-3">

  {{-- Header --}}
  <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
    <div>
      <h1 class="page-title mb-1">Laporan Evaluasi</h1>
      <div class="muted">
        Mode <b>Semua webinar</b> menampilkan ringkasan per webinar. Klik judul webinar untuk melihat daftar peserta & detail evaluasi (UI saja).
      </div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
      <button class="btn btn-excel rounded-16" data-bs-toggle="modal" data-bs-target="#modalExport">
        Export Excel
      </button>
      <a href="{{ url('/admin/dashboard') }}" class="btn btn-ghost rounded-16">Kembali</a>
    </div>
  </div>

  {{-- Filter --}}
<form method="GET" action="{{ route('admin.laporan.evaluasi') }}">
  <div class="row g-2 align-items-end">

    {{-- PILIH WEBINAR --}}
    <div class="col-md-4">
      <label class="form-label fw-semibold">Pilih Webinar</label>
      <select name="webinar_id" class="form-select rounded-16">
        <option value="">Semua webinar</option>
        @foreach($allWebinars as $w)
          <option value="{{ $w->id }}"
            {{ request('webinar_id') == $w->id ? 'selected' : '' }}>
            {{ $w->judul }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- TANGGAL MULAI --}}
    <div class="col-md-3">
      <label class="form-label fw-semibold">Rentang Tanggal</label>
      <input type="date"
             name="start"
             class="form-control rounded-16"
             value="{{ request('start') }}">
    </div>

    {{-- TANGGAL AKHIR --}}
    <div class="col-md-3">
      <label class="form-label fw-semibold">&nbsp;</label>
      <input type="date"
             name="end"
             class="form-control rounded-16"
             value="{{ request('end') }}">
    </div>

    {{-- BUTTON --}}
    <div class="col-md-2 d-grid">
      <button class="btn btn-brand rounded-16" type="submit">
        Terapkan
      </button>
    </div>

  </div>
</form>


        <div class="col-12">
          <div class="hint mt-2">
            *Ini tampilan UI saja. Pilihan "Semua webinar" di bawah ini adalah contoh tampilan ringkasan.
          </div>
        </div>
      </div>

      <div class="divider-soft my-3"></div>

      {{-- Ringkasan --}}
      <div class="d-flex flex-wrap gap-2">
        <span class="chip">Total Respon: <b>128</b></span>
        <span class="chip">Rata-rata Rating: <b>4.3</b> / 5</span>
        <span class="chip">Mode: <b>Semua Webinar</b></span>
      </div>
    </div>
  </div>

  {{-- Grafik Gelombang --}}
  <div class="card card-soft rounded-16 mb-4">
    <div class="card-body">
      <div class="wave-head">
        <div>
          <p class="wave-title">Grafik Rating (Gelombang)</p>
          <p class="wave-sub">Rata-rata rating per webinar (dummy)</p>
        </div>
        <div class="text-end">
          <span class="chip">Skala: <b>0 – 5</b></span>
        </div>
      </div>

      <div class="wave-card">
        <div class="wave-shell">
          <canvas id="waveChart" height="120"></canvas>
        </div>

        <div class="wave-legend">
          <span><span class="wave-dot" style="background: rgba(185,28,28,.85)"></span> Rata-rata rating</span>
          <span><span class="wave-dot" style="background: rgba(185,28,28,.25)"></span> Garis tren (dummy)</span>
        </div>

        <div class="wave-note">
          *Grafik ini hanya tampilan. Nanti backend menghitung nilai rating asli per webinar.
        </div>
      </div>
    </div>
  </div>

  {{-- TABLE: Ringkasan Semua Webinar (tanpa kolom peserta) --}}
  <div class="card card-soft rounded-16">
    <div class="card-body">
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
        <div class="fw-semibold">Ringkasan Evaluasi (Semua Webinar)</div>

        <div class="d-flex gap-2 flex-wrap">
          <input class="form-control rounded-16" style="max-width:260px;"
                 placeholder="Cari judul webinar...">
          <select class="form-select rounded-16" style="max-width:200px;">
            <option value="">Urutkan</option>
            <option>Rating tertinggi</option>
            <option>Rating terendah</option>
            <option>Total respon terbanyak</option>
            <option>Total respon tersedikit</option>
          </select>
          <button class="btn btn-ghost rounded-16" type="button">Reset</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr class="muted">
              <th style="width:56px;">No</th>
              <th>Webinar</th>
              <th style="width:160px;">Periode</th>
              <th style="width:140px;">Total Respon</th>
              <th style="width:140px;">Rata-rata</th>
              <th style="width:140px;" class="text-end">Detail</th>
            </tr>
          </thead>
          <tbody>
          @forelse($webinars as $index => $webinar)
          <tr>
              {{-- NO --}}
              <td class="fw-semibold">{{ $index + 1 }}</td>

              {{-- WEBINAR --}}
              <td>
                  <div class="fw-semibold">{{ $webinar->judul }}</div>
                  <div class="small muted">
                      Ringkasan: {{ Str::limit($webinar->deskripsi, 80) }}
                  </div>
              </td>

              {{-- PERIODE --}}
              <td>
                  <div class="fw-semibold">
                      {{ \Carbon\Carbon::parse($webinar->tanggal)->format('M Y') }}
                  </div>
                  <div class="small muted">
                      {{ \Carbon\Carbon::parse($webinar->tanggal)->format('d M Y') }}
                  </div>
              </td>

              {{-- TOTAL RESPON --}}
              <td>
                  <span class="chip">
                      <b>{{ $webinar->total_respon ?? 0 }}</b> respon
                  </span>
              </td>

              {{-- RATA-RATA --}}
              <td>
                  @php
                      $avg = round($webinar->rata_rating ?? 0, 1);
                  @endphp

                  @if($avg >= 4)
                      <span class="score good">{{ $avg }}</span>
                  @elseif($avg >= 3)
                      <span class="score mid">{{ $avg }}</span>
                  @else
                      <span class="score">{{ $avg }}</span>
                  @endif
              </td>

              {{-- DETAIL --}}
              <td class="text-end">
                  <a href="{{ route('admin.laporan.evaluasi.peserta', $webinar->id) }}"
                    class="btn btn-ghost rounded-16 btn-sm px-3">
                      Lihat Peserta
                  </a>
              </td>
          </tr>
          @empty
          <tr>
              <td colspan="6" class="text-center muted">
                  Belum ada data evaluasi
              </td>
          </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination dummy --}}
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mt-3">
        <div class="muted small">Menampilkan 1–3 dari 3 webinar</div>
        <nav aria-label="pagination">
          <ul class="pagination mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
          </ul>
        </nav>
      </div>

      <div class="hint mt-2">
        *Klik judul webinar untuk melihat tabel evaluasi berisi peserta (di modal).
      </div>
    </div>
  </div>

</div>

{{-- ==========================================================
  MODAL: EXPORT EXCEL (dummy) (tetap punyamu)
========================================================== --}}
<div class="modal fade" id="modalExport" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Export ke Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="muted">
          Export akan mengikuti filter yang dipilih (webinar & rentang tanggal).
        </div>

        <div class="mt-3 p-3 rounded-16" style="background: rgba(46,125,50,.06); border:1px solid rgba(46,125,50,.14);">
          <div class="small muted">Filter saat ini</div>
          <div class="fw-semibold">Semua Webinar</div>
          <div class="small muted">01 Jan 2026 – 28 Feb 2026</div>
        </div>

        <div class="hint mt-3">
          *Tombol export ini hanya tampilan. Nanti backend yang membuat file Excel.
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
        <a href="{{ route('admin.laporan.evaluasi.export', request()->query()) }}"
        class="btn btn-excel rounded-16">
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

    // ================= REAL DATA FROM BACKEND =================
    const labels = @json($chartLabels);
    const dataMain = @json($chartRatings);

    // OPTIONAL: garis tren sederhana (moving average)
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
            label: 'Rata-rata rating',
            data: dataMain,
            borderWidth: 3,
            tension: 0.45,
            pointRadius: 4,
            fill: true,
            borderColor: 'rgba(185,28,28,.85)',
            backgroundColor: 'rgba(185,28,28,.10)'
          },
          {
            label: 'Tren',
            data: dataTrend,
            borderWidth: 2,
            tension: 0.45,
            pointRadius: 0,
            borderDash: [6, 6],
            fill: false,
            borderColor: 'rgba(185,28,28,.35)'
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
            callbacks: {
              label: ctx => `Rating: ${ctx.parsed.y} / 5`
            }
          }
        },
        scales: {
          y: {
            min: 0,
            max: 5,
            ticks: { stepSize: 1 }
          }
        }
      }
    });
  })();
</script>

@endpush

@endsection