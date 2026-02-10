@extends('layouts.app')

@section('title', 'Form Evaluasi')

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
  }

  .btn-brand {
    background: var(--brand);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
  }

  .btn-brand:hover {
    background: var(--brand-2);
  }

  .btn-ghost {
    border: 1px solid rgba(185, 28, 28, 0.2);
    background: white;
    color: var(--brand);
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
  }

  .btn-ghost:hover {
    background: rgba(185, 28, 28, 0.05);
  }

  .badge-pill {
    border-radius: 50px;
    padding: 0.25rem 0.5rem;
    font-weight: 600;
    font-size: 0.75rem;
  }

  .badge-rating {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    border: 1px solid rgba(46, 125, 50, 0.2);
  }

  .badge-text {
    background: rgba(156, 163, 175, 0.1);
    color: #6b7280;
    border: 1px solid rgba(156, 163, 175, 0.2);
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

  .scale-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 70px;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.75rem;
    border: 1px solid rgba(185, 28, 28, 0.2);
    background: rgba(185, 28, 28, 0.06);
    color: var(--brand-3);
  }

  .scale-badge.na {
    background: #f3f4f6;
    border-color: #e5e7eb;
    color: #9ca3af;
  }

  .question-text {
    font-weight: 600;
    color: #111827;
    margin: 0;
    line-height: 1.35;
    font-size: 0.90rem;
  }
  .question-meta {
    font-size: 0.8125rem;
    color: #6b7280;
    margin-top: 0.25rem;
  }



  .card-soft .card-body { padding: 1.25rem; }

  .form-label { margin-bottom: .35rem; }
  .btn-filter {
    padding: 0.45rem 1.75rem; /* bikin panjang & ramping */
    min-width: 130px;
    font-size: 0.875rem;
  }
  /* === Samain feel tabel kayak halaman Laporan Evaluasi (foto 1) === */
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

  /* Hover halus */
  .table-analytics tbody tr {
    transition: background-color 0.2s ease;
  }
  .table-analytics tbody tr:hover {
    background: rgba(185, 28, 28, 0.03);
  }

  /* Kolom No biar gak “ngebold” dan gak besar */
  .td-no {
    width: 50px;
    font-weight: 500;
    font-size: 0.875rem;
    color: #111827;
  }

  /* Judul item di kolom kedua (mirip judul webinar) */
  .row-title {
    font-weight: 600;
    color: #111827;
    font-size: 1rem;
    margin: 0;
    line-height: 1.35;
  }

  /* Subtext di bawah judul */
  .row-sub {
    font-size: 0.8125rem;
    color: #6b7280;
    margin-top: 0.25rem;
  }
  
  .modal-footer .btn {
    padding: 0.6rem 1.5rem;
    font-weight: 600;
  }

</style>
@endpush

@section('content')
<div class="modal fade" id="modalDeleteEvaluasi" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger fw-bold">
          Konfirmasi Hapus Pertanyaan
        </h5>
        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p class="mb-2">
          Anda yakin ingin menghapus pertanyaan berikut?
        </p>
        <div class="alert alert-danger mb-0">
          <strong id="namaPertanyaanEvaluasi">Pertanyaan</strong>
          <div class="small text-muted mt-1">
            Data yang sudah dihapus tidak dapat dikembalikan.
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button"
                class="btn"
                data-bs-dismiss="modal"
                style="min-width:120px; border-radius:8px; font-weight:600; background:#6b7280; color:#fff; border:none;">
          Batal
        </button>

        <form id="formDeleteEvaluasi" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger" style="min-width:120px; border-radius:8px; font-weight:600;">
            Ya, Hapus
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="container py-4">

{{-- HEADER --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
  <div>
    <h1 class="page-title mb-2">Form Evaluasi</h1>
    <p class="text-muted mb-0">
      Kelola pertanyaan evaluasi untuk peserta setelah absensi.
    </p>
  </div>
  
  <div class="d-flex gap-2">
    <button class="btn btn-brand d-flex align-items-center gap-1" 
            data-bs-toggle="modal" 
            data-bs-target="#modalCreateEval">
      <i class="fas fa-plus fa-sm"></i>
      <span>Tambah</span>
    </button>
    <button class="btn btn-ghost d-flex align-items-center gap-1"
            data-bs-toggle="modal"
            data-bs-target="#modalPreviewEval">
      <i class="fas fa-eye fa-sm"></i>
      <span>Preview</span>
    </button>
    <a href="{{ url('/admin/dashboard') }}" 
       class="btn btn-ghost d-flex align-items-center gap-1">
      <i class="fas fa-arrow-left fa-sm"></i>
      <span>Kembali</span>
    </a>
  </div>
</div>

{{-- FILTER --}}
<form method="GET" action="{{ route('admin.evaluasi.index') }}">
  <div class="card card-soft mb-4">
    <div class="card-body">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
          <div class="d-flex align-items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="row g-3 align-items-end">
        {{-- Search --}}
        <div class="col-md-4">
          <label class="form-label fw-semibold">Cari pertanyaan</label>
          <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Cari pertanyaan..."
          >
        </div>

        {{-- Type --}}
        <div class="col-md-4">
          <label class="form-label fw-semibold">Tipe</label>
          <select name="type" class="form-select">
            <option value="">Semua</option>
            <option value="rating" {{ request('type')=='rating' ? 'selected' : '' }}>Rating</option>
            <option value="text" {{ request('type')=='text' ? 'selected' : '' }}>Text</option>
          </select>
        </div>

        {{-- Actions --}}
        <div class="col-md-4 d-flex gap-2 justify-content-end">
          <button type="submit" class="btn btn-brand btn-filter">
            Filter
          </button>
          <a href="{{ route('admin.evaluasi.index') }}" class="btn btn-ghost btn-filter">
            Reset
          </a>
        </div>

      </div>


    </div>
  </div>
</form>

{{-- MAIN CONTENT --}}
<div class="row">
  {{-- TABLE --}}
  <div class="col-lg-12">
    <div class="card card-soft">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="fw-semibold mb-0">Daftar Pertanyaan Evaluasi</h5>
          <span class="text-muted small">{{ $questions->count() }} pertanyaan</span>
        </div>

        @if($questions->isEmpty())
        <div class="text-center py-5">
          <i class="fas fa-file-question fa-2x text-muted mb-3"></i>
          <p class="text-muted">Belum ada pertanyaan evaluasi</p>
          <button class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateEval">
            Tambah Pertanyaan Pertama
          </button>
        </div>
        @else
        <div class="table-responsive">
          <table class="table table-analytics table-hover align-middle">
            <thead class="table-header">
              <tr>
                <th style="width: 50px;">No</th>
                <th>Pertanyaan</th>
                <th style="width: 100px;">Tipe</th>
                <th style="width: 100px;">Skala</th>
                <th style="width: 150px;" class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $q)
              <tr>
                <td class="td-no">{{ $loop->iteration }}</td>
                
                <td>
                  <div class="question-text">{{ $q->question }}</div>
                  <div class="question-meta">Urutan: {{ $q->urutan }}</div>
                </td>
                
                <td>
                  @if($q->type === 'rating')
                  <span class="badge badge-pill badge-rating">Rating</span>
                  @else
                  <span class="badge badge-pill badge-text">{{ ucfirst($q->type) }}</span>
                  @endif
                </td>
                
                <td>
                  @if($q->type === 'rating')
                  <div class="d-flex align-items-center gap-2">
                    <span class="scale-badge">
                      1–{{ $q->rating_max ?? 5 }}
                    </span>
                    <button class="btn btn-sm btn-ghost"
                            data-bs-toggle="modal"
                            data-bs-target="#modalScale{{ $q->id }}">
                      <i class="fas fa-sliders-h fa-sm"></i>
                    </button>
                  </div>
                  @else
                  <span class="scale-badge na">—</span>
                  @endif
                </td>
                
                <td class="text-end">
                  <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-sm btn-ghost"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditEval{{ $q->id }}">
                      <i class="fas fa-edit fa-sm"></i>
                    </button>
                    <button type="button"
                            class="btn btn-sm btn-outline-danger"
                            onclick="openDeleteEvaluasi(
                              '{{ route('admin.evaluasi.destroy', $q->id) }}',
                              '{{ $q->question }}'
                            )">
                      <i class="fas fa-trash"></i>
                    </button>

                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>
    </div>
  </div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="modalCreateEval" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.evaluasi.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Tambah Pertanyaan Evaluasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Pertanyaan</label>
              <input type="text"
                     name="question"
                     class="form-control"
                     placeholder="Contoh: Seberapa puas Anda dengan materi webinar?"
                     required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Tipe Jawaban</label>
              <select name="type" class="form-select" required>
                <option value="rating">Rating (1–5)</option>
                <option value="text">Text</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Urutan</label>
              <input type="number"
                     name="urutan"
                     class="form-control"
                     value="{{ $questions->isNotEmpty() ? ($questions->max('urutan') + 1) : 1 }}"
                     min="1"
                     required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-brand">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- MODAL EDIT SCALE --}}
@foreach($questions as $q)
  @if($q->type === 'rating')
  <div class="modal fade" id="modalScale{{ $q->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form method="POST" action="{{ route('admin.evaluasi.update-scale', $q->id) }}">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Atur Skala Rating</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-semibold">Jumlah Skala</label>
              <input type="number"
                     name="rating_max"
                     class="form-control"
                     min="2" max="10"
                     value="{{ $q->rating_max ?? 5 }}">
            </div>

            <div class="mb-2 fw-semibold">Label per Angka</div>

            @php
              $labels = $q->rating_labels ?? [];
              $max = $q->rating_max ?? 5;
            @endphp

            @for($i = 1; $i <= $max; $i++)
              <div class="input-group mb-2">
                <span class="input-group-text">{{ $i }}</span>
                <input type="text"
                       name="rating_labels[{{ $i }}]"
                       class="form-control"
                       value="{{ $labels[$i] ?? '' }}"
                       placeholder="Label untuk {{ $i }}">
              </div>
            @endfor
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-brand">Simpan Skala</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endif
@endforeach

{{-- MODAL EDIT QUESTION --}}
@foreach($questions as $q)
<div class="modal fade" id="modalEditEval{{ $q->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.evaluasi.update', $q->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Edit Pertanyaan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Pertanyaan</label>
              <input type="text"
                     name="question"
                     class="form-control"
                     value="{{ $q->question }}"
                     required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Tipe Jawaban</label>
              <select name="type" class="form-select" required>
                <option value="rating" {{ $q->type === 'rating' ? 'selected' : '' }}>Rating (1–5)</option>
                <option value="text" {{ $q->type === 'text' ? 'selected' : '' }}>Text</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Urutan</label>
              <input type="number"
                     name="urutan"
                     class="form-control"
                     value="{{ $q->urutan }}"
                     min="1"
                     required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-brand">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

{{-- MODAL PREVIEW --}}
<div class="modal fade" id="modalPreviewEval" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Preview Form Evaluasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p class="text-muted mb-4">
          Contoh tampilan form yang akan dilihat peserta:
        </p>

        <form>
          @foreach($questions->sortBy('urutan') as $q)
            <div class="mb-4">
              <label class="form-label fw-semibold">
                {{ $loop->iteration }}. {{ $q->question }}
              </label>

              @if($q->type === 'rating')
                <div class="d-flex gap-2">
                  @for($i = 1; $i <= ($q->rating_max ?? 5); $i++)
                    <div class="border rounded px-3 py-2 text-muted">
                      {{ $i }}
                    </div>
                  @endfor
                </div>

              @elseif($q->type === 'text')
                <input class="form-control" disabled>
              @endif
            </div>
          @endforeach

          <button type="button" class="btn btn-brand w-100">
            Kirim Evaluasi
          </button>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
{{-- MODAL HAPUS PERTANYAAN EVALUASI --}}
<div class="modal fade" id="modalDeleteEvaluasi" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger fw-bold">
          Hapus Pertanyaan Evaluasi
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>Anda yakin ingin menghapus pertanyaan berikut?</p>
        <div class="alert alert-danger mb-0">
          <strong id="evalQuestionText">Pertanyaan</strong>
          <div class="small text-muted mt-1">
            Tindakan ini tidak dapat dibatalkan.
          </div>
        </div>
      </div>

      <div class="modal-footer d-flex gap-2">
        <button type="button"
                class="btn btn-ghost"
                data-bs-dismiss="modal"
                style="min-width:120px;">
          Batal
        </button>

        <form id="formDeleteEvaluasi" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="btn btn-brand"
                  style="min-width:120px;">
            Ya, Hapus
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
@push('scripts')
<script>
  function openDeleteEvaluasi(url, question) {
    document.getElementById('formDeleteEvaluasi').action = url;
    document.getElementById('namaPertanyaanEvaluasi').innerText = question;

    const modal = new bootstrap.Modal(
      document.getElementById('modalDeleteEvaluasi')
    );
    modal.show();
  }
</script>
@endpush

@endsection