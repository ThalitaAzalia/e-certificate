@extends('layouts.app')

@section('title', 'Form Evaluasi')

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
  .muted{ color:var(--muted); }
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

  thead tr{ background: rgba(185,28,28,.06); }

  .badge-pill{ border-radius:999px; padding:.25rem .55rem; font-weight:800; font-size:12px; }
  .badge-rating{
    background:#e8f5e9;
    color:#2e7d32;
    border:1px solid #a5d6a7;
  }
  .badge-text{
    background:#f3f4f6;
    color:#374151;
    border:1px solid #e5e7eb;
  }

  .form-control:focus, .form-select:focus{
    border-color: rgba(185,28,28,.55);
    box-shadow: 0 0 0 .25rem rgba(185,28,28,.18);
  }

  .hint{ font-size:.875rem; color: var(--muted); }
  .row-actions .btn{ white-space:nowrap; }

  .divider-soft{ height:1px; background: rgba(185,28,28,.14); border-radius:999px; }

  .scale-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:52px;
    padding:.25rem .55rem;
    border-radius:999px;
    font-weight:900;
    font-size:12px;
    border:1px solid rgba(185,28,28,.18);
    background: rgba(185,28,28,.06);
    color: var(--brand-3);
    white-space:nowrap;
  }
  .scale-badge.na{
    background:#f3f4f6;
    border-color:#e5e7eb;
    color:#9ca3af;
  }

  .table{ margin-bottom:0; }
  .table td, .table th{
    vertical-align: middle;
    padding: .65rem .75rem;
  }

  .q-title{
    font-weight:900;
    color: var(--ink);
    margin:0;
    line-height:1.2;
  }
  .q-sub{
    margin:.2rem 0 0;
    font-size:12.5px;
    color: var(--muted);
    line-height:1.25;
  }

  .btn-xs{
    padding:.32rem .6rem;
    font-size:.825rem;
    border-radius:999px;
  }

  .col-no{ width:56px; }
  .col-type{ width:120px; }
  .col-scale{ width:96px; }
  .col-actions{ width:190px; }

  .table-layout-fixed{ table-layout: fixed; }
  .td-actions{ text-align:right; }
  .td-center{ text-align:center; }

  .toolbar-row .form-label{ margin-bottom:.35rem; }
</style>
@endpush

@section('content')
@if(session('success'))
  <div class="alert alert-success rounded-16 mb-3">
    {{ session('success') }}
  </div>
@endif

<div class="container py-3">

  {{-- Header --}}
  <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
    <div>
      <h1 class="page-title mb-1">Form Evaluasi</h1>
      <div class="muted">
        Kelola pertanyaan evaluasi (CRUD) dan atur alur skala rating yang akan diisi peserta setelah absensi.
      </div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
      <button class="btn btn-brand rounded-16" data-bs-toggle="modal" data-bs-target="#modalCreateEval">
        + Tambah Pertanyaan
      </button>
      <button class="btn btn-ghost rounded-16" data-bs-toggle="modal" data-bs-target="#modalPreviewEval">
        Preview Form
      </button>
      <a href="{{ url('/admin/dashboard') }}" class="btn btn-ghost rounded-16">Kembali</a>
    </div>
  </div>

  <div class="row g-4">
    {{-- Left: Rating Settings + Info --}}
    <div class="col-lg-4">
      <div class="card card-soft rounded-16">
        <div class="card-body">
          <div class="fw-semibold mb-2">Pengaturan Skala Rating</div>
          <div class="hint">Atur skala penilaian dan labelnya (UI saja).</div>

          <div class="divider-soft my-3"></div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Skala Rating (Custom)</label>
            <div class="row g-2">
              <div class="col-6">
                <div class="small muted mb-1">Min</div>
                <input id="scaleMin" type="number" class="form-control rounded-16" value="1" min="0">
              </div>
              <div class="col-6">
                <div class="small muted mb-1">Max</div>
                <input id="scaleMax" type="number" class="form-control rounded-16" value="5" min="1">
              </div>
            </div>
            <div class="hint mt-1">Contoh umum: 1–5. Kamu bisa ubah jadi 1–7, 0–10, dll (UI saja).</div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Label Rendah (angka kecil)</label>
            <input type="text" class="form-control rounded-16" value="Sangat Tidak Puas">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Label Tinggi (angka besar)</label>
            <input type="text" class="form-control rounded-16" value="Sangat Puas">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Tampilkan Label per Angka?</label>
            <select class="form-select rounded-16">
              <option selected>Tidak (cukup label rendah/tinggi)</option>
              <option>Ya (label untuk tiap angka)</option>
            </select>
            <div class="hint mt-1">Jika "Ya", admin bisa isi label 1..5 (di modal bawah).</div>
          </div>

          <button type="button"
                  class="btn btn-ghost rounded-16 w-100"
                  data-bs-toggle="modal"
                  data-bs-target="#modalLabelPerAngka">
              Atur Label Per Angka
          </button>

          <div class="divider-soft my-3"></div>

          <div class="fw-semibold mb-2">Alur Evaluasi</div>
          <ol class="small mb-0">
            <li class="mb-2"><b>Peserta isi Absensi</b> (data diri).</li>
            <li class="mb-2"><b>Peserta isi Evaluasi</b> (rating + komentar).</li>
            <li><b>Sertifikat diproses</b> dan bisa diunduh.</li>
          </ol>

          <div class="hint mt-3">
            *Pengaturan ini hanya tampilan. Backend nanti menyimpan setting skala & label.
          </div>
        </div>
      </div>
    </div>

    {{-- Right: Question List --}}
    <div class="col-lg-8">
      <div class="card card-soft rounded-16">
        <div class="card-body">

          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="fw-semibold">Daftar Pertanyaan Evaluasi</div>
            <div class="muted small">Menampilkan 1–5 dari 11 pertanyaan</div>
          </div>

          {{-- Toolbar Filter (yang aktif) --}}
          <form method="GET" action="{{ route('admin.evaluasi.index') }}">
            <div class="row g-2 align-items-end mb-3 toolbar-row">

              <div class="col-md-6">
                <label class="form-label fw-semibold">Cari pertanyaan</label>
                <input
                  type="text"
                  name="search"
                  class="form-control rounded-16"
                  placeholder="Cari pertanyaan..."
                  value="{{ request('search') }}">
              </div>

              <div class="col-md-3">
                <label class="form-label fw-semibold">Tipe</label>
                <select name="type" class="form-select rounded-16">
                  <option value="">Semua</option>
                  <option value="rating" {{ request('type')=='rating' ? 'selected' : '' }}>Rating</option>
                  <option value="text" {{ request('type')=='text' ? 'selected' : '' }}>Text</option>
                  <option value="textarea" {{ request('type')=='textarea' ? 'selected' : '' }}>Textarea</option>
                </select>
              </div>

              <div class="col-md-3 d-grid">
                <button class="btn btn-brand rounded-16">
                  Terapkan
                </button>
              </div>

            </div>

            <div class="row g-2">
              <div class="col-md-3 d-grid">
                <a href="{{ route('admin.evaluasi.index') }}"
                   class="btn btn-ghost rounded-16">
                  Reset
                </a>
              </div>
            </div>
          </form>

          {{-- Table --}}
          <div class="table-responsive mt-3">
            <table class="table table-hover align-middle table-layout-fixed">
              <thead>
                <tr class="muted">
                  <th class="col-no">No</th>
                  <th>Pertanyaan</th>
                  <th class="col-type">Tipe</th>
                  <th class="col-scale">Skala</th>
                  <th class="col-actions text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($questions as $q)
                  <tr>
                    <td class="fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                      <p class="q-title">{{ $q->question }}</p>
                    </td>
                    <td class="td-center">
                      @if($q->type === 'rating')
                        <span class="badge badge-pill badge-rating">Rating</span>
                      @else
                        <span class="badge badge-pill badge-text">{{ ucfirst($q->type) }}</span>
                      @endif
                    </td>
                    <td class="td-center">
                   @if($q->type === 'rating')
                      <span class="scale-badge">
                        1–{{ $q->rating_max ?? 5 }}
                      </span>
                    @else
                      <span class="scale-badge na">—</span>
                    @endif

                    @if($q->type === 'rating')
                    <button class="btn btn-outline-secondary btn-xs"
                            data-bs-toggle="modal"
                            data-bs-target="#modalScale{{ $q->id }}">
                      Skala
                    </button>
                    @endif

                    </td>
                    <td class="td-actions">
                    {{-- EDIT --}}
                    <button class="btn btn-ghost btn-xs"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditEval{{ $q->id }}">
                        Edit
                    </button>

                    @foreach($questions as $q)
                    @if($q->type === 'rating')
                    <div class="modal fade" id="modalScale{{ $q->id }}" tabindex="-1">
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content rounded-16">

                          <form method="POST"
                                action="{{ route('admin.evaluasi.update', $q->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                              <h5 class="modal-title fw-bold">Atur Skala Rating</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                              {{-- JUMLAH SKALA --}}
                              <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah Skala</label>
                                <input type="number"
                                      name="rating_max"
                                      class="form-control rounded-16"
                                      min="2" max="10"
                                      value="{{ $q->rating_max ?? 5 }}">
                              </div>

                              {{-- LABEL PER ANGKA --}}
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
                              <button type="button"
                                      class="btn btn-ghost rounded-16"
                                      data-bs-dismiss="modal">
                                Batal
                              </button>
                              <button class="btn btn-brand rounded-16">
                                Simpan Skala
                              </button>
                            </div>

                          </form>

                        </div>
                      </div>
                    </div>
                    @endif
                    @endforeach


                    {{-- HAPUS --}}
                    <form method="POST"
                            action="{{ route('admin.evaluasi.destroy', $q->id) }}"
                            class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-xs">
                        Hapus
                        </button>
                    </form>

                    </td>

                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-muted">
                      Belum ada pertanyaan evaluasi
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mt-3">
            <div class="muted small">Halaman 1 dari 3</div>
            <nav aria-label="pagination">
              <ul class="pagination mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
              </ul>
            </nav>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
(function(){
  const minEl = document.getElementById('scaleMin');
  const maxEl = document.getElementById('scaleMax');
  const labelWrap = document.getElementById('labelPerAngkaFields');

  function clampScale(){
    let min = parseInt(minEl?.value ?? 1, 10);
    let max = parseInt(maxEl?.value ?? 5, 10);

    if (isNaN(min)) min = 1;
    if (isNaN(max)) max = 5;

    if (max <= min) max = min + 1;

    const HARD_LIMIT = 20;
    if ((max - min + 1) > HARD_LIMIT) max = min + (HARD_LIMIT - 1);

    if (minEl) minEl.value = min;
    if (maxEl) maxEl.value = max;
    return {min, max};
  }

  function buildLabelFields(){
    if (!labelWrap) return;
    const {min, max} = clampScale();

    labelWrap.innerHTML = '';
    for (let i=min; i<=max; i++){
      const colClass = (i === max && ((max - min + 1) % 2 === 1)) ? 'col-md-12' : 'col-md-6';
      const div = document.createElement('div');
      div.className = colClass;
      div.innerHTML = `
        <label class="form-label fw-semibold">${i}</label>
        <input class="form-control rounded-16" value="">
      `;
      labelWrap.appendChild(div);
    }
  }

  function refreshAll(){
    clampScale();
    buildLabelFields();
  }

  if (minEl) minEl.addEventListener('input', refreshAll);
  if (maxEl) maxEl.addEventListener('input', refreshAll);

  const modalLabel = document.getElementById('modalLabelPerAngka');
  if (modalLabel){
    modalLabel.addEventListener('show.bs.modal', function(){
      buildLabelFields();
    });
  }

  refreshAll();
})();
</script>
@endpush

{{-- MODAL TAMBAH PERTANYAAN --}}
<div class="modal fade" id="modalCreateEval" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-16">
      <form method="POST" action="{{ route('admin.evaluasi.store') }}">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold">Tambah Pertanyaan Evaluasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Pertanyaan</label>
            <input type="text"
                   name="question"
                   class="form-control rounded-16"
                   placeholder="Contoh: Seberapa puas Anda dengan materi webinar?"
                   required>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Tipe Jawaban</label>
              <select name="type" class="form-select rounded-16" required>
                <option value="rating">Rating (1–5)</option>
                <option value="text">Text</option>
                <option value="textarea">Textarea</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Urutan</label>
              <input type="number"
                     name="urutan"
                     class="form-control rounded-16"
                     value="1"
                     min="1"
                     required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-ghost rounded-16" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="submit" class="btn btn-brand rounded-16">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach($questions as $q)
<div class="modal fade" id="modalEditEval{{ $q->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-16">

      <form method="POST"
            action="{{ route('admin.evaluasi.update', $q->id) }}">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold">Edit Pertanyaan Evaluasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label fw-semibold">Pertanyaan</label>
            <input type="text"
                   name="question"
                   class="form-control rounded-16"
                   value="{{ $q->question }}"
                   required>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Tipe Jawaban</label>
              <select name="type" class="form-select rounded-16" required>
                <option value="rating" {{ $q->type=='rating'?'selected':'' }}>Rating</option>
                <option value="text" {{ $q->type=='text'?'selected':'' }}>Text</option>
                <option value="textarea" {{ $q->type=='textarea'?'selected':'' }}>Textarea</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Urutan</label>
              <input type="number"
                     name="urutan"
                     class="form-control rounded-16"
                     value="{{ $q->urutan }}"
                     min="1"
                     required>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button"
                  class="btn btn-ghost rounded-16"
                  data-bs-dismiss="modal">
            Batal
          </button>
          <button class="btn btn-brand rounded-16">
            Simpan Perubahan
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
@endforeach

@endsection