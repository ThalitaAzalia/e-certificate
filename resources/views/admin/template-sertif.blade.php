@extends('layouts.app')

@section('title', 'Template Sertifikat')

@push('head')
<style>
  :root {
    --brand: #b91c1c;
    --brand-2: #dc2626;
    --brand-3: #991b1b;
    --bg-page: #fafafa;
    --bg-card: #ffffff;
    --border-soft: rgba(185, 28, 28, 0.12);
    --ink: #111827;
    --muted: #6b7280;
    --shadow-soft: 0 2px 8px rgba(185, 28, 28, 0.05);
  }

  body { 
    background: var(--bg-page); 
    font-family: 'Inter', -apple-system, sans-serif;
    color: var(--ink);
  }

  .page-title {
    font-weight: 900;
    letter-spacing: -0.025em;
    color: var(--brand-3);
    font-size: 1.75rem;
    line-height: 1.1;
  }

  .card-soft {
    background: var(--bg-card) !important;
    border: 1px solid var(--border-soft);
    border-radius: 12px;
    box-shadow: var(--shadow-soft);
  }

  .btn-brand {
    background: var(--brand);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
    transition: background 0.2s;
  }

  .btn-brand:hover {
    background: var(--brand-2);
    color: white;
  }

  .btn-ghost {
    border: 1px solid rgba(185, 28, 28, 0.2);
    background: white;
    color: var(--brand);
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
    transition: all 0.2s;
  }

  .btn-ghost:hover {
    background: rgba(185, 28, 28, 0.05);
    color: var(--brand-3);
  }

  .badge-pill {
    border-radius: 50px;
    padding: 0.25rem 0.75rem;
    font-weight: 600;
    font-size: 0.75rem;
    border: 1px solid;
  }

  .badge-active {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    border-color: rgba(46, 125, 50, 0.2);
  }

  .badge-inactive {
    background: rgba(156, 163, 175, 0.1);
    color: #6b7280;
    border-color: rgba(156, 163, 175, 0.2);
  }

  .badge-count {
    background: rgba(185, 28, 28, 0.08);
    color: var(--brand-3);
    border-color: rgba(185, 28, 28, 0.15);
  }

  .form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    transition: all 0.2s;
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
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  }

  .template-thumb {
    width: 80px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid rgba(185, 28, 28, 0.15);
    background: #fff;
  }

  .preview-container {
    background: #fff;
    border: 1px solid rgba(185, 28, 28, 0.15);
    border-radius: 12px;
    padding: 1.25rem;
  }

  .preview-stage {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    background: #f8fafc;
    border-radius: 10px;
    overflow: hidden;
    margin: 0 auto;
  }

  .preview-image {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: white;
  }

  .draggable-box {
    position: absolute;
    border: 2px dashed rgba(185, 28, 28, 0.35);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(2px);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: move;
    user-select: none;
    transition: all 0.2s;
  }

  .draggable-box:hover {
    border-color: rgba(185, 28, 28, 0.6);
    background: rgba(255, 255, 255, 0.95);
  }

  .draggable-box.dragging {
    border-style: solid;
    border-color: var(--brand);
    box-shadow: 0 8px 20px rgba(185, 28, 28, 0.15);
  }

  .draggable-text {
    padding: 0.75rem;
    text-align: center;
    word-break: break-word;
    width: 100%;
  }

  .range-slider {
    width: 100%;
    height: 6px;
    -webkit-appearance: none;
    appearance: none;
    background: #e5e7eb;
    border-radius: 3px;
    outline: none;
  }

  .range-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--brand);
    cursor: pointer;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .range-value {
    min-width: 3rem;
    text-align: center;
    font-weight: 600;
    color: var(--ink);
    font-size: 0.875rem;
    background: rgba(185, 28, 28, 0.06);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    border: 1px solid rgba(185, 28, 28, 0.15);
  }

  .divider {
    height: 1px;
    background: rgba(185, 28, 28, 0.12);
    margin: 1rem 0;
    border: none;
  }

  .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
  }

  .btn-outline-success, .btn-outline-danger {
    border-radius: 6px;
  }

  .text-muted { color: var(--muted) !important; }

  .card-soft .card-body { padding: 1.25rem; }

  .form-label { 
    margin-bottom: .35rem; 
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--ink);
  }

  .helper-text {
    font-size: 0.8125rem;
    color: var(--muted);
    margin-top: 0.25rem;
    line-height: 1.4;
  }

  .empty-state {
    text-align: center;
    padding: 2rem 1rem;
    color: var(--muted);
  }

  .empty-state-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    opacity: 0.5;
  }
</style>
@endpush

@section('content')
<div class="container py-4">

{{-- HEADER --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
  <div>
    <h1 class="page-title mb-2">Template Sertifikat</h1>
    <p class="text-muted mb-0">
      Kelola template sertifikat, atur posisi nama peserta, dan lihat preview.
    </p>
  </div>
  
  <div class="d-flex gap-2">
    <button class="btn btn-brand d-flex align-items-center gap-1" 
            data-bs-toggle="modal" 
            data-bs-target="#modalCreateTemplate">
      <i class="fas fa-plus fa-sm"></i>
      <span>Upload Template</span>
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

<div class="row g-4">
  {{-- LEFT COLUMN: SETTINGS --}}
  <div class="col-lg-4">
    <div class="card card-soft">
      <div class="card-body">
        <h5 class="fw-semibold mb-3">Pengaturan Teks Nama</h5>
        <p class="text-muted mb-3">Atur posisi dan gaya teks nama pada sertifikat.</p>

        <div class="mb-3">
          <label class="form-label">Pilih Template</label>
          <select id="templateSelect" class="form-select">
            @foreach ($templates as $template)
              <option
                value="{{ $template->id }}"
                data-image="{{ asset('certificates/'.$template->file_name) }}"
                data-pos-x="{{ $template->box_x ?? 50 }}"
                data-pos-y="{{ $template->box_y ?? 55 }}"
                data-box-width="{{ $template->box_width ?? 40 }}"
                data-box-height="{{ $template->box_height ?? 10 }}"
                data-font-family="{{ $template->font_family ?? 'Arial, Helvetica, sans-serif' }}"
                data-font-size="{{ $template->font_size ?? 44 }}"
                data-font-color="{{ $template->font_color ?? '#111827' }}"
                data-font-weight="{{ $template->font_weight ?? '700' }}"
                data-font-style="{{ $template->font_style ?? 'normal' }}"
                data-text-align="{{ $template->text_align ?? 'center' }}"
                data-letter-spacing="{{ $template->letter_spacing ?? 1 }}"
                data-line-height="{{ $template->line_height ?? 1.1 }}"
              >
                {{ $template->name }}
              </option>
            @endforeach
          </select>
          <div class="helper-text">Pilih template untuk mulai mengatur posisi teks</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama Preview</label>
          <input id="nameInput" class="form-control" value="NAMA PESERTA" />
          <div class="helper-text">Nama ini akan ditampilkan pada preview</div>
        </div>

        <div class="divider"></div>

        <h6 class="fw-semibold mb-3">Posisi Teks</h6>
        
        <div class="row g-3 mb-3">
          <div class="col-6">
            <label class="form-label">Posisi X</label>
            <div class="d-flex align-items-center gap-2">
              <input id="posX" type="range" class="range-slider" min="0" max="100" value="50" />
              <div id="posXVal" class="range-value">50%</div>
            </div>
            <div class="helper-text">0% kiri • 100% kanan</div>
          </div>
          <div class="col-6">
            <label class="form-label">Posisi Y</label>
            <div class="d-flex align-items-center gap-2">
              <input id="posY" type="range" class="range-slider" min="0" max="100" value="55" />
              <div id="posYVal" class="range-value">55%</div>
            </div>
            <div class="helper-text">0% atas • 100% bawah</div>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-6">
            <label class="form-label">Lebar Box</label>
            <input id="boxWidth" type="number" class="form-control" value="40" min="5" max="100">
            <div class="helper-text">% dari lebar</div>
          </div>
          <div class="col-6">
            <label class="form-label">Tinggi Box</label>
            <input id="boxHeight" type="number" class="form-control" value="10" min="3" max="100">
            <div class="helper-text">% dari tinggi</div>
          </div>
        </div>

        <div class="divider"></div>

        <h6 class="fw-semibold mb-3">Pengaturan Tipografi</h6>
        
        <div class="row g-2 mb-2">
          <div class="col-7">
            <label class="form-label">Font</label>
            <select id="fontFamily" class="form-select">
              <option value="Georgia, serif">Georgia</option>
              <option value='"Times New Roman", Times, serif'>Times New Roman</option>
              <option value="Arial, Helvetica, sans-serif">Arial</option>
              <option value='"Trebuchet MS", sans-serif'>Trebuchet MS</option>
              <option value='"Courier New", Courier, monospace'>Courier New</option>
            </select>
          </div>
          <div class="col-5">
            <label class="form-label">Ukuran (px)</label>
            <input id="fontSize" type="number" class="form-control" value="44" min="8" max="140">
          </div>
        </div>

        <div class="row g-2 mb-2">
          <div class="col-6">
            <label class="form-label">Warna</label>
            <input id="fontColor" type="color" class="form-control form-control-color" value="#111827">
          </div>
          <div class="col-6">
            <label class="form-label">Perataan</label>
            <select id="textAlign" class="form-select">
              <option value="left">Kiri</option>
              <option value="center">Tengah</option>
              <option value="right">Kanan</option>
            </select>
          </div>
        </div>

        <div class="row g-2 mb-3">
          <div class="col-6">
            <label class="form-label">Tebal</label>
            <select id="fontWeight" class="form-select">
              <option value="400">Normal</option>
              <option value="600">Semibold</option>
              <option value="700">Bold</option>
              <option value="800">Extra Bold</option>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label">Italic</label>
            <select id="fontStyle" class="form-select">
              <option value="normal">Tidak</option>
              <option value="italic">Ya</option>
            </select>
          </div>
        </div>

        <div class="row g-2 mb-3">
          <div class="col-6">
            <label class="form-label">Letter Spacing (px)</label>
            <input id="letterSpacing" type="number" class="form-control" value="1" min="-2" max="20">
          </div>
          <div class="col-6">
            <label class="form-label">Line Height</label>
            <input id="lineHeight" type="number" class="form-control" value="1.1" step="0.05" min="0.8" max="2">
          </div>
        </div>

        <div class="divider"></div>

        <div class="d-flex gap-2">
          <button type="button" class="btn btn-ghost flex-grow-1" id="btnResetStyle">
            Reset
          </button>
          <button type="button" class="btn btn-brand flex-grow-1" id="btnSaveSetting">
            Simpan Setting
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- RIGHT COLUMN: TEMPLATES & PREVIEW --}}
  <div class="col-lg-8">
    <div class="card card-soft">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex align-items-center gap-3">
            <h5 class="fw-semibold mb-0">Daftar Template</h5>
            <span class="badge-pill badge-count">{{ count($templates) }} template</span>
            <span class="badge-pill badge-count">
              Drag: <span id="dragStatus">ON</span>
            </span>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-ghost btn-sm" id="btnToggleDrag">
              Toggle Drag
            </button>
          </div>
        </div>

        @if($templates->isEmpty())
        <div class="empty-state">
          <div class="empty-state-icon">
            <i class="fas fa-certificate"></i>
          </div>
          <p class="text-muted">Belum ada template sertifikat</p>
          <button class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateTemplate">
            Upload Template Pertama
          </button>
        </div>
        @else
        <div class="table-responsive mb-4">
          <table class="table table-hover align-middle">
            <thead class="table-header">
              <tr>
                <th style="width: 80px;">Preview</th>
                <th>Nama Template</th>
                <th style="width: 120px;">Status</th>
                <th style="width: 180px;" class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($templates as $template)
              <tr>
                <td>
                  <img class="template-thumb" src="{{ asset('certificates/'.$template->file_name) }}" alt="{{ $template->name }}">
                </td>
                <td>
                  <div class="fw-semibold">{{ $template->name }}</div>
                  <div class="text-muted small">{{ $template->file_name }}</div>
                </td>
                <td>
                  @if($template->is_active)
                    <span class="badge-pill badge-active">Aktif</span>
                  @else
                    <span class="badge-pill badge-inactive">Nonaktif</span>
                  @endif
                </td>
                <td class="text-end">
                  <div class="d-inline-flex gap-2">
                    @if(!$template->is_active)
                      <form method="POST" action="{{ route('admin.template-sertifikat.activate', $template->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-success btn-sm">
                          Aktifkan
                        </button>
                      </form>
                    @endif

                    <form method="POST"
                      action="{{ route('admin.template-sertifikat.destroy', $template->id) }}"
                      onsubmit="return confirm('Yakin ingin menghapus template ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                        Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif

        <div class="preview-container">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-semibold mb-0">Preview Sertifikat</h6>
            <div class="d-flex gap-2">
              <button class="btn btn-ghost btn-sm" id="btnCenterName">
                Pusatkan Nama
              </button>
              <button class="btn btn-ghost btn-sm" id="btnFitToSafe">
                Posisi Aman
              </button>
            </div>
          </div>

          <div class="preview-stage" id="previewStageMain">
            <img id="previewImgMain"
                 class="preview-image"
                 src="https://dummyimage.com/1600x900/ffffff/111827&text=Pilih+Template"
                 alt="Template Preview">

            <div id="nameBoxMain" class="draggable-box">
              <div id="nameTextMain" class="draggable-text">NAMA PESERTA</div>
            </div>
          </div>

          <div class="text-center mt-3">
            <p class="helper-text mb-0">
              Tips: Geser slider atau drag teks nama langsung di preview
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- MODAL: UPLOAD TEMPLATE --}}
<div class="modal fade" id="modalCreateTemplate" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.template-sertifikat.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Upload Template Sertifikat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nama Template</label>
              <input type="text" name="name" class="form-control" 
                     placeholder="Contoh: Sertifikat Webinar Januari" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Status</label>
              <select class="form-select" disabled>
                <option selected>Nonaktif</option>
              </select>
              <div class="helper-text">Template baru otomatis nonaktif.</div>
            </div>

            <div class="col-12">
              <label class="form-label">File Template (PNG / JPG)</label>
              <input type="file" name="file" id="uploadTemplateInput" 
                     class="form-control" accept="image/png,image/jpeg" required>
              <div class="helper-text">Rekomendasi: 1920×1080 (landscape)</div>
            </div>

            <div id="ratioWarning" class="alert alert-warning mt-2 d-none">
              <div class="d-flex gap-2">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                  <strong class="d-block">Rasio Template Tidak 16:9</strong>
                  <div class="small mt-1">
                    Template yang diunggah tidak menggunakan rasio 16:9.
                    Disarankan agar posisi teks tetap konsisten saat generate sertifikat.
                  </div>
                </div>
              </div>
            </div>

            <div id="forceUploadWrapper" class="form-check mt-2 d-none">
              <input class="form-check-input" type="checkbox" id="forceUpload">
              <label class="form-check-label" for="forceUpload">
                Saya mengerti dan tetap ingin mengunggah template ini
              </label>
            </div>

            <div class="col-12">
              <label class="form-label">Preview Upload</label>
              <div class="preview-stage" style="aspect-ratio:16/9;">
                <img id="uploadPreviewImg" class="preview-image"
                     src="https://dummyimage.com/1600x900/f3f4f6/374151&text=Preview+Upload">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-brand" id="btnSubmitTemplate" disabled>
            Simpan Template
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- MODAL: PREVIEW FULL --}}
<div class="modal fade" id="modalPreviewEval" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Preview Sertifikat (Fullscreen)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="preview-stage" id="previewStageModal">
          <img id="previewImgModal" class="preview-image" src="" alt="Template Preview">
          <div id="nameBoxModal" class="draggable-box">
            <div id="nameTextModal" class="draggable-text">NAMA PESERTA</div>
          </div>
        </div>
        <div class="helper-text mt-2 text-center">
          Preview ini mengikuti setting dari panel kiri.
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-ghost" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
(function () {
  'use strict';

  // Elements
  const templateSelect = document.getElementById('templateSelect');
  const nameInput = document.getElementById('nameInput');
  const posX = document.getElementById('posX');
  const posY = document.getElementById('posY');
  const posXVal = document.getElementById('posXVal');
  const posYVal = document.getElementById('posYVal');
  const boxWidthInput = document.getElementById('boxWidth');
  const boxHeightInput = document.getElementById('boxHeight');
  const fontFamily = document.getElementById('fontFamily');
  const fontSize = document.getElementById('fontSize');
  const fontColor = document.getElementById('fontColor');
  const fontWeight = document.getElementById('fontWeight');
  const fontStyle = document.getElementById('fontStyle');
  const textAlign = document.getElementById('textAlign');
  const letterSpacing = document.getElementById('letterSpacing');
  const lineHeight = document.getElementById('lineHeight');
  const previewImgMain = document.getElementById('previewImgMain');
  const previewStageMain = document.getElementById('previewStageMain');
  const nameBoxMain = document.getElementById('nameBoxMain');
  const nameTextMain = document.getElementById('nameTextMain');
  const previewImgModal = document.getElementById('previewImgModal');
  const nameBoxModal = document.getElementById('nameBoxModal');
  const nameTextModal = document.getElementById('nameTextModal');
  const btnResetStyle = document.getElementById('btnResetStyle');
  const btnCenterName = document.getElementById('btnCenterName');
  const btnFitToSafe = document.getElementById('btnFitToSafe');
  const btnToggleDrag = document.getElementById('btnToggleDrag');
  const dragStatus = document.getElementById('dragStatus');
  const btnOpenPreview = document.getElementById('btnOpenPreview');
  const btnSaveSetting = document.getElementById('btnSaveSetting');
  const uploadTemplateInput = document.getElementById('uploadTemplateInput');
  const uploadPreviewImg = document.getElementById('uploadPreviewImg');
  const ratioWarning = document.getElementById('ratioWarning');
  const forceUploadWrapper = document.getElementById('forceUploadWrapper');
  const forceUpload = document.getElementById('forceUpload');
  const btnSubmitTemplate = document.getElementById('btnSubmitTemplate');

  let dragEnabled = true;
  let isDragging = false;
  let dragOffsetX = 0;
  let dragOffsetY = 0;

  // Helper Functions
  function getPreviewScale() {
    const designWidth = 1920;
    const stageWidth = previewStageMain.clientWidth;
    return stageWidth / designWidth;
  }

  function clamp(n, min, max) {
    return Math.max(min, Math.min(max, n));
  }

  function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'success-toast';
    toast.innerHTML = `
      <div class="d-flex align-items-center gap-2">
        <i class="fas fa-check-circle"></i>
        <span>${message}</span>
      </div>
    `;
    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  }

  function applyBoxSize() {
    const w = parseFloat(boxWidthInput.value) || 40;
    const h = parseFloat(boxHeightInput.value) || 10;

    nameBoxMain.style.width = w + '%';
    nameBoxMain.style.height = h + '%';
    nameBoxModal.style.width = w + '%';
    nameBoxModal.style.height = h + '%';
  }

  function setNamePositionPercent(xPct, yPct) {
    const x = clamp(Math.round(xPct), 0, 100);
    const y = clamp(Math.round(yPct), 0, 100);

    posX.value = x;
    posY.value = y;
    posXVal.textContent = x + '%';
    posYVal.textContent = y + '%';

    nameBoxMain.style.left = x + '%';
    nameBoxMain.style.top = y + '%';
    nameBoxModal.style.left = x + '%';
    nameBoxModal.style.top = y + '%';
  }

  function applyNameStyles() {
    const txt = nameInput.value || 'NAMA PESERTA';
    const scale = getPreviewScale();

    const styles = {
      fontFamily: fontFamily.value,
      fontSize: (fontSize.value * scale) + 'px',
      color: fontColor.value,
      fontWeight: fontWeight.value,
      fontStyle: fontStyle.value,
      textAlign: textAlign.value,
      letterSpacing: (letterSpacing.value * scale) + 'px',
      lineHeight: lineHeight.value || 1.1
    };

    nameTextMain.textContent = txt;
    Object.assign(nameTextMain.style, styles);

    nameTextModal.textContent = txt;
    Object.assign(nameTextModal.style, styles);
  }

  function loadTemplateFromDB() {
    const option = templateSelect.options[templateSelect.selectedIndex];
    if (!option) return;

    // Load image
    const imageSrc = option.dataset.image || '';
    previewImgMain.src = imageSrc;
    previewImgModal.src = imageSrc;

    // Load position
    const dbPosX = parseFloat(option.dataset.posX) || 50;
    const dbPosY = parseFloat(option.dataset.posY) || 55;
    setNamePositionPercent(dbPosX, dbPosY);

    // Load box size
    const dbBoxWidth = parseFloat(option.dataset.boxWidth) || 40;
    const dbBoxHeight = parseFloat(option.dataset.boxHeight) || 10;
    boxWidthInput.value = dbBoxWidth;
    boxHeightInput.value = dbBoxHeight;
    applyBoxSize();

    // Load font settings
    fontFamily.value = option.dataset.fontFamily || 'Arial, Helvetica, sans-serif';
    fontSize.value = option.dataset.fontSize || 44;
    fontColor.value = option.dataset.fontColor || '#111827';
    fontWeight.value = option.dataset.fontWeight || '700';
    fontStyle.value = option.dataset.fontStyle || 'normal';
    textAlign.value = option.dataset.textAlign || 'center';
    letterSpacing.value = option.dataset.letterSpacing || 1;
    lineHeight.value = option.dataset.lineHeight || 1.1;

    applyNameStyles();
  }

  // Event Listeners
  if (templateSelect) {
    templateSelect.addEventListener('change', loadTemplateFromDB);
  }

  posX.addEventListener('input', () => setNamePositionPercent(posX.value, posY.value));
  posY.addEventListener('input', () => setNamePositionPercent(posX.value, posY.value));

  boxWidthInput.addEventListener('input', applyBoxSize);
  boxHeightInput.addEventListener('input', applyBoxSize);

  [nameInput, fontFamily, fontSize, fontColor, fontWeight, fontStyle, 
   textAlign, letterSpacing, lineHeight].forEach(el => {
    if (el) el.addEventListener('input', applyNameStyles);
  });

  if (btnResetStyle) {
    btnResetStyle.addEventListener('click', () => {
      nameInput.value = 'NAMA PESERTA';
      boxWidthInput.value = 40;
      boxHeightInput.value = 10;
      fontFamily.value = 'Arial, Helvetica, sans-serif';
      fontSize.value = 44;
      fontColor.value = '#111827';
      fontWeight.value = '700';
      fontStyle.value = 'normal';
      textAlign.value = 'center';
      letterSpacing.value = 1;
      lineHeight.value = 1.1;
      setNamePositionPercent(50, 55);
      applyBoxSize();
      applyNameStyles();
      showToast('Pengaturan direset ke default');
    });
  }

  if (btnCenterName) {
    btnCenterName.addEventListener('click', () => {
      setNamePositionPercent(50, 50);
      showToast('Nama dipusatkan');
    });
  }

  if (btnFitToSafe) {
    btnFitToSafe.addEventListener('click', () => {
      setNamePositionPercent(50, 55);
      showToast('Posisi diatur ke area aman');
    });
  }

  if (btnToggleDrag) {
    btnToggleDrag.addEventListener('click', () => {
      dragEnabled = !dragEnabled;
      dragStatus.textContent = dragEnabled ? 'ON' : 'OFF';
      nameBoxMain.style.cursor = dragEnabled ? 'move' : 'default';
      showToast(`Drag ${dragEnabled ? 'diaktifkan' : 'dinonaktifkan'}`);
    });
  }

  if (btnSaveSetting) {
    btnSaveSetting.addEventListener('click', function () {
      const templateId = templateSelect.value;
      if (!templateId) {
        alert('Pilih template terlebih dahulu');
        return;
      }

      const payload = {
        box_x: posX.value,
        box_y: posY.value,
        box_width: boxWidthInput.value,
        box_height: boxHeightInput.value,
        font_family: fontFamily.value,
        font_size: fontSize.value,
        font_color: fontColor.value,
        font_weight: fontWeight.value,
        font_style: fontStyle.value,
        letter_spacing: letterSpacing.value,
        line_height: lineHeight.value,
        text_align: textAlign.value,
        _token: '{{ csrf_token() }}'
      };

      btnSaveSetting.disabled = true;
      btnSaveSetting.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';

      fetch(`/admin/template-sertifikat/${templateId}/setting`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      })
      .then(res => res.json())
      .then(data => {
        showToast(data.message || 'Setting berhasil disimpan!');
        
        // Update dataset
        const option = templateSelect.options[templateSelect.selectedIndex];
        option.dataset.posX = payload.box_x;
        option.dataset.posY = payload.box_y;
        option.dataset.boxWidth = payload.box_width;
        option.dataset.boxHeight = payload.box_height;
        option.dataset.fontFamily = payload.font_family;
        option.dataset.fontSize = payload.font_size;
        option.dataset.fontColor = payload.font_color;
        option.dataset.fontWeight = payload.font_weight;
        option.dataset.fontStyle = payload.font_style;
        option.dataset.textAlign = payload.text_align;
        option.dataset.letterSpacing = payload.letter_spacing;
        option.dataset.lineHeight = payload.line_height;
      })
      .catch(err => {
        console.error(err);
        alert('Gagal menyimpan setting');
      })
      .finally(() => {
        btnSaveSetting.disabled = false;
        btnSaveSetting.textContent = 'Simpan Setting';
      });
    });
  }

  // Drag functionality
  nameBoxMain.addEventListener('mousedown', function (e) {
    if (!dragEnabled) return;
    
    e.preventDefault();
    isDragging = true;
    nameBoxMain.classList.add('dragging');

    const rect = nameBoxMain.getBoundingClientRect();
    dragOffsetX = e.clientX - rect.left;
    dragOffsetY = e.clientY - rect.top;
  });

  document.addEventListener('mousemove', function (e) {
    if (!isDragging) return;

    const stageRect = previewStageMain.getBoundingClientRect();
    const boxRect = nameBoxMain.getBoundingClientRect();

    let x = e.clientX - stageRect.left - dragOffsetX;
    let y = e.clientY - stageRect.top - dragOffsetY;

    x = clamp(x, 0, stageRect.width - boxRect.width);
    y = clamp(y, 0, stageRect.height - boxRect.height);

    const xPct = (x / stageRect.width) * 100;
    const yPct = (y / stageRect.height) * 100;

    setNamePositionPercent(xPct, yPct);
  });

  document.addEventListener('mouseup', function () {
    if (isDragging) {
      isDragging = false;
      nameBoxMain.classList.remove('dragging');
    }
  });

  // Upload validation
  if (uploadTemplateInput) {
    uploadTemplateInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const img = new Image();
      const objectUrl = URL.createObjectURL(file);

      img.onload = function () {
        const ratio = this.width / this.height;
        const is16by9 = Math.abs(ratio - (16 / 9)) < 0.02;

        uploadPreviewImg.src = objectUrl;

        if (!is16by9) {
          ratioWarning.classList.remove('d-none');
          forceUploadWrapper.classList.remove('d-none');
          btnSubmitTemplate.disabled = true;
          forceUpload.checked = false;
        } else {
          ratioWarning.classList.add('d-none');
          forceUploadWrapper.classList.add('d-none');
          btnSubmitTemplate.disabled = false;
        }

        URL.revokeObjectURL(objectUrl);
      };

      img.src = objectUrl;
    });
  }

  if (forceUpload) {
    forceUpload.addEventListener('change', function () {
      btnSubmitTemplate.disabled = !this.checked;
    });
  }

  // Initialize
  if (templateSelect && templateSelect.options.length > 0) {
    loadTemplateFromDB();
  }

})();
</script>
@endpush
@endsection