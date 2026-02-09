@extends('layouts.app')

@section('title', 'Manajemen Webinar')

@push('head')
<style>
  :root {
    --brand: #b91c1c;
    --brand-2: #dc2626;
    --brand-3: #991b1b;
    --brand-light: #fee2e2;
    --bg-page: #fafafa;
    --bg-card: #ffffff;
    --border-soft: rgba(185, 28, 28, 0.12);
    --text-dark: #1f2937;
    --text-muted: #6b7280;
  }

  body { 
    background: var(--bg-page); 
    font-family: 'Inter', -apple-system, sans-serif;
  }

  /* =========================
     TYPOGRAPHY
  ========================= */
  .page-title {
    font-weight: 900;
    letter-spacing: -0.025em;
    color: var(--brand-3);
    font-size: 1.75rem;
    line-height: 1.2;
  }

  .page-subtitle {
    color: var(--text-muted);
    font-size: 0.875rem;
    line-height: 1.5;
  }

  .section-title {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 1.125rem;
    margin-bottom: 1rem;
  }

  /* =========================
     CARD & CONTAINERS
  ========================= */
  .card-soft {
    background: var(--bg-card) !important;
    border: 1px solid var(--border-soft);
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(185, 28, 28, 0.05);
    transition: all 0.2s ease;
  }

  .card-soft:hover {
    box-shadow: 0 4px 16px rgba(185, 28, 28, 0.08);
  }

  .card-header {
    border-bottom: 1px solid var(--border-soft);
    background: rgba(185, 28, 28, 0.02);
  }

  /* =========================
     BUTTONS
  ========================= */
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem 1.25rem;
    font-weight: 500;
    border-radius: 8px;
    border: 1px solid transparent;
    transition: all 0.2s ease;
    font-size: 0.875rem;
    line-height: 1.5;
  }

  .btn-brand {
    background: var(--brand);
    color: white;
  }

  .btn-brand:hover {
    background: var(--brand-2);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(185, 28, 28, 0.2);
  }

  .btn-ghost {
    border: 1px solid rgba(185, 28, 28, 0.2);
    background: white;
    color: var(--brand);
  }

  .btn-ghost:hover {
    background: rgba(185, 28, 28, 0.05);
    border-color: var(--brand);
  }

  .btn-outline-danger {
    border: 1px solid rgba(220, 38, 38, 0.3);
    background: white;
    color: #dc2626;
  }

  .btn-outline-danger:hover {
    background: #fee2e2;
    border-color: #dc2626;
  }

  .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
  }

  .btn-group {
    display: inline-flex;
    gap: 0.5rem;
  }

  /* =========================
     BADGES
  ========================= */
  .badge-pill {
    border-radius: 50px;
    padding: 0.25rem 0.75rem;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    line-height: 1;
  }

  .badge-published {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.2);
  }

  .badge-draft {
    background: rgba(156, 163, 175, 0.1);
    color: #6b7280;
    border: 1px solid rgba(156, 163, 175, 0.2);
  }

  .badge-upcoming {
    background: rgba(37, 99, 235, 0.1);
    color: #2563eb;
    border: 1px solid rgba(37, 99, 235, 0.2);
  }

  .badge-past {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
    border: 1px solid rgba(107, 114, 128, 0.2);
  }

  /* =========================
     FORM CONTROLS
  ========================= */
  .form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    background: white;
    transition: all 0.2s ease;
  }

  .form-control:focus, .form-select:focus {
    border-color: var(--brand);
    box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
    outline: none;
  }

  .form-label {
    font-weight: 500;
    color: var(--text-dark);
    font-size: 0.875rem;
    margin-bottom: 0.375rem;
    display: block;
  }

  /* =========================
     TABLE STYLING
  ========================= */
  .table-container {
    border-radius: 8px;
    border: 1px solid var(--border-soft);
    overflow: hidden;
  }

  .table {
    margin: 0;
    min-width: 1000px;
  }

  .table thead {
    background: rgba(185, 28, 28, 0.04);
  }

  .table th {
    font-weight: 600;
    color: var(--brand-3);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.875rem 1rem;
    border-bottom: 1px solid var(--border-soft);
    white-space: nowrap;
  }

  .table td {
    padding: 1rem;
    border-bottom: 1px solid rgba(185, 28, 28, 0.08);
    vertical-align: middle;
    font-size: 0.875rem;
  }

  .table tbody tr:last-child td {
    border-bottom: none;
  }

  .table tbody tr {
    transition: background-color 0.15s ease;
  }

  .table tbody tr:hover {
    background: rgba(185, 28, 28, 0.03);
  }

  /* =========================
     UTILITY CLASSES
  ========================= */
  .line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .rounded-8 {
    border-radius: 8px;
  }

  .object-fit-cover {
    object-fit: cover;
  }

  .flex-shrink-0 {
    flex-shrink: 0;
  }

  .flex-grow-1 {
    flex-grow: 1;
  }

  .text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .text-muted {
    color: var(--text-muted);
  }

  .small {
    font-size: 0.75rem;
  }

  .empty-state {
    padding: 3rem 1rem;
    text-align: center;
  }

  .empty-state-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    background: var(--brand-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brand);
  }

  .empty-state-title {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
  }

  .empty-state-description {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
    max-width: 20rem;
    margin-left: auto;
    margin-right: auto;
  }

  /* =========================
     WEBINAR THUMBNAIL STYLES
  ========================= */
  .webinar-thumbnail {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    background: var(--brand-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brand);
    flex-shrink: 0;
  }

  .webinar-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .webinar-info {
    flex: 1;
    min-width: 0;
  }

  .webinar-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.5rem;
  }

  .meta-item {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--text-muted);
    background: rgba(185, 28, 28, 0.05);
    padding: 0.125rem 0.5rem;
    border-radius: 4px;
  }

  .meta-item svg {
    width: 12px;
    height: 12px;
  }

  /* =========================
     MODALS
  ========================= */
  .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  }

  .modal-header {
    border-bottom: 1px solid var(--border-soft);
    padding: 1.25rem 1.5rem;
  }

  .modal-title {
    font-weight: 700;
    color: var(--text-dark);
    font-size: 1.25rem;
    margin: 0;
  }

  /* =========================
   MODALS (FIX: tidak kepotong)
  ========================= */
  .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
  }

  .modal-header {
    border-bottom: 1px solid var(--border-soft);
    padding: 1.25rem 1.5rem;
  }

  .modal-title {
    font-weight: 700;
    color: var(--text-dark);
    font-size: 1.25rem;
    margin: 0;
  }

  /* ✅ FIX UTAMA: jangan pakai max-height fixed, biarkan bootstrap yang handle scroll */
  .modal-body {
    padding: 1.5rem;
    max-height: none;
    overflow: visible;
  }

  /* ✅ Footer selalu kelihatan (tidak ketutup) */
  .modal-footer {
    border-top: 1px solid var(--border-soft);
    padding: 1rem 1.5rem;
    background: #fff;

    position: sticky;
    bottom: 0;
    z-index: 3;
  }
  /* =========================
    PAGINATION (FIX: Laravel links)
  ========================= */
  .pagination-wrap nav {
    margin: 0;
  }

  .pagination-wrap .pagination {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
  }

    .pagination-wrap .page-link{
    padding: .35rem .6rem !important;
    width: auto !important;
    height: auto !important;
    font-size: .85rem;
  }

  .pagination-wrap .page-item.active .page-link {
    background: var(--brand);
    color: #fff;
    border-color: var(--brand);
  }

  .pagination-wrap .page-link:hover {
    background: rgba(185, 28, 28, 0.05);
  }

  /* biar disabled ga “gede” */
  .pagination-wrap .page-item.disabled .page-link {
    opacity: .5;
  }


  /* =========================
     RESPONSIVE
  ========================= */
  @media (max-width: 768px) {
    .container {
      padding: 1rem;
    }
    
    .page-title {
      font-size: 1.5rem;
    }
    
    .table-responsive {
      border-radius: 8px;
      border: 1px solid var(--border-soft);
    }
    
    .btn-group {
      flex-direction: column;
      width: 100%;
    }
    
    .modal-body {
      max-height: 60vh;
    }

    .webinar-thumbnail {
      width: 60px;
      height: 60px;
    }

    .btn-sm span {
      display: none;
    }

    .webinar-meta {
      flex-direction: column;
      gap: 0.25rem;
    }
  }
  /* ===== MODAL STYLE KODE B (SCOPED) ===== */
  .modal-b .modal-content{
    background: var(--bg-card);
    border: 1px solid rgba(185,28,28,.25);
    border-radius: 16px;
    box-shadow:
      0 20px 45px rgba(185,28,28,.08),
      0 6px 16px rgba(185,28,28,.06);
  }

  .modal-b .modal-header{
    border-bottom: 1px solid rgba(185,28,28,.2);
  }

  .modal-b .modal-title{
    color: var(--brand-3);
  }

  .modal-b .modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
  }

  .modal-b .modal-footer{
    border-top: 1px solid rgba(185,28,28,.2);
    background: #fff;
  }

  .rounded-16{
    border-radius:16px !important;
  }
  /* ==== KECILIN CARD DI DALAM MODAL-B ==== */
  .modal-b .modal-dialog{
    --bs-modal-padding: 0.75rem;      /* padding default bootstrap modal */
  }

  .modal-b .modal-header{
    padding: .9rem 1.25rem;
  }

  .modal-b .modal-body{
    padding: 1rem 1.25rem;
  }

  /* bikin card di modal lebih tipis */
  .modal-b .card.card-soft{
    border-radius: 12px !important;
    box-shadow: 0 10px 25px rgba(185,28,28,.06), 0 4px 12px rgba(185,28,28,.05);
  }

  .modal-b .card.card-soft .card-body{
    padding: 1rem !important;   /* sebelumnya besar */
  }

  /* input biar lebih compact */
  .modal-b .form-control,
  .modal-b .form-select{
    padding: .45rem .75rem;
    border-radius: 12px; /* lebih kecil dari 16 */
  }

  .modal-b textarea.form-control{
    min-height: 110px;  /* biar ga tinggi banget */
  }

  /* kalau masih ada element icon yg kebaca sebagai span, amanin juga */
  .pagination-wrap .page-link span[aria-hidden="true"] {
    display: none;
  }

  .pagination-wrap .pagination .page-link{
    padding: 0.35rem 0.5rem;
    font-size: 0.75rem !;
    line-height: 1.2;
  }
  /* =========================
    PAGINATION (BLUE STYLE like Laporan Evaluasi)
  ========================= */
  .pagination-wrap .page-link {
    color: #0d6efd !important;            /* biru bootstrap */
    border-color: #dee2e6 !important;
  }

  .pagination-wrap .page-link:hover {
    background-color: #e7f1ff !important;
    color: #0a58ca !important;
  }

  .pagination-wrap .page-item.active .page-link {
    background-color: #0d6efd !important; /* biru */
    border-color: #0d6efd !important;
    color: #fff !important;
  }

  .pagination-wrap .page-item.disabled .page-link {
    color: #adb5bd !important;
    background-color: transparent !important;
  }
  
  .btn-brand {
    border-radius: 10px;
  }

  .btn-ghost {
    border-radius: 10px;
  }

</style>
@endpush

@section('content')
<div class="container py-4">

  {{-- HEADER --}}
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
    <div>
      <h1 class="page-title mb-2">Manajemen Webinar</h1>
      <p class="page-subtitle">
        Kelola judul, deskripsi, tanggal, status publish, dan detail webinar untuk ditampilkan di landing page.
      </p>
    </div>
    
    <div class="d-flex gap-2">
      <button class="btn btn-brand d-flex align-items-center gap-2" 
              data-bs-toggle="modal" 
              data-bs-target="#modalCreate">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
        <span>Tambah Webinar</span>
      </button>
      <a href="{{ url('/admin/dashboard') }}" 
         class="btn btn-ghost d-flex align-items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
        </svg>
        <span>Kembali</span>
      </a>
    </div>
  </div>

  {{-- FILTER --}}
  <div class="card card-soft mb-4">
    <div class="card-body">
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-3 d-flex align-items-center gap-2" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </svg>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
      </div>
      @endif

      <form method="GET" action="{{ route('admin.webinars.index') }}">
        <div class="row g-2 align-items-end">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Cari webinar</label>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Cari judul, deskripsi, atau narasumber...">
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select">
              <option value="">Semua Status</option>
              <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
              <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Urutkan</label>
            <select name="sort" class="form-select">
              <option value="tanggal_terdekat" {{ request('sort') == 'tanggal_terdekat' ? 'selected' : '' }}>Tanggal Terdekat</option>
              <option value="tanggal_terjauh" {{ request('sort') == 'tanggal_terjauh' ? 'selected' : '' }}>Tanggal Terjauh</option>
              <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru Dibuat</option>
              <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama Dibuat</option>
           </select>
          </div>

          <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-brand flex-fill">
              Filter
            </button>

            <a href="{{ route('admin.webinars.index') }}" class="btn btn-ghost flex-fill">
              Reset
            </a>
          </div>

        </div>
      </form>
    </div>
  </div>

  {{-- TABLE --}}
  <div class="card card-soft">
    <div class="card-body p-0">
      @if($webinars->count() > 0)
        <div class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th style="width: 60px;">No</th>
                <th style="min-width: 400px;">Webinar</th>
                <th style="width: 120px;">Tanggal</th>
                <th style="width: 120px;">Status</th>
                <th style="width: 200px;" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($webinars as $index => $webinar)
                <tr>
                  <td class="fw-semibold text-muted text-center">
                    {{ $webinars->firstItem() + $index }}
                  </td>
                  
                  <td>
                    <div class="d-flex align-items-start gap-3">
                      {{-- Thumbnail Poster --}}
                      <div class="webinar-thumbnail">
                        @if($webinar->poster)
                          <img src="{{ $webinar->poster ? asset('storage/' . $webinar->poster) : 'https://via.placeholder.com/80x80/FFE2E2/991B1B?text=' . urlencode(substr($webinar->judul, 0, 2)) }}"
                               alt="Poster {{ $webinar->judul }}"
                               onerror="this.src='https://via.placeholder.com/80x80/FFE2E2/991B1B?text={{ urlencode(substr($webinar->judul, 0, 2)) }}'">

                        @else
                          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.5 0A2.5 2.5 0 0 0 0 2.5v9c0 .818.393 1.544 1 2v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h6v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1c.607-.456 1-1.182 1-2v-9A2.5 2.5 0 0 0 13.5 0h-11zM1 2.5A1.5 1.5 0 0 1 2.5 1h11A1.5 1.5 0 0 1 15 2.5v9a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 11.5v-9z"/>
                          </svg>
                        @endif
                      </div>
                      
                      {{-- Info Webinar --}}
                      <div class="webinar-info">
                        <h6 class="fw-semibold text-dark mb-1 line-clamp-2">
                          {{ $webinar->judul }}
                        </h6>
                        
                        <p class="text-muted small mb-2 line-clamp-2">
                          {{ Str::limit($webinar->deskripsi, 120) }}
                        </p>
                        
                        {{-- Meta Info --}}
                        <div class="webinar-meta">
                          @if($webinar->narasumber)
                            <div class="meta-item">
                              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                              </svg>
                              <span>{{ Str::limit($webinar->narasumber, 20) }}</span>
                            </div>
                          @endif
                          
                          @if($webinar->media)
                            <div class="meta-item">
                              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M2.5 0A2.5 2.5 0 0 0 0 2.5v9c0 .818.393 1.544 1 2v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h6v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1c.607-.456 1-1.182 1-2v-9A2.5 2.5 0 0 0 13.5 0h-11zM1 2.5A1.5 1.5 0 0 1 2.5 1h11A1.5 1.5 0 0 1 15 2.5v9a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 11.5v-9z"/>
                              </svg>
                              <span>{{ Str::limit($webinar->media, 15) }}</span>
                            </div>
                          @endif
                          
                        </div>
                      </div>
                    </div>
                  </td>
                  
                  <td>
                    <div class="d-flex flex-column gap-1">
                      <div class="fw-semibold text-dark">
                        {{ \Carbon\Carbon::parse($webinar->tanggal)->translatedFormat('d M Y') }}
                      </div>
              
                    </div>
                  </td>
                  
                  <td>
                    @if($webinar->status === 'published')
                      <span class="badge-pill badge-published small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px;">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        Published
                      </span>
                    @else
                      <span class="badge-pill badge-draft small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px;">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        </svg>
                        Draft
                      </span>
                    @endif
                  </td>
                  
                  <td class="text-center">
                    <div class="btn-group">
                      <button class="btn btn-ghost btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#modalDetail{{ $webinar->id }}"
                              title="Detail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                          <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                        </svg>
                        <span class="d-none d-md-inline">Detail</span>
                      </button>
                      <button class="btn btn-ghost btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#modalEdit{{ $webinar->id }}"
                              title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                        </svg>
                        <span class="d-none d-md-inline">Edit</span>
                      </button>
                      <button class="btn btn-outline-danger btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#modalDelete{{ $webinar->id }}"
                              title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                        <span class="d-none d-md-inline">Hapus</span>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        @if($webinars->hasPages())
          <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
            <div class="text-muted small">
              Menampilkan {{ $webinars->firstItem() }}–{{ $webinars->lastItem() }} dari {{ $webinars->total() }} webinar
            </div>
            <div class="pagination-wrap">
              @if ($webinars->hasPages())
                <nav aria-label="pagination">
                  <ul class="pagination mb-0">

                    {{-- Prev --}}
                    <li class="page-item {{ $webinars->onFirstPage() ? 'disabled' : '' }}">
                      @if ($webinars->onFirstPage())
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                      @else
                        <a class="page-link" href="{{ $webinars->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                      @endif
                    </li>

                    {{-- Angka halaman (dibatasi biar rapih: current-1, current, current+1) --}}
                    @php
                      $current = $webinars->currentPage();
                      $last = $webinars->lastPage();

                      $start = max(1, $current - 1);
                      $end = min($last, $current + 1);

                      // kalau di awal/akhir, tetep usahain tampil 3 angka kalau bisa
                      if ($current <= 2) { $end = min($last, 3); }
                      if ($current >= $last - 1) { $start = max(1, $last - 2); }
                    @endphp

                    {{-- kalau start > 1 tampil halaman 1 --}}
                    @if ($start > 1)
                      <li class="page-item">
                        <a class="page-link" href="{{ $webinars->url(1) }}">1</a>
                      </li>
                      @if ($start > 2)
                        <li class="page-item disabled"><span class="page-link">…</span></li>
                      @endif
                    @endif

                    {{-- range utama --}}
                    @for ($page = $start; $page <= $end; $page++)
                      <li class="page-item {{ $page == $current ? 'active' : '' }}">
                        @if ($page == $current)
                          <span class="page-link">{{ $page }}</span>
                        @else
                          <a class="page-link" href="{{ $webinars->url($page) }}">{{ $page }}</a>
                        @endif
                      </li>
                    @endfor

                    {{-- kalau end < last tampil halaman terakhir --}}
                    @if ($end < $last)
                      @if ($end < $last - 1)
                        <li class="page-item disabled"><span class="page-link">…</span></li>
                      @endif
                      <li class="page-item">
                        <a class="page-link" href="{{ $webinars->url($last) }}">{{ $last }}</a>
                      </li>
                    @endif

                    {{-- Next --}}
                    <li class="page-item {{ $webinars->hasMorePages() ? '' : 'disabled' }}">
                      @if ($webinars->hasMorePages())
                        <a class="page-link" href="{{ $webinars->nextPageUrl() }}" rel="next">&rsaquo;</a>
                      @else
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                      @endif
                    </li>

                  </ul>
                </nav>
              @endif
            </div>

          </div>
        @endif
      @else
        <div class="empty-state">
          <div class="empty-state-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
              <path d="M2.5 0A2.5 2.5 0 0 0 0 2.5v9c0 .818.393 1.544 1 2v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h6v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1c.607-.456 1-1.182 1-2v-9A2.5 2.5 0 0 0 13.5 0h-11zM1 2.5A1.5 1.5 0 0 1 2.5 1h11A1.5 1.5 0 0 1 15 2.5v9a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 11.5v-9z"/>
            </svg>
          </div>
          <h3 class="empty-state-title">Belum Ada Webinar</h3>
          <p class="empty-state-description">
            Mulai dengan menambahkan webinar pertama Anda untuk ditampilkan di halaman utama.
          </p>
          <button class="btn btn-brand" data-bs-toggle="modal" data-bs-target="#modalCreate">
            + Tambah Webinar Pertama
          </button>
        </div>
      @endif
    </div>
  </div>

</div>

{{-- =========================
    MODAL: CREATE WEBINAR (A + B) + old()
========================= --}}
<div class="modal fade modal-b" id="modalCreate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">

      {{-- HEADER --}}
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Tambah Webinar Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="{{ route('admin.webinars.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- BODY --}}
        <div class="modal-body">
          <div class="row g-4">
            <div class="col-12">
              <div class="card card-soft rounded-16">
                <div class="card-body">

                  {{-- BONUS: tampilkan error general (opsional) --}}
                  @if ($errors->any() && request()->isMethod('post'))
                    <div class="alert alert-danger mb-3">
                      <div class="fw-semibold mb-1">Gagal menyimpan.</div>
                      <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      Judul Webinar <span class="text-danger">*</span>
                    </label>
                    <input
                      type="text"
                      name="judul"
                      class="form-control rounded-16 @error('judul') is-invalid @enderror"
                      placeholder="Contoh: Webinar Digital Marketing 2024"
                      value="{{ old('judul') }}"
                      required
                    >
                    @error('judul')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      Deskripsi <span class="text-danger">*</span>
                    </label>
                    <textarea
                      name="deskripsi"
                      class="form-control rounded-16 @error('deskripsi') is-invalid @enderror"
                      rows="4"
                      placeholder="Deskripsi lengkap tentang webinar ini..."
                      required
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Tanggal <span class="text-danger">*</span>
                      </label>
                      <input
                        type="date"
                        name="tanggal"
                        class="form-control rounded-16 @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal') }}"
                        required
                      >
                      @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Waktu</label>
                      <input
                        type="time"
                        name="waktu"
                        class="form-control rounded-16 @error('waktu') is-invalid @enderror"
                        value="{{ old('waktu') }}"
                      >
                      @error('waktu')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="row g-3 mt-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Narasumber</label>
                      <input
                        type="text"
                        name="narasumber"
                        class="form-control rounded-16 @error('narasumber') is-invalid @enderror"
                        placeholder="Nama narasumber"
                        value="{{ old('narasumber') }}"
                      >
                      @error('narasumber')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Media</label>
                      <input
                        type="text"
                        name="media"
                        class="form-control rounded-16 @error('media') is-invalid @enderror"
                        placeholder="Zoom, Google Meet, dll"
                        value="{{ old('media') }}"
                      >
                      @error('media')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <hr class="my-4">

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Poster</label>
                    <input
                      type="file"
                      name="poster"
                      class="form-control rounded-16 @error('poster') is-invalid @enderror"
                      accept="image/*"
                    >
                    <div class="small text-muted mt-1">
                      Format JPG/PNG, maksimal 2MB
                    </div>
                    @error('poster')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mt-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select rounded-16 @error('status') is-invalid @enderror">
                      <option value="draft" {{ old('status','draft') == 'draft' ? 'selected' : '' }}>
                        Draft (tidak ditampilkan)
                      </option>
                      <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                        Published (tampil di landing)
                      </option>
                    </select>
                    @error('status')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- FOOTER --}}
        <div class="modal-footer">
          <button type="button" class="btn btn-ghost rounded-16" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="submit" class="btn btn-brand rounded-16">
            Simpan Webinar
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

{{-- BONUS UX: kalau validasi gagal, modalCreate otomatis kebuka lagi --}}
@if ($errors->any() && request()->isMethod('post'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var el = document.getElementById('modalCreate');
      if (el) new bootstrap.Modal(el).show();
    });
  </script>
@endif

{{-- =========================
    MODAL: DETAIL (A + B)
========================= --}}
@foreach($webinars as $webinar)
<div class="modal fade" id="modalDetail{{ $webinar->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">

      <div class="modal-header">
        <h5 class="modal-title fw-bold">Detail Webinar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-4">

          {{-- =========================
              KIRI: CARD DETAIL INFO
          ========================= --}}
          <div class="col-lg-7">
            <div class="card card-soft">
              <div class="card-body">

                <div class="mb-3">
                  <div class="small text-muted mb-1">Judul</div>
                  <div class="fw-semibold fs-5">{{ $webinar->judul }}</div>
                </div>

                <div class="mb-3">
                  <div class="small text-muted mb-1">Deskripsi</div>
                  <div style="white-space: pre-line;">{{ $webinar->deskripsi }}</div>
                </div>

                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="small text-muted mb-1">Tanggal</div>
                    <div class="fw-semibold">
                      {{ \Carbon\Carbon::parse($webinar->tanggal)->translatedFormat('d F Y') }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted mb-1">Waktu</div>
                    <div class="fw-semibold">
                      {{ $webinar->waktu ? $webinar->waktu . ' WIB' : '-' }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted mb-1">Narasumber</div>
                    <div class="fw-semibold">{{ $webinar->narasumber ?? '-' }}</div>
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted mb-1">Media</div>
                    <div class="fw-semibold">{{ $webinar->media ?? '-' }}</div>
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted mb-1">Status</div>
                    @if($webinar->status === 'published')
                      <span class="badge badge-pill badge-published">Published</span>
                    @else
                      <span class="badge badge-pill badge-draft">Draft</span>
                    @endif
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted mb-1">Poster</div>
                    <div class="fw-semibold">
                      {{ $webinar->poster ? basename($webinar->poster) : '-' }}
                    </div>
                  </div>

                  <div class="col-12">
                    <hr class="my-3">
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- =========================
              KANAN: CARD PREVIEW (STYLE B)
          ========================= --}}
          <div class="col-lg-5">
            <div class="card card-soft">
              <div class="card-body">

                <div class="fw-bold mb-2">Preview (Landing)</div>

                <div class="rounded-16 overflow-hidden border mb-3" style="background:#fff;">
                  <img
                    src="{{ $webinar->poster ? asset('storage/'.$webinar->poster) : 'https://via.placeholder.com/600x750/FFE2E2/991B1B?text=Poster' }}"
                    class="w-100"
                    style="aspect-ratio:4/5; object-fit:cover;"
                    alt="Poster {{ $webinar->judul }}"
                    onerror="this.src='https://via.placeholder.com/600x750/FFE2E2/991B1B?text=Poster'"
                  >
                </div>

                <div class="fw-bold fs-5">
                  {{ $webinar->judul }}
                </div>

                <div class="text-muted mt-2">
                  {{ Str::limit($webinar->deskripsi, 160) }}
                </div>

                <div class="row g-2 mt-3">
                  <div class="col-6">
                    <div class="small text-muted">Tanggal</div>
                    <div class="fw-semibold">
                      {{ \Carbon\Carbon::parse($webinar->tanggal)->translatedFormat('d F Y') }}
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="small text-muted">Waktu</div>
                    <div class="fw-semibold">
                      {{ $webinar->waktu ? $webinar->waktu . ' WIB' : '-' }}
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="small text-muted">Narasumber</div>
                    <div class="fw-semibold">{{ $webinar->narasumber ?? '-' }}</div>
                  </div>

                  <div class="col-6">
                    <div class="small text-muted">Media</div>
                    <div class="fw-semibold">{{ $webinar->media ?? '-' }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Tutup</button>

        <button type="button"
          class="btn btn-brand rounded-16"
          data-bs-dismiss="modal"
          data-bs-toggle="modal"
          data-bs-target="#modalEdit{{ $webinar->id }}">
          Edit
        </button>
      </div>

    </div>
  </div>
</div>
@endforeach

{{-- =========================
    MODAL: EDIT WEBINAR (A + B)
========================= --}}
@foreach($webinars as $webinar)
<div class="modal fade modal-b" id="modalEdit{{ $webinar->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">

      {{-- HEADER --}}
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Edit Webinar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="{{ route('admin.webinars.update', $webinar) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- BODY --}}
        <div class="modal-body">
          <div class="row g-4">

            {{-- FORM (KIRI) --}}
            <div class="col-lg-7">
              <div class="card card-soft rounded-16">
                <div class="card-body">

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Webinar <span class="text-danger">*</span></label>
                    <input
                      type="text"
                      name="judul"
                      class="form-control rounded-16"
                      value="{{ $webinar->judul }}"
                      required
                    >
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                    <textarea
                      name="deskripsi"
                      class="form-control rounded-16"
                      rows="4"
                      required
                    >{{ $webinar->deskripsi }}</textarea>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                      <input
                        type="date"
                        name="tanggal"
                        class="form-control rounded-16"
                        value="{{ $webinar->tanggal }}"
                        required
                      >
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Waktu</label>
                      <input
                        type="time"
                        name="waktu"
                        class="form-control rounded-16"
                        value="{{ $webinar->waktu }}"
                      >
                    </div>
                  </div>

                  <div class="row g-3 mt-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Narasumber</label>
                      <input
                        type="text"
                        name="narasumber"
                        class="form-control rounded-16"
                        value="{{ $webinar->narasumber }}"
                      >
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">Media</label>
                      <input
                        type="text"
                        name="media"
                        class="form-control rounded-16"
                        value="{{ $webinar->media }}"
                      >
                    </div>
                  </div>

                  <hr class="my-4">

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Poster</label>
                    <input
                      type="file"
                      name="poster"
                      class="form-control rounded-16"
                      accept="image/*"
                    >
                    @if($webinar->poster)
                      <div class="small text-muted mt-1">
                        File saat ini: {{ basename($webinar->poster) }}
                      </div>
                    @endif
                  </div>

                  <div class="mt-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select rounded-16">
                      <option value="draft" {{ $webinar->status == 'draft' ? 'selected' : '' }}>Draft</option>
                      <option value="published" {{ $webinar->status == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                  </div>

                </div>
              </div>
            </div>

            {{-- PREVIEW (KANAN) --}}
            <div class="col-lg-5">
              <div class="card card-soft rounded-16 h-100">
                <div class="card-body">

                  <div class="fw-bold mb-2">Preview (Statis)</div>

                  <div class="rounded-16 overflow-hidden border mb-3" style="background:#fff;">
                    @if($webinar->poster)
                      <img
                        src="{{ asset('storage/' . $webinar->poster) }}"
                        class="w-100"
                        style="aspect-ratio:4/5; object-fit:cover;"
                        alt="Poster {{ $webinar->judul }}"
                        onerror="this.src='https://via.placeholder.com/600x750/FFE2E2/991B1B?text=Poster';"
                      >
                    @else
                      <div class="w-100 d-flex align-items-center justify-content-center text-muted"
                           style="aspect-ratio:4/5; background: rgba(185,28,28,.06);">
                        Belum ada poster
                      </div>
                    @endif
                  </div>

                  <div class="fw-bold fs-5">{{ $webinar->judul }}</div>
                  <div class="text-muted mt-2">
                    {{ Str::limit($webinar->deskripsi, 160) }}
                  </div>

                  <div class="row g-2 mt-3">
                    <div class="col-6">
                      <div class="small text-muted">Tanggal</div>
                      <div class="fw-semibold">{{ \Carbon\Carbon::parse($webinar->tanggal)->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="col-6">
                      <div class="small text-muted">Waktu</div>
                      <div class="fw-semibold">{{ $webinar->waktu ? $webinar->waktu . ' WIB' : '-' }}</div>
                    </div>
                    <div class="col-6">
                      <div class="small text-muted">Narasumber</div>
                      <div class="fw-semibold">{{ $webinar->narasumber ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                      <div class="small text-muted">Media</div>
                      <div class="fw-semibold">{{ $webinar->media ?? '-' }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- FOOTER --}}
        <div class="modal-footer">
          <button type="button" class="btn btn-ghost rounded-16" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="submit" class="btn btn-brand rounded-16">
            Simpan Perubahan
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
@endforeach

{{-- =========================
    MODAL: HAPUS WEBINAR
========================= --}}
@foreach($webinars as $webinar)
<div class="modal fade" id="modalDelete{{ $webinar->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.webinars.destroy', $webinar) }}">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title text-danger fw-bold">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-4">
            <div class="mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#dc2626" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
              </svg>
            </div>
            <p class="text-gray-700 mb-2">Apakah Anda yakin ingin menghapus webinar ini?</p>
            <p class="fw-semibold text-gray-900">{{ $webinar->judul }}</p>
            <p class="small text-muted mt-2">Tindakan ini tidak dapat dibatalkan. Semua data webinar akan dihapus permanen.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-outline-danger">Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@endsection