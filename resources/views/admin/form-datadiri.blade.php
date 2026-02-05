@extends('layouts.app')

@section('title', 'Form Data Diri')

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

  .badge-required {
    background: rgba(185, 28, 28, 0.1);
    color: var(--brand-3);
    border: 1px solid rgba(185, 28, 28, 0.2);
  }

  .badge-optional {
    background: rgba(156, 163, 175, 0.1);
    color: #6b7280;
    border: 1px solid rgba(156, 163, 175, 0.2);
  }

  .badge-type {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    border: 1px solid rgba(46, 125, 50, 0.2);
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

  .key-display {
    font-family: monospace;
    background: #f3f4f6;
    padding: 0.125rem 0.375rem;
    border-radius: 4px;
    font-size: 0.75rem;
    color: #6b7280;
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

  .table-analytics tbody tr {
    transition: background-color 0.2s ease;
  }
  .table-analytics tbody tr:hover {
    background: rgba(185, 28, 28, 0.03);
  }

  .td-no {
    width: 50px;
    font-weight: 500;
    font-size: 0.875rem;
    color: #111827;
  }

  .row-title {
    font-weight: 600;
    color: #111827;
    font-size: 0.90rem;
    margin: 0;
    line-height: 1.35;
  }

  /* Subtext di bawah judul */
  .row-sub {
    font-size: 0.8125rem;
    color: #6b7280;
    margin-top: 0.25rem;
  }

</style>
@endpush

@section('content')
<div class="container py-4">

{{-- HEADER --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
  <div>
    <h1 class="page-title mb-2">Form Data Diri</h1>
    <p class="text-muted mb-0">
      Kelola pertanyaan data diri untuk absensi.
    </p>
  </div>
  
  <div class="d-flex gap-2">
    <button class="btn btn-brand d-flex align-items-center gap-1" 
            data-bs-toggle="modal" 
            data-bs-target="#modalCreateQuestion">
      <i class="fas fa-plus fa-sm"></i>
      <span>Tambah</span>
    </button>
    <button class="btn btn-ghost d-flex align-items-center gap-1"
            data-bs-toggle="modal"
            data-bs-target="#modalPreviewForm">
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
<form method="GET" action="{{ route('admin.form-datadiri') }}">
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

      <div class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Cari pertanyaan</label>
          <input type="text"
                 name="q"
                 value="{{ request('q') }}"
                 class="form-control"
                 placeholder="Cari label atau key...">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Status</label>
          <select name="required" class="form-select">
            <option value="">Semua</option>
            <option value="1" @selected(request('required')==='1')>Wajib</option>
            <option value="0" @selected(request('required')==='0')>Tidak wajib</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Tipe input</label>
          <select name="type" class="form-select">
            <option value="">Semua</option>
            @foreach (['text','email','number','date','textarea','select','radio','checkbox'] as $type)
              <option value="{{ $type }}" @selected(request('type')===$type)>
                {{ ucfirst($type) }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2 d-grid">
          <button type="submit" class="btn btn-brand">Filter</button>
        </div>
      </div>
    </div>
  </div>
</form>

{{-- MAIN CONTENT --}}
<div class="row">
  {{-- TABLE --}}
  <div class="col-lg-8">
    <div class="card card-soft">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="fw-semibold mb-0">Daftar Pertanyaan</h5>
          <span class="text-muted small">{{ $fields->count() }} pertanyaan</span>
        </div>

        @if($fields->isEmpty())
        <div class="text-center py-5">
          <i class="fas fa-file-question fa-2x text-muted mb-3"></i>
          <p class="text-muted">Belum ada pertanyaan</p>
          <button class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateQuestion">
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
                <th style="width: 100px;">Field</th>
                <th style="width: 80px;">Urutan</th>
                <th style="width: 150px;" class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($fields as $field)
              <tr>
                <td class="td-no">{{ $loop->iteration }}</td>
                
                <td>
                  <div class="row-title">{{ $field->label }}</div>
                  <div class="row-sub">
                    <span class="key-display">{{ $field->field_key }}</span>
                  </div>
                </td>

                
                <td>
                  <span class="badge badge-pill badge-type">{{ ucfirst($field->type) }}</span>
                </td>
                
                <td>
                  @if($field->required)
                  <span class="badge badge-pill badge-required">Wajib</span>
                  @else
                  <span class="badge badge-pill badge-optional">Opsional</span>
                  @endif
                </td>
                
                <td>
                  <input type="number"
                         class="form-control form-control-sm"
                         value="{{ $field->sort_order }}"
                         disabled
                         style="width: 60px;">
                </td>
                
                <td class="text-end">
                  <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-sm btn-ghost"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit{{ $field->id }}">
                      <i class="fas fa-edit fa-sm"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDelete{{ $field->id }}">
                      <i class="fas fa-trash fa-sm"></i>
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

  {{-- SIDEBAR --}}
  <div class="col-lg-4">
    <div class="card card-soft">
      <div class="card-body">
        <h6 class="fw-semibold mb-3">
          <i class="fas fa-info-circle me-2"></i>Informasi
        </h6>
        <ul class="small mb-0">
          <li class="mb-2">Key harus unik dan tidak boleh ada spasi</li>
          <li class="mb-2">Field wajib akan divalidasi saat submit</li>
          <li class="mb-2">Urutan menentukan tampilan di form</li>
          <li>Pilihan select/radio/checkbox perlu konfigurasi tambahan</li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="modalCreateQuestion" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.form-datadiri.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Tambah Pertanyaan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Label Pertanyaan</label>
              <input name="label" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Key</label>
              <input name="field_key" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Tipe Input</label>
              <select name="type" class="form-select">
                @foreach (['text','email','number','date','textarea','select','radio','checkbox'] as $t)
                  <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Wajib?</label>
              <select name="required" class="form-select">
                <option value="1">Wajib</option>
                <option value="0">Tidak wajib</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Urutan</label>
              <input type="number" name="sort_order" class="form-control" value="1">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Catatan (opsional)</label>
              <textarea name="admin_note" class="form-control" rows="2"></textarea>
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

{{-- MODAL EDIT & DELETE --}}
@foreach ($fields as $field)
<div class="modal fade" id="modalEdit{{ $field->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.form-datadiri.update', $field->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Edit Pertanyaan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Label Pertanyaan</label>
              <input name="label" class="form-control" value="{{ $field->label }}" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Key</label>
              <input name="field_key" class="form-control" value="{{ $field->field_key }}" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Tipe Input</label>
              <select name="type" class="form-select">
                @foreach (['text','email','number','date','textarea','select','radio','checkbox'] as $t)
                  <option value="{{ $t }}" @selected($field->type==$t)>{{ ucfirst($t) }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Wajib?</label>
              <select name="required" class="form-select">
                <option value="1" @selected($field->required)>Wajib</option>
                <option value="0" @selected(!$field->required)>Tidak wajib</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Urutan</label>
              <input type="number" name="sort_order" class="form-control" value="{{ $field->sort_order }}">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Catatan (opsional)</label>
              <textarea name="admin_note" class="form-control" rows="2">{{ $field->admin_note }}</textarea>
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

<div class="modal fade" id="modalDelete{{ $field->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.form-datadiri.destroy', $field->id) }}">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title fw-bold text-danger">Hapus Pertanyaan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="mb-3">Yakin ingin menghapus pertanyaan ini?</p>
          <div class="alert alert-warning py-2">
            <strong>{{ $field->label }}</strong><br>
            <small class="text-muted">{{ $field->field_key }}</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-outline-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

{{-- MODAL PREVIEW --}}
<div class="modal fade" id="modalPreviewForm" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Preview Form Data Diri</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted mb-4">Contoh tampilan form yang akan dilihat peserta:</p>
        
        <form>
          <div class="mb-3">
            <label class="form-label fw-semibold">
              Nama Lengkap <span class="text-danger">*</span>
            </label>
            <input class="form-control" placeholder="Masukkan nama lengkap">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">
              Email <span class="text-danger">*</span>
            </label>
            <input type="email" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Instansi</label>
            <select class="form-select">
              <option>Pilih instansi</option>
              <option>Pemda</option>
              <option>Kementerian</option>
            </select>
          </div>

          <button type="button" class="btn btn-brand w-100">
            Simpan Data Diri
          </button>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-ghost" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection