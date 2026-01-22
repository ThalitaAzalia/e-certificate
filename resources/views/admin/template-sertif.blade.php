@extends('layouts.app')

@section('title', 'Template Sertifikat')

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

  .form-control:focus, .form-select:focus{
    border-color: rgba(185,28,28,.55);
    box-shadow: 0 0 0 .25rem rgba(185,28,28,.18);
  }

  .hint{ font-size:.875rem; color: var(--muted); }
  .divider-soft{ height:1px; background: rgba(185,28,28,.14); border-radius:999px; }

  .preview-shell{
    background: rgba(255,255,255,.55);
    border: 1px dashed rgba(185,28,28,.25);
    border-radius: 16px;
    padding: 12px;
  }

  .preview-stage {
    position: relative;
    width: 100%;
    max-width: 960px;
    aspect-ratio: 16 / 9;
    background: #fff;
    margin: 0 auto;
    overflow: hidden;
  }

  .preview-img{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    pointer-events: none;
  }

  .name-box {
    position: absolute;
    border: 2px dashed rgba(220, 38, 38, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    cursor: move;
    user-select: none;
    transition: border-color 0.2s;
  }

  .name-box:hover {
    border-color: rgba(220, 38, 38, 0.8);
  }

  .name-box.dragging {
    border-color: var(--brand);
    border-style: solid;
    cursor: grabbing;
  }

  .name-text {
    width: 100%;
    padding: 8px;
    white-space: normal;
    word-break: break-word;
  }

  .toolbar-mini{
    display:flex;
    gap:8px;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
  }

  .chip{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:.35rem .6rem;
    border-radius:999px;
    font-weight:800;
    font-size:.85rem;
    border:1px solid rgba(185,28,28,.20);
    background: rgba(185,28,28,.06);
    color: var(--brand-3);
  }

  .table td, .table th{ vertical-align: middle; }
  thead tr{ background: rgba(185,28,28,.06); }

  .thumb{
    width: 84px;
    height: 52px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid rgba(185,28,28,.18);
    background: #fff;
  }

  input[type="range"]{ width: 100%; }
  .range-row{ display:flex; gap:10px; align-items:center; }
  .range-val{
    min-width: 64px;
    text-align: right;
    font-weight: 800;
    color: var(--ink);
  }

  .sticky-actions{
    position: sticky;
    bottom: 0;
    background: linear-gradient(180deg, rgba(255,245,245,0), rgba(255,245,245,1) 40%);
    padding-top: 10px;
    margin-top: 6px;
  }

  .success-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #10b981;
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    z-index: 9999;
    animation: slideIn 0.3s ease-out;
  }

  @keyframes slideIn {
    from {
      transform: translateX(400px);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }
</style>
@endpush

@section('content')
<div class="container py-3">

  {{-- Header --}}
  <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
    <div>
      <h1 class="page-title mb-1">Template Sertifikat</h1>
      <div class="muted">
        Upload template, kelola (CRUD), atur posisi & font nama peserta, dan preview sertifikat.
      </div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
      <button class="btn btn-brand rounded-16" data-bs-toggle="modal" data-bs-target="#modalCreateTemplate">
        + Upload Template
      </button>
      <button class="btn btn-ghost rounded-16" id="btnOpenPreview">
        Preview Sertif
      </button>
      <a href="{{ url('/admin/dashboard') }}" class="btn btn-ghost rounded-16">Kembali</a>
    </div>
  </div>

  <div class="row g-4">
    {{-- LEFT: Settings --}}
    <div class="col-lg-4">
      <div class="card card-soft rounded-16">
        <div class="card-body">
          <div class="fw-semibold mb-2">Pengaturan Nama di Sertifikat</div>
          <div class="hint">Atur posisi dan gaya teks nama. Simulasi real-time di panel preview.</div>

          <div class="divider-soft my-3"></div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Template</label>
            <select id="templateSelect" class="form-select rounded-16">
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
            <div class="hint mt-1">
              Pilih template untuk langsung melihat preview sertifikat.
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Nama (contoh preview)</label>
            <input id="nameInput" class="form-control rounded-16" value="NAMA PESERTA" />
          </div>

          <div class="row g-2">
            <div class="col-6">
              <label class="form-label fw-semibold">Posisi X (%)</label>
              <div class="range-row">
                <input id="posX" type="range" min="0" max="100" value="50" />
                <div id="posXVal" class="range-val">50%</div>
              </div>
              <div class="hint">0 kiri • 100 kanan</div>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Posisi Y (%)</label>
              <div class="range-row">
                <input id="posY" type="range" min="0" max="100" value="55" />
                <div id="posYVal" class="range-val">55%</div>
              </div>
              <div class="hint">0 atas • 100 bawah</div>
            </div>
          </div>

          <div class="divider-soft my-3"></div>
          <div class="fw-semibold mb-2">Ukuran Text Box</div>

          <div class="row g-2">
            <div class="col-6">
              <label class="form-label fw-semibold">Lebar Box (%)</label>
              <input id="boxWidth" type="number" class="form-control rounded-16" value="40" min="5" max="100">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Tinggi Box (%)</label>
              <input id="boxHeight" type="number" class="form-control rounded-16" value="10" min="3" max="100">
            </div>
          </div>

          <div class="divider-soft my-3"></div>

          <div class="row g-2">
            <div class="col-7">
              <label class="form-label fw-semibold">Font</label>
              <select id="fontFamily" class="form-select rounded-16">
                <option value="Georgia, serif">Georgia</option>
                <option value='"Times New Roman", Times, serif'>Times New Roman</option>
                <option value="Arial, Helvetica, sans-serif">Arial</option>
                <option value='"Trebuchet MS", sans-serif'>Trebuchet MS</option>
                <option value='"Courier New", Courier, monospace'>Courier New</option>
              </select>
            </div>
            <div class="col-5">
              <label class="form-label fw-semibold">Ukuran (px)</label>
              <input id="fontSize" type="number" class="form-control rounded-16" value="44" min="8" max="140">
            </div>
          </div>

          <div class="row g-2 mt-2">
            <div class="col-6">
              <label class="form-label fw-semibold">Warna</label>
              <input id="fontColor" type="color" class="form-control form-control-color rounded-16" value="#111827">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Perataan</label>
              <select id="textAlign" class="form-select rounded-16">
                <option value="left">Kiri</option>
                <option value="center">Tengah</option>
                <option value="right">Kanan</option>
              </select>
            </div>
          </div>

          <div class="row g-2 mt-2">
            <div class="col-6">
              <label class="form-label fw-semibold">Tebal</label>
              <select id="fontWeight" class="form-select rounded-16">
                <option value="400">Normal</option>
                <option value="600">Semi Bold</option>
                <option value="700">Bold</option>
                <option value="800">Extra Bold</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Italic</label>
              <select id="fontStyle" class="form-select rounded-16">
                <option value="normal">Off</option>
                <option value="italic">On</option>
              </select>
            </div>
          </div>

          <div class="row g-2 mt-2">
            <div class="col-6">
              <label class="form-label fw-semibold">Letter Spacing (px)</label>
              <input id="letterSpacing" type="number" class="form-control rounded-16" value="1" min="-2" max="20">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Line Height</label>
              <input id="lineHeight" type="number" class="form-control rounded-16" value="1.1" step="0.05" min="0.8" max="2">
            </div>
          </div>

          <div class="divider-soft my-3"></div>

          <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-ghost rounded-16" id="btnResetStyle">Reset</button>
            <button type="button" class="btn btn-brand rounded-16 flex-grow-1" id="btnSaveSetting">
              Simpan Setting
            </button>
          </div>

          <div class="hint mt-2">
            Klik "Simpan Setting" untuk menyimpan konfigurasi ke database.
          </div>
        </div>
      </div>
    </div>

    {{-- RIGHT: List + Preview --}}
    <div class="col-lg-8">
      <div class="card card-soft rounded-16">
        <div class="card-body">
          <div class="toolbar-mini mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <div class="fw-semibold">Daftar Template</div>
              <span class="chip">{{ count($templates) }} template</span>
              <span class="chip">Drag: <span id="dragStatus">ON</span></span>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-ghost rounded-16 btn-sm" id="btnToggleDrag">Toggle Drag</button>
            </div>
          </div>

          <div class="row g-3">
            {{-- Table --}}
            <div class="col-12">
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead>
                    <tr class="muted">
                      <th style="width:72px;">Preview</th>
                      <th>Nama Template</th>
                      <th style="width:160px;">Status</th>
                      <th style="width:220px;" class="text-end">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  @forelse ($templates as $template)
                  <tr>
                    <td>
                      <img class="thumb" src="{{ asset('certificates/'.$template->file_name) }}">
                    </td>
                    <td>
                      <div class="fw-semibold">{{ $template->name }}</div>
                      <div class="small muted">{{ $template->file_name }}</div>
                    </td>
                    <td>
                      @if($template->is_active)
                        <span class="chip">Aktif</span>
                      @else
                        <span class="chip">Nonaktif</span>
                      @endif
                    </td>
                    <td class="text-end">
                      <div class="d-inline-flex gap-2">
                        @if(!$template->is_active)
                          <form method="POST" action="{{ route('admin.template-sertifikat.activate', $template->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-success rounded-16 btn-sm">
                              Aktifkan
                            </button>
                          </form>
                        @else
                          <span class="chip">Digunakan</span>
                        @endif

                        <form method="POST"
                          action="{{ route('admin.template-sertifikat.destroy', $template->id) }}"
                          onsubmit="return confirm('Yakin ingin menghapus template ini?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-outline-danger rounded-16 btn-sm">
                            Hapus
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center muted">
                      Belum ada template sertifikat
                    </td>
                  </tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            {{-- Preview --}}
            <div class="col-12">
              <div class="preview-shell">
                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-2">
                  <div class="fw-semibold">Preview Sertifikat</div>
                  <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-ghost rounded-16 btn-sm" id="btnCenterName">Pusatkan Nama</button>
                    <button class="btn btn-ghost rounded-16 btn-sm" id="btnFitToSafe">Posisi Aman</button>
                  </div>
                </div>

                <div class="preview-stage" id="previewStageMain">
                  <img id="previewImgMain"
                       class="preview-img"
                       src="https://dummyimage.com/1600x900/ffffff/111827&text=Pilih+Template"
                       alt="Template Preview">

                  <div id="nameBoxMain" class="name-box">
                    <div id="nameTextMain" class="name-text">NAMA PESERTA</div>
                  </div>
                </div>

                <div class="sticky-actions d-flex align-items-center justify-content-between gap-2 flex-wrap mt-3">
                  <div class="hint">
                    Tips: Geser slider X/Y atau drag teks nama langsung di preview.
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal: Upload Template --}}
<div class="modal fade" id="modalCreateTemplate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Upload Template Sertifikat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('admin.template-sertifikat.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Nama Template</label>
              <input type="text" name="name" class="form-control rounded-16" 
                     placeholder="Contoh: Sertifikat Webinar Januari" required>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Status</label>
              <select class="form-select rounded-16" disabled>
                <option selected>Nonaktif</option>
              </select>
              <div class="hint mt-1">Template baru otomatis nonaktif.</div>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">File Template (PNG / JPG)</label>
              <input type="file" name="file" id="uploadTemplateInput" 
                     class="form-control rounded-16" accept="image/png,image/jpeg" required>
              <div class="hint mt-1">Rekomendasi: 1920×1080 (landscape)</div>
            </div>

            <div id="ratioWarning" class="alert alert-warning rounded-16 mt-2 d-none">
              <strong>⚠️ Rasio Template Tidak 16:9</strong>
              <div class="small mt-1">
                Template yang diunggah tidak menggunakan rasio 16:9.
                Disarankan agar posisi teks tetap konsisten saat generate sertifikat.
              </div>
            </div>

            <div id="forceUploadWrapper" class="form-check mt-2 d-none">
              <input class="form-check-input" type="checkbox" id="forceUpload">
              <label class="form-check-label fw-semibold" for="forceUpload">
                Saya mengerti dan tetap ingin mengunggah template ini
              </label>
            </div>

            <div class="col-12">
              <div class="fw-semibold mb-2">Preview Upload</div>
              <div class="preview-shell">
                <div class="preview-stage" style="aspect-ratio:16/9;">
                  <img id="uploadPreviewImg" class="preview-img"
                       src="https://dummyimage.com/1600x900/f3f4f6/374151&text=Preview+Upload">
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer mt-4">
            <button type="button" class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-brand rounded-16" id="btnSubmitTemplate" disabled>
              Simpan Template
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Modal: Preview Full --}}
<div class="modal fade" id="modalPreviewEval" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Preview Sertifikat (Fullscreen)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="preview-shell">
          <div class="preview-stage" id="previewStageModal">
            <img id="previewImgModal" class="preview-img" src="" alt="Template Preview">
            <div id="nameBoxModal" class="name-box">
              <div id="nameTextModal" class="name-text">NAMA PESERTA</div>
            </div>
          </div>
        </div>
        <div class="hint mt-2">Preview ini mengikuti setting dari panel kiri.</div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
(function () {
  'use strict';

  // ===============================
  // ELEMENTS
  // ===============================
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

  // Main preview
  const previewImgMain = document.getElementById('previewImgMain');
  const previewStageMain = document.getElementById('previewStageMain');
  const nameBoxMain = document.getElementById('nameBoxMain');
  const nameTextMain = document.getElementById('nameTextMain');

  // Modal preview
  const previewImgModal = document.getElementById('previewImgModal');
  const nameBoxModal = document.getElementById('nameBoxModal');
  const nameTextModal = document.getElementById('nameTextModal');

  // Buttons
  const btnResetStyle = document.getElementById('btnResetStyle');
  const btnCenterName = document.getElementById('btnCenterName');
  const btnFitToSafe = document.getElementById('btnFitToSafe');
  const btnToggleDrag = document.getElementById('btnToggleDrag');
  const dragStatus = document.getElementById('dragStatus');
  const btnOpenPreview = document.getElementById('btnOpenPreview');
  const btnSaveSetting = document.getElementById('btnSaveSetting');

  // Upload
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

  // ===============================
  // HELPER FUNCTIONS
  // ===============================

  function getPreviewScale() {
  const designWidth = 1920; // ukuran asli PDF
  const stageWidth = previewStageMain.clientWidth;
  return stageWidth / designWidth;
}

  function clamp(n, min, max) {
    return Math.max(min, Math.min(max, n));
  }

  function showToast(message, duration = 3000) {
    const toast = document.createElement('div');
    toast.className = 'success-toast';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
      setTimeout(() => toast.remove(), 300);
    }, duration);
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
  const scale = getPreviewScale(); // ⬅️ KUNCI UTAMA

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

  // ===============================
  // EVENT LISTENERS
  // ===============================

  // Template selection
  if (templateSelect) {
    templateSelect.addEventListener('change', loadTemplateFromDB);
  }

  // Position sliders
  posX.addEventListener('input', () => setNamePositionPercent(posX.value, posY.value));
  posY.addEventListener('input', () => setNamePositionPercent(posX.value, posY.value));

  // Box size
  boxWidthInput.addEventListener('input', applyBoxSize);
  boxHeightInput.addEventListener('input', applyBoxSize);

  // Style inputs
  [nameInput, fontFamily, fontSize, fontColor, fontWeight, fontStyle, 
   textAlign, letterSpacing, lineHeight].forEach(el => {
    if (el) el.addEventListener('input', applyNameStyles);
  });

  // Reset button
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

  // Center name
  if (btnCenterName) {
    btnCenterName.addEventListener('click', () => {
      setNamePositionPercent(50, 50);
      showToast('Nama dipusatkan');
    });
  }

  // Fit to safe area
  if (btnFitToSafe) {
    btnFitToSafe.addEventListener('click', () => {
      setNamePositionPercent(50, 55);
      showToast('Posisi diatur ke area aman');
    });
  }

  // Toggle drag
  if (btnToggleDrag) {
    btnToggleDrag.addEventListener('click', () => {
      dragEnabled = !dragEnabled;
      dragStatus.textContent = dragEnabled ? 'ON' : 'OFF';
      nameBoxMain.style.cursor = dragEnabled ? 'move' : 'default';
      showToast(`Drag ${dragEnabled ? 'diaktifkan' : 'dinonaktifkan'}`);
    });
  }

  // Open preview modal
  if (btnOpenPreview) {
    btnOpenPreview.addEventListener('click', () => {
      const modal = new bootstrap.Modal(document.getElementById('modalPreviewEval'));
      modal.show();
    });
  }

  // Save settings
  if (btnSaveSetting) {
    btnSaveSetting.addEventListener('click', function () {
      const templateId = templateSelect.value;
      if (!templateId) {
        alert('Pilih template terlebih dahulu');
        return;
      }

      const payload = {
      // ⬇️ INI WAJIB ADA (SESUIAI VALIDASI BACKEND)
      box_x: posX.value,
      box_y: posY.value,
      box_width: boxWidthInput.value,
      box_height: boxHeightInput.value,

      // FONT
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
      btnSaveSetting.textContent = 'Menyimpan...';

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

  // ===============================
  // DRAG FUNCTIONALITY
  // ===============================
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

  // ===============================
  // UPLOAD VALIDATION
  // ===============================
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

  // ===============================
  // INITIALIZATION
  // ===============================
  if (templateSelect && templateSelect.options.length > 0) {
    loadTemplateFromDB();
  }

})();
</script>
@endpush
@endsection