@extends('layouts.app')

@section('title', 'Manajemen Webinar')

@push('head')
<style>
  :root{
    --brand:#b91c1c;
    --brand-2:#dc2626;
    --brand-3:#991b1b;

    --bg-page:#f7e8e8;      /* background halaman */
    --bg-card:#fff5f5;      /* background card */
    --border-soft: rgba(185,28,28,.18);
    --text:#1f2937;
  }

  /* =========================
     BACKGROUND HALAMAN
  ========================= */
  body{
    background: var(--bg-page);
  }

  /* =========================
     CARD
  ========================= */
  .card,
  .card-soft{
    background: var(--bg-card) !important;
    border: 1px solid var(--border-soft);
    box-shadow:
      0 20px 45px rgba(185,28,28,.08),
      0 6px 16px rgba(185,28,28,.06);
  }

  /* =========================
     TABLE
  ========================= */
  table{
    background: transparent;
  }

  thead tr{
    background: rgba(185,28,28,.06);
  }

  tbody tr{
    background: rgba(255,255,255,.55);
  }

  tbody tr:hover{
    background: rgba(185,28,28,.05);
  }

  /* =========================
     BUTTON
  ========================= */
  .btn-brand{
    background: var(--brand);
    color:#fff;
    border:none;
  }
  .btn-brand:hover{
    background: var(--brand-2);
  }

  .btn-ghost{
    border:1px solid rgba(185,28,28,.35);
    background: rgba(255,255,255,.65);
    color: var(--brand);
  }
  .btn-ghost:hover{
    background: rgba(185,28,28,.08);
    color: var(--brand-3);
  }

  /* =========================
     BADGE
  ========================= */
  .badge-pill{
    border-radius:999px;
    font-weight:600;
  }

  .badge-published{
    background: rgba(185,28,28,.15);
    color: var(--brand-3);
    border: 1px solid rgba(185,28,28,.35);
  }

  .badge-draft{
    background: rgba(255,255,255,.7);
    color:#6b7280;
    border:1px solid rgba(185,28,28,.2);
  }

  /* =========================
     FORM
  ========================= */
  .form-control,
  .form-select{
    background: rgba(255,255,255,.75);
    border-color: rgba(185,28,28,.25);
  }

  .form-control:focus,
  .form-select:focus{
    border-color: var(--brand);
    box-shadow: 0 0 0 .25rem rgba(185,28,28,.18);
  }

  /* =========================
     PAGINATION
  ========================= */
  .pagination .page-link{
    color: var(--brand);
    background: rgba(255,255,255,.7);
    border-color: rgba(185,28,28,.25);
  }

  .pagination .page-item.active .page-link{
    background: var(--brand);
    border-color: var(--brand);
    color:#fff;
  }

  /* =========================
     MODAL
  ========================= */
  .modal-content{
    background: var(--bg-card);
    border: 1px solid rgba(185,28,28,.25);
  }

  .modal-header{
    border-bottom: 1px solid rgba(185,28,28,.2);
  }

  .modal-title{
    color: var(--brand-3);
  }

  /* =========================
     TEXT
  ========================= */
  .page-title{
    font-weight:800;
    color: var(--brand-3);
  }

  .muted{
    color:#6b7280;
  }

.badge-published{
  background: #e8f5e9 !important;   /* hijau lembut */
  color: #2e7d32 !important;        /* teks hijau */
  border: 1px solid #a5d6a7 !important;
}

.badge-draft{
  background: #f3f4f6 !important;   /* abu-abu lembut */
  color: #374151 !important;
  border: 1px solid #e5e7eb !important;
}

 .modal-body {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
  }

</style>
@endpush

@section('content')
<div class="container">

  {{-- Header --}}
  <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
    <div>
      <h1 class="page-title mb-1">Manajemen Webinar</h1>
      <div class="muted">
        Kelola judul, deskripsi, tanggal, status publish, dan detail webinar untuk ditampilkan di landing page.
      </div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
      <button class="btn btn-brand rounded-16" data-bs-toggle="modal" data-bs-target="#modalCreate">
        + Tambah Webinar
      </button>

      {{-- ✅ Tombol untuk buka modal Kode B --}}
      <a href="{{ url('/admin/dashboard') }}" class="btn btn-ghost rounded-16">Kembali</a>
    </div>
  </div>
  
{{-- Toolbar --}}
<div class="card card-shadow rounded-16 border-0 card-soft mb-4">
  <div class="card-body">

    <form method="GET" action="{{ route('admin.webinars.index') }}">
      <div class="row g-2 align-items-end">

        {{-- SEARCH --}}
        <div class="col-md-5">
          <label class="form-label fw-semibold">Cari webinar</label>
          <input
            type="text"
            name="search"
            class="form-control rounded-16"
            placeholder="Cari judul / kata kunci..."
            value="{{ request('search') }}"
          >
        </div>

        {{-- STATUS --}}
        <div class="col-md-3">
          <label class="form-label fw-semibold">Status</label>
          <select name="status" class="form-select rounded-16">
            <option value="">Semua</option>
            <option value="published" {{ request('status')=='published'?'selected':'' }}>
              Published
            </option>
            <option value="draft" {{ request('status')=='draft'?'selected':'' }}>
              Draft
            </option>
          </select>
        </div>

        {{-- SORT --}}
        <div class="col-md-3">
          <label class="form-label fw-semibold">Urutkan</label>
          <select name="sort" class="form-select rounded-16">
            <option value="tanggal_terdekat" {{ request('sort')=='tanggal_terdekat'?'selected':'' }}>
              Tanggal terdekat
            </option>
            <option value="tanggal_terjauh" {{ request('sort')=='tanggal_terjauh'?'selected':'' }}>
              Tanggal terjauh
            </option>
            <option value="terbaru" {{ request('sort')=='terbaru'?'selected':'' }}>
              Terbaru dibuat
            </option>
            <option value="terlama" {{ request('sort')=='terlama'?'selected':'' }}>
              Terlama dibuat
            </option>
          </select>
        </div>

        {{-- RESET --}}
        <div class="col-md-1 d-grid">
          <a
            href="{{ route('admin.webinars.index') }}"
            class="btn btn-ghost rounded-16"
          >
            Reset
          </a>
        </div>

      </div>
    </form>

  </div>
</div>


  {{-- Table List --}}
  <div class="card card-shadow rounded-16 border-0 card-soft">
    <div class="card-body">

      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="fw-semibold">Daftar Webinar</div>
        <div class="muted small">Menampilkan 1–5 dari 12 data</div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr class="muted">
              <th style="width:56px;">No</th>
              <th>Webinar</th>
              <th style="width:170px;">Tanggal</th>
              <th style="width:140px;">Status</th>
              <th style="width:280px;" class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($webinars as $index => $webinar)
            <tr>
            <td class="fw-semibold">
                {{ $webinars->firstItem() + $index }}
            </td>

            <td>
                <div class="fw-semibold">{{ $webinar->judul }}</div>
                <div class="small muted text-truncate" style="max-width:560px;">
                {{ $webinar->deskripsi }}
                </div>
            </td>

            <td>
                <div class="fw-semibold">
                {{ \Carbon\Carbon::parse($webinar->tanggal)->translatedFormat('d M Y') }}
                </div>
            </td>

            <td>
                @if($webinar->status === 'published')
                <span class="badge badge-pill badge-published">Published</span>
                @else
                <span class="badge badge-pill badge-draft">Draft</span>
                @endif
            </td>
            <td class="text-end">
            <div class="d-inline-flex gap-2">

                <button
                class="btn btn-ghost rounded-16 btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalDetail{{ $webinar->id }}"
                >
                Detail
                </button>

                <button
                class="btn btn-ghost rounded-16 btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalEdit{{ $webinar->id }}"
                >
                Edit
                </button>

                <button
                class="btn btn-outline-danger rounded-16 btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalDelete{{ $webinar->id }}"
                >
                Hapus
                </button>

            </div>
            </td>

            
            </tr>
            @empty
            <tr>
            <td colspan="5" class="text-center muted py-4">
                Belum ada data webinar
            </td>
            </tr>
            @endforelse
            </tbody>
        </table>
      </div>

        <div class="d-flex justify-content-end mt-3">
        {{ $webinars->links() }}
        </div>


    </div>
  </div>

</div>

{{-- =========================
    MODAL: CREATE
========================= --}}
<div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Tambah Webinar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form
        method="POST"
        action="{{ route('admin.webinars.store') }}"
        enctype="multipart/form-data"
      >
        @csrf

        <div class="modal-body">
          <div class="row g-4">

            {{-- FORM --}}
            <div class="col-lg-7">
              <div class="card card-soft">
                <div class="card-body">

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Webinar</label>
                    <input type="text" name="judul" class="form-control rounded-16" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control rounded-16" rows="4" required></textarea>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Tanggal</label>
                      <input type="date" name="tanggal" class="form-control rounded-16" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Waktu</label>
                      <input type="time" name="waktu" class="form-control rounded-16">
                    </div>
                  </div>

                  <div class="row g-3 mt-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Narasumber</label>
                      <input type="text" name="narasumber" class="form-control rounded-16">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Media</label>
                      <input type="text" name="media" class="form-control rounded-16">
                    </div>
                  </div>

                  <hr class="my-4">

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Poster</label>
                    <input type="file" name="poster" class="form-control rounded-16">
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Link Absensi</label>
                      <input type="text" name="link_absensi" class="form-control rounded-16">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Link Detail</label>
                      <input type="text" name="link_detail" class="form-control rounded-16">
                    </div>
                  </div>

                  <div class="mt-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select rounded-16">
                      <option value="draft">Draft</option>
                      <option value="published">Published</option>
                    </select>
                  </div>

                </div>
              </div>
            </div>

            {{-- PREVIEW --}}
            <div class="col-lg-5">
              <div class="card card-soft">
                <div class="card-body text-muted text-center">
                  Preview akan tampil di landing page
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-brand rounded-16">Simpan</button>
        </div>

      </form>
    </div>
  </div>
</div>

{{-- =========================
    MODAL: EDIT
========================= --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Edit Webinar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form>
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Judul</label>
              <input type="text" class="form-control rounded-16" value="Webinar Hukum & Etika Digital">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Deskripsi</label>
              <textarea rows="4" class="form-control rounded-16">Pembahasan regulasi, etika, dan praktik terbaik keamanan data dalam pelayanan publik.</textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Tanggal</label>
              <input type="date" class="form-control rounded-16" value="2026-01-20">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Waktu</label>
              <input type="time" class="form-control rounded-16" value="09:00">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Status</label>
              <select class="form-select rounded-16">
                <option value="published" selected>Published (tampil di landing)</option>
                <option value="draft">Draft (belum tampil)</option>
              </select>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-brand rounded-16" type="button">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>

{{-- =========================
    MODAL: DETAIL
========================= --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Detail Webinar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-2">
          <div class="muted small">Judul</div>
          <div class="fw-semibold">Webinar Hukum & Etika Digital</div>
        </div>

        <div class="mb-2">
          <div class="muted small">Tanggal & Waktu</div>
          <div class="fw-semibold">20 Jan 2026 • 09:00 WIB</div>
        </div>

        <div class="mb-2">
          <div class="muted small">Status</div>
          <span class="badge badge-pill badge-published">Published</span>
        </div>

        <div class="mt-3">
          <div class="muted small">Deskripsi</div>
          <div class="mt-1">
            Pembahasan regulasi, etika, dan praktik terbaik keamanan data dalam pelayanan publik.
          </div>
        </div>

        <hr class="my-4">

        <div class="d-flex align-items-center justify-content-between">
          <div class="muted small">Preview di landing page</div>
          <a href="{{ url('/#webinar') }}" class="btn btn-ghost rounded-16 btn-sm">Buka Section Webinar</a>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- =========================
    MODAL: PUBLISH / UNPUBLISH
========================= --}}
<div class="modal fade" id="modalPublish" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Ubah Status Publish</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="muted">Pilih status untuk webinar ini:</div>

        <div class="mt-3 d-grid gap-2">
          <button type="button" class="btn btn-brand rounded-16">Publish (tampilkan di landing)</button>
          <button type="button" class="btn btn-ghost rounded-16">Jadikan Draft (sembunyikan dari landing)</button>
        </div>

        <div class="form-hint mt-3">
          *Tombol ini hanya tampilan. Nanti backend akan mengubah field status.
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

{{-- =========================
    MODAL: DELETE
========================= --}}
<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-danger">Hapus Webinar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div>Yakin mau menghapus webinar ini?</div>
        <div class="muted small mt-1">
          Data yang dihapus tidak dapat dikembalikan. (Ini hanya tampilan konfirmasi.)
        </div>

        <div class="mt-3 p-3 rounded-16" style="background: rgba(185,28,28,.06); border: 1px solid rgba(185,28,28,.12);">
          <div class="muted small">Webinar</div>
          <div class="fw-semibold">Webinar Hukum & Etika Digital</div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-outline-danger rounded-16" type="button">Ya, Hapus</button>
      </div>
    </div>
  </div>
</div>

{{-- ==========================================================
    ✅ MODAL TAMBAHAN (Kode B): EDIT KONTEN "WEBINAR TERBARU"
    Tujuan: ngedit bagian yang tampil di landing page (foto kedua)
=========================================================== --}}
<div class="modal fade" id="modalEditWebinarTerbaru" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Edit Konten “Webinar Terbaru” (Landing Page)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-4">
          {{-- Form --}}
          <div class="col-lg-7">
            <div class="card card-shadow rounded-16 border-0 card-soft">
              <div class="card-body">
                <form>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Webinar</label>
                    <input type="text" class="form-control rounded-16" value="Webinar: Penguatan Literasi Hukum">
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea class="form-control rounded-16" rows="4">Webinar membahas strategi peningkatan literasi hukum serta implementasi kebijakan di lingkungan kerja.</textarea>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Tanggal</label>
                      <input type="date" class="form-control rounded-16" value="2026-02-20">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label fw-semibold">Mulai</label>
                      <input type="time" class="form-control rounded-16" value="09:00">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label fw-semibold">Selesai</label>
                      <input type="time" class="form-control rounded-16" value="11:30">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Narasumber</label>
                      <input type="text" class="form-control rounded-16" value="(Nama Narasumber)">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Media</label>
                      <input type="text" class="form-control rounded-16" value="Zoom Meeting">
                    </div>
                  </div>

                  <hr class="my-4">

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Poster</label>
                    <input type="file" class="form-control rounded-16">
                    <div class="small text-muted mt-1">
                      *Tampilan saja. Nanti backend yang handle upload & simpan path file.
                    </div>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Link Tombol “Isi Absensi”</label>
                      <input type="text" class="form-control rounded-16" placeholder="contoh: /absensi atau https://...">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Link Tombol “Lihat Detail”</label>
                      <input type="text" class="form-control rounded-16" placeholder="contoh: /webinar/slug atau https://...">
                    </div>
                  </div>

                  <div class="small text-muted mt-3">
                    *Ini form UI saja. Backend nanti mengatur update data dan menampilkan hanya yang statusnya Published.
                  </div>
                </form>
              </div>
            </div>
          </div>

          {{-- Preview --}}
          <div class="col-lg-5">
            <div class="card card-shadow rounded-16 border-0 card-soft">
              <div class="card-body">
                <div class="fw-bold mb-2">Preview (Statis)</div>

                <div class="rounded-16 overflow-hidden border mb-3" style="background:#fff;">
                  <img
                    src="{{ asset('images/poster-contoh.jpg') }}"
                    class="w-100"
                    style="aspect-ratio:4/5; object-fit:cover;"
                    alt="Preview Poster"
                  >
                </div>

                <div class="fw-bold fs-5">Webinar: Penguatan Literasi Hukum</div>
                <div class="text-muted mt-2">
                  Webinar membahas strategi peningkatan literasi hukum serta implementasi kebijakan di lingkungan kerja.
                </div>

                <div class="row g-2 mt-3">
                  <div class="col-6">
                    <div class="small text-muted">Tanggal</div>
                    <div class="fw-semibold">20 Februari 2026</div>
                  </div>
                  <div class="col-6">
                    <div class="small text-muted">Waktu</div>
                    <div class="fw-semibold">09.00 – 11.30 WIB</div>
                  </div>
                  <div class="col-6">
                    <div class="small text-muted">Narasumber</div>
                    <div class="fw-semibold">(Nama Narasumber)</div>
                  </div>
                  <div class="col-6">
                    <div class="small text-muted">Media</div>
                    <div class="fw-semibold">Zoom Meeting</div>
                  </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                  <button type="button" class="btn btn-brand rounded-16 flex-grow-1">Isi Absensi</button>
                  <button type="button" class="btn btn-ghost rounded-16 flex-grow-1">Lihat Detail</button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-brand rounded-16" type="button">Simpan</button>
      </div>
    </div>
  </div>
</div>

@foreach ($webinars as $webinar)
<div class="modal fade" id="modalDetail{{ $webinar->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-16">

      <div class="modal-header">
        <h5 class="modal-title fw-bold">Detail Webinar</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p><strong>Judul:</strong> {{ $webinar->judul }}</p>
        <p><strong>Deskripsi:</strong><br>{{ $webinar->deskripsi }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($webinar->tanggal)->translatedFormat('d M Y') }}</p>
        <p><strong>Waktu:</strong> {{ $webinar->waktu ?? '-' }}</p>
        <p><strong>Narasumber:</strong> {{ $webinar->narasumber ?? '-' }}</p>
        <p><strong>Media:</strong> {{ $webinar->media ?? '-' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($webinar->status) }}</p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>
@endforeach

@foreach ($webinars as $webinar)
<div class="modal fade" id="modalEdit{{ $webinar->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">

      <form method="POST" action="{{ route('admin.webinars.update', $webinar) }}">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold">Edit Webinar</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input class="form-control mb-2" name="judul" value="{{ $webinar->judul }}" required>
          <textarea class="form-control mb-2" name="deskripsi" rows="3" required>{{ $webinar->deskripsi }}</textarea>
          <input type="date" class="form-control mb-2" name="tanggal" value="{{ $webinar->tanggal }}">
          <input type="time" class="form-control mb-2" name="waktu" value="{{ $webinar->waktu }}">
          <input class="form-control mb-2" name="narasumber" value="{{ $webinar->narasumber }}">
          <input class="form-control mb-2" name="media" value="{{ $webinar->media }}">

          <select name="status" class="form-select">
            <option value="draft" @selected($webinar->status=='draft')>Draft</option>
            <option value="published" @selected($webinar->status=='published')>Published</option>
          </select>
        </div>

        <div class="modal-footer">
          <button class="btn btn-ghost" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-brand" type="submit">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>
@endforeach

@foreach ($webinars as $webinar)
<div class="modal fade" id="modalDelete{{ $webinar->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-16">

      <form method="POST" action="{{ route('admin.webinars.destroy', $webinar) }}">
        @csrf
        @method('DELETE')

        <div class="modal-header">
          <h5 class="modal-title text-danger fw-bold">Hapus Webinar</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          Yakin mau menghapus:
          <strong>{{ $webinar->judul }}</strong> ?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-outline-danger" type="submit">Ya, Hapus</button>
        </div>
      </form>

    </div>
  </div>
</div>
@endforeach

@endsection