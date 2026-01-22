@extends('layouts.app')

@section('title', 'Form Data Diri')

@push('head')
<style>
  :root{
    --brand:#b91c1c;
    --brand-2:#dc2626;
    --brand-3:#991b1b;
    --bg-page:#f7e8e8;
    --bg-card:#fff5f5;
    --border-soft: rgba(185,28,28,.18);
  }

  body{ background: var(--bg-page); }

  .page-title{ font-weight:900; letter-spacing:-.2px; color:var(--brand-3); }
  .muted{ color:#6b7280; }
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
  .btn-brand:hover{ background: var(--brand-2); }

  .btn-ghost{
    border:1px solid rgba(185,28,28,.35);
    background: rgba(255,255,255,.65);
    color: var(--brand);
  }
  .btn-ghost:hover{
    background: rgba(185,28,28,.08);
    color: var(--brand-3);
  }

  thead tr{ background: rgba(185,28,28,.06); }

  .badge-pill{
    border-radius:999px;
    padding:.35rem .6rem;
    font-weight:700;
  }

  .badge-required{
    background: rgba(185,28,28,.12);
    color: var(--brand-3);
    border: 1px solid rgba(185,28,28,.25);
  }

  .badge-optional{
    background:#f3f4f6;
    color:#374151;
    border:1px solid #e5e7eb;
  }

  .badge-type{
    background:#e8f5e9;
    color:#2e7d32;
    border:1px solid #a5d6a7;
  }

  .form-control:focus,
  .form-select:focus{
    border-color: rgba(185,28,28,.55);
    box-shadow: 0 0 0 .25rem rgba(185,28,28,.18);
  }

  .divider-soft{
    height:1px;
    background: rgba(185,28,28,.14);
    border-radius:999px;
  }

  .modal-body{
    max-height: calc(100vh - 220px);
    overflow-y: auto;
  }
</style>
@endpush

@section('content')
<div class="container py-3">

{{-- ================= HEADER ================= --}}
<div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
  <div>
    <h1 class="page-title mb-1">Form Data Diri</h1>
    <div class="muted">
      Kelola pertanyaan data diri untuk absensi (CRUD), atur tipe input, dan tentukan wajib/tidak.
    </div>
  </div>

  <div class="d-flex gap-2 flex-wrap">
    <button class="btn btn-brand rounded-16" data-bs-toggle="modal" data-bs-target="#modalCreateQuestion">
      + Tambah Pertanyaan
    </button>
    <button class="btn btn-ghost rounded-16" data-bs-toggle="modal" data-bs-target="#modalPreviewForm">
      Preview Form
    </button>
    <a href="{{ url('/admin/dashboard') }}" class="btn btn-ghost rounded-16">
      Kembali
    </a>
  </div>
</div>

{{-- ================= TOOLBAR ================= --}}
<form method="GET" action="{{ route('admin.form-datadiri') }}">
  <div class="card card-soft rounded-16 mb-4">
    <div class="card-body">
      @if(session('success'))
      <div class="alert alert-success rounded-16 mb-3">
        {{ session('success') }}
      </div>
       @endif
      <div class="row g-2 align-items-end">

        <div class="col-md-5">
          <label class="form-label fw-semibold">Cari pertanyaan</label>
          <input type="text"
                 name="q"
                 value="{{ request('q') }}"
                 class="form-control rounded-16"
                 placeholder="Cari label / key...">
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Filter wajib</label>
          <select name="required" class="form-select rounded-16">
            <option value="">Semua</option>
            <option value="1" @selected(request('required')==='1')>Wajib</option>
            <option value="0" @selected(request('required')==='0')>Tidak wajib</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label fw-semibold">Tipe input</label>
          <select name="type" class="form-select rounded-16">
            <option value="">Semua</option>
            @foreach (['text','email','number','date','textarea','select','radio','checkbox'] as $type)
              <option value="{{ $type }}" @selected(request('type')===$type)>
                {{ ucfirst($type) }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-1 d-grid">
          <a href="{{ route('admin.form-datadiri') }}" class="btn btn-ghost rounded-16">
            Reset
          </a>
        </div>

      </div>
    </div>
  </div>
</form>

{{-- ================= MAIN ================= --}}
<div class="row g-4">

{{-- ================= TABLE ================= --}}
<div class="col-lg-8">
<div class="card card-soft rounded-16">
<div class="card-body">

<div class="d-flex align-items-center justify-content-between mb-3">
  <div class="fw-semibold">Daftar Pertanyaan</div>
  <div class="muted small">Menampilkan {{ $fields->count() }} pertanyaan</div>
</div>

<div class="table-responsive">
<table class="table table-hover align-middle">
<thead>
<tr class="muted">
  <th style="width:56px;">No</th>
  <th>Pertanyaan</th>
  <th style="width:160px;">Tipe Input</th>
  <th style="width:140px;">Wajib?</th>
  <th style="width:120px;">Urutan</th>
  <th style="width:240px;" class="text-end">Aksi</th>
</tr>
</thead>
<tbody>
@foreach ($fields as $field)
<tr>
<td class="fw-semibold">{{ $loop->iteration }}</td>

<td>
  <div class="fw-semibold">{{ $field->label }}</div>
  <div class="small muted">key: <code>{{ $field->field_key }}</code></div>
</td>

<td>
  <span class="badge badge-pill badge-type">{{ ucfirst($field->type) }}</span>
</td>

<td>
  @if($field->required)
    <span class="badge badge-pill badge-required">Wajib</span>
  @else
    <span class="badge badge-pill badge-optional">Tidak wajib</span>
  @endif
</td>

<td>
  <input type="number"
         class="form-control form-control-sm rounded-16"
         value="{{ $field->sort_order }}"
         disabled
         style="max-width:90px;">
</td>

<td class="text-end">
  <div class="d-inline-flex gap-2">

    <button class="btn btn-ghost btn-sm rounded-16"
            data-bs-toggle="modal"
            data-bs-target="#modalEdit{{ $field->id }}">
      Edit
    </button>

    <button class="btn btn-outline-danger btn-sm rounded-16"
            data-bs-toggle="modal"
            data-bs-target="#modalDelete{{ $field->id }}">
      Hapus
    </button>

  </div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

</div>
</div>
</div>

{{-- ================= SIDEBAR ================= --}}
<div class="col-lg-4">
<div class="card card-soft rounded-16">
<div class="card-body">
  <div class="fw-semibold mb-2">Pengaturan Form</div>
  <div class="divider-soft my-3"></div>
  <ul class="small mb-0">
    <li>Key harus unik</li>
    <li>Field wajib divalidasi</li>
    <li>Select / Radio / Checkbox butuh opsi</li>
    <li>Urutan menentukan posisi pertanyaan</li>
  </ul>
</div>
</div>
</div>

</div>
</div>

{{-- ==========================================================
  MODAL CREATE QUESTION
========================================================== --}}
<div class="modal fade" id="modalCreateQuestion" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">
      <form method="POST" action="{{ route('admin.form-datadiri.store') }}">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold">Tambah Pertanyaan Data Diri</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <div class="col-12">
              <label class="form-label fw-semibold">Label Pertanyaan</label>
              <input name="label" class="form-control rounded-16" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Key</label>
              <input name="field_key" class="form-control rounded-16" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Tipe Input</label>
              <select name="type" class="form-select rounded-16">
                @foreach (['text','email','number','date','textarea','select','radio','checkbox'] as $t)
                  <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Wajib?</label>
              <select name="required" class="form-select rounded-16">
                <option value="1">Wajib</option>
                <option value="0">Tidak wajib</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Urutan</label>
              <input type="number" name="sort_order" class="form-control rounded-16" value="1">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Catatan Admin</label>
              <textarea name="admin_note" class="form-control rounded-16" rows="2"></textarea>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-brand rounded-16">Simpan</button>
        </div>

      </form>
    </div>
  </div>
</div>

{{-- ==========================================================
  MODAL EDIT & DELETE (DINAMIS)
========================================================== --}}
@foreach ($fields as $field)

{{-- EDIT --}}
<div class="modal fade" id="modalEdit{{ $field->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">

      <form method="POST" action="{{ route('admin.form-datadiri.update', $field->id) }}">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold">Edit Pertanyaan</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input class="form-control rounded-16 mb-2" name="label" value="{{ $field->label }}">
          <input class="form-control rounded-16 mb-2" name="field_key" value="{{ $field->field_key }}">
          <input type="number" class="form-control rounded-16 mb-2" name="sort_order" value="{{ $field->sort_order }}">

          <select name="type" class="form-select rounded-16 mb-2">
            @foreach (['text','email','number','date','textarea','select','radio','checkbox'] as $t)
              <option value="{{ $t }}" @selected($field->type==$t)>
                {{ ucfirst($t) }}
              </option>
            @endforeach
          </select>

          <select name="required" class="form-select rounded-16">
            <option value="1" @selected($field->required)>Wajib</option>
            <option value="0" @selected(!$field->required)>Tidak wajib</option>
          </select>
        </div>

        <div class="modal-footer">
          <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-brand rounded-16">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>

{{-- DELETE --}}
<div class="modal fade" id="modalDelete{{ $field->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-16">

      <form method="POST" action="{{ route('admin.form-datadiri.destroy', $field->id) }}">
        @csrf
        @method('DELETE')

        <div class="modal-header">
          <h5 class="modal-title fw-bold text-danger">Hapus Pertanyaan</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          Yakin ingin menghapus:
          <strong>{{ $field->label }}</strong> ?
        </div>

        <div class="modal-footer">
          <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-outline-danger rounded-16">Ya, Hapus</button>
        </div>

      </form>

    </div>
  </div>
</div>

@endforeach

{{-- ==========================================================
  MODAL PREVIEW FORM
========================================================== --}}
<div class="modal fade" id="modalPreviewForm" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Preview Form Data Diri (Peserta)</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="muted mb-3">
          Contoh tampilan form yang akan diisi peserta.
        </div>

        <form>
          <div class="mb-3">
            <label class="form-label fw-semibold">
              Nama Lengkap <span class="text-danger">*</span>
            </label>
            <input class="form-control rounded-16" placeholder="Masukkan nama lengkap">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">
              Email <span class="text-danger">*</span>
            </label>
            <input type="email" class="form-control rounded-16">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Instansi</label>
            <select class="form-select rounded-16">
              <option>Pilih instansi</option>
              <option>Pemda</option>
              <option>Kementerian</option>
              <option>Lainnya</option>
            </select>
          </div>

          <button type="button" class="btn btn-brand rounded-16 w-100">
            Lanjut Evaluasi
          </button>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection
