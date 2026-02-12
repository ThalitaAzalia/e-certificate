@extends('layouts.app')

@section('title', 'Profil Admin')

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
    color: #111827;
  }

  .page-title {
    font-weight: 900;
    letter-spacing: -0.025em;
    color: var(--brand-3);
    font-size: 1.75rem;
  }

  .card-soft {
    background: var(--bg-card) !important;
    border: 1px solid var(--border-soft) !important;
    border-radius: 12px !important;
    box-shadow: 0 2px 8px rgba(185, 28, 28, 0.05) !important;
  }

  .btn-brand {
    background: var(--brand) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    padding: 0.5rem 1.25rem !important;
  }
  .btn-brand:hover { background: var(--brand-2) !important; }

/* hover (tetap soft) */
.btn-ghost:hover {
  background: rgba(185, 28, 28, 0.06);
}

/* SAAT DI KLIK */
.btn-ghost:active,
.btn-ghost.active {
  background: var(--brand);
  color: #fff;
  border-color: var(--brand);
  box-shadow: 0 6px 14px rgba(185, 28, 28, 0.35);
  transform: scale(0.97);
}

/* icon ikut berubah */
.btn-ghost:active i,
.btn-ghost.active i {
  color: #fff;
}

  .btn-ghost:hover { background: rgba(185, 28, 28, 0.05) !important; }

  .btn-danger-soft {
    background: #fff;
    color: #dc2626;
    border: 1px solid #fca5a5;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
  }
  .btn-danger-soft:hover {
    background: #fef2f2;
    border-color: #dc2626;
  }

  .form-control, .form-select {
    border-radius: 6px !important;
    border: 1px solid #e5e7eb !important;
    padding: 0.5rem 0.75rem !important;
    font-size: 0.875rem !important;
  }
  .form-control:focus, .form-select:focus {
    border-color: var(--brand) !important;
    box-shadow: 0 0 0 2px rgba(185, 28, 28, 0.1) !important;
  }

  .subtxt {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
  }

  .role-badge {
    display: inline-flex;
    align-items: center;
    gap: .375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: .75rem;
    background: rgba(185, 28, 28, 0.08);
    border: 1px solid rgba(185, 28, 28, 0.15);
    color: var(--brand-3);
  }

  .avatar-circle {
    width: 120px;
    height: 120px;
    border-radius: 18px;
    background: linear-gradient(135deg, var(--brand), var(--brand-3));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    overflow: hidden;
    border: 4px solid white;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,.1);
  }
  .avatar-circle img { width:100%; height:100%; object-fit:cover; }

  .file-upload-label {
    display: block;
    width: 100%;
    padding: 1rem;
    background: white;
    border: 2px dashed rgba(185, 28, 28, 0.25);
    border-radius: 12px;
    text-align: center;
    font-size: .875rem;
    color: #4b5563;
    cursor: pointer;
  }
  .file-upload-label:hover {
    border-color: rgba(185, 28, 28, 0.45);
    background: rgba(185, 28, 28, 0.03);
  }

  .file-upload-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
  }

  .divider {
    height: 1px;
    background: rgba(185, 28, 28, 0.08);
    margin: 1.5rem 0;
  }

  .alert-soft {
    border-radius: 12px;
    border: 1px solid transparent;
    padding: 1rem;
  }
  .alert-success-soft { background: #dbeafe; border-color: #93c5fd; color: #1e40af; }
  .alert-error-soft   { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
  .alert-info-soft    { background: #eff6ff; border-color: #bfdbfe; color: #1e40af; }

  /* Notif (gantikan class tailwind fixed bottom-4 right-4) */
  .toast-note {
    position: fixed;
    right: 16px;
    bottom: 16px;
    z-index: 9999;
    background: #111827;
    color: #fff;
    padding: 12px 14px;
    border-radius: 12px;
    box-shadow: 0 12px 24px rgba(0,0,0,.2);
    display: flex;
    align-items: center;
    gap: 10px;
    transform: translateY(0);
    transition: transform .3s ease, opacity .3s ease;
  }
  .toast-note.hide {
    transform: translateY(100px);
    opacity: 0;
  }

  .loading { opacity: .75; pointer-events:none; }

  .alert-blue-soft { 
    background: #dbeafe;
    border-color: #93c5fd;
    color: #1e40af;
  }
  .alert-blue-soft i { color: #1e40af; }

  /* ===== FIX FINAL: BUTTON MODAL HAPUS FOTO PROFIL ===== */
  .btn-modal-cancel{
    background:#fff !important;
    color:#111827 !important; /* hitam */
    border:1.5px solid rgba(220,38,38,.45) !important;
    border-radius:16px !important;
    padding:.45rem 1.15rem !important; /* kecilin */
    font-weight:600 !important;
    min-width:110px;
    transition:all .15s ease;
  }

  .btn-modal-cancel:hover{
    background:rgba(220,38,38,.06) !important;
    border-color:rgba(220,38,38,.7) !important;
  }

  /* pas klik: teks jadi merah */
  .btn-modal-cancel:active{
    color:#dc2626 !important;
  }

  /* tombol Ya, Hapus */
  .btn-modal-delete{
    background:#dc2626 !important;
    color:#fff !important;
    border:1.5px solid #dc2626 !important;
    border-radius:16px !important;
    padding:.45rem 1.15rem !important; /* samain kecil */
    font-weight:600 !important;
    min-width:110px;
    transition:all .15s ease;
  }

  .btn-modal-delete:hover{
    background:#b91c1c !important;
    border-color:#b91c1c !important;
  }

  /* ===== MODAL DELETE (SCOPED) ===== */
  .modal-delete-question .modal-content{
    border-radius: 18px;
    border: 0;
    box-shadow: 0 18px 40px rgba(0,0,0,.18);
    overflow: hidden;
  }

  .modal-delete-question .modal-title{
    color: #dc2626;
    font-size: 1.6rem;
    font-weight: 800;
  }

  .modal-delete-question .delete-box{
    background: #fde2e2;
    border: 1px solid rgba(220,38,38,.25);
    border-radius: 12px;
    padding: 1.25rem;
  }

  .modal-delete-question .delete-title{
    font-weight: 800;
    font-size: 1.3rem;
    margin-bottom: .65rem;
  }

  .modal-delete-question .btn-del-cancel{
    background: #fff;
    border: 1px solid rgba(220,38,38,.35);
    color: #dc2626;
    border-radius: 12px;
    padding: .55rem 1.35rem;
    font-weight: 700;
    min-width: 110px;
  }

  .modal-delete-question .btn-del-confirm{
    background: #dc2626;
    border: 1px solid #dc2626;
    color: #fff;
    border-radius: 12px;
    padding: .55rem 1.35rem;
    font-weight: 700;
    min-width: 130px;
  }

  /* ===== HEADER CARD ===== */
  .header-card{
    background: linear-gradient(180deg, rgba(185,28,28,.08), rgba(250,250,250,1));
    border: 1px solid rgba(185,28,28,.20);
    border-radius: 18px;
    padding: 18px 18px;
    box-shadow:
      0 16px 40px rgba(185,28,28,.10),
      0 6px 16px rgba(185,28,28,.06);
  }

  .header-card .actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    align-items:center;
    justify-content:flex-end;
  }

  .btn-ghost{
    border: 1px solid rgba(185, 28, 28, 0.25);
    background: white;
    color: var(--brand);
    border-radius: 10px;
    font-weight: 500;
    padding: 0.45rem 1.1rem;
    font-size: 0.9rem;
  }

  .btn-ghost:hover{
    background: rgba(185, 28, 28, 0.05);
  }

</style>
@endpush

@section('content')
<div class="container py-4">

  {{-- HEADER --}}
  <div class="header-card mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">

      <div>
        <h1 class="page-title mb-2">Pengaturan Profil Administrator</h1>
        <p class="text-muted mb-0">
          Kelola informasi akun administrator Anda, termasuk username, password, dan foto profil.
        </p>
      </div>

      <div class="actions">
        <a href="{{ route('admin.dashboard') }}"
          class="btn btn-ghost d-flex align-items-center gap-1">
          <i class="fas fa-arrow-left fa-sm"></i>
          <span>Kembali</span>
        </a>
      </div>
    </div>
  </div>

  {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div id="successAlert" class="alert-soft alert-blue-soft mb-4">
      <div class="d-flex align-items-center gap-2">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
      </div>
    </div>

    <script>
      setTimeout(() => {
        document.getElementById('successAlert')?.remove();
      }, 3000); // 3000ms = 3 detik
    </script>
  @endif


  {{-- ALERT ERROR --}}
  @if(session('error'))
    <div class="alert-soft alert-error-soft mb-4">
      <div class="d-flex align-items-center gap-2">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="alert-soft alert-error-soft mb-4">
      <div class="d-flex align-items-center gap-2">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
      </div>
    </div>
  @endif

  @if($errors->any())
    <div class="alert-soft alert-error-soft mb-4">
      <div class="d-flex align-items-start gap-2">
        <i class="fas fa-exclamation-triangle mt-1"></i>
        <div>
          <div class="fw-bold mb-1">Terjadi kesalahan:</div>
          <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
              <li class="small">{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif

  <div class="row g-4">
    {{-- LEFT --}}
    <div class="col-12 col-lg-4">
      {{-- AVATAR --}}
      <div class="card card-soft mb-4">
        <div class="card-body text-center p-4">
          <div class="d-flex flex-column align-items-center">
            <div class="avatar-circle mb-3">
              @if(isset($user->photo) && $user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->username ?? 'Admin' }}">
              @else
                {{ isset($user->username) ? strtoupper(substr($user->username, 0, 2)) : 'AD' }}
              @endif
            </div>

            <div class="fw-semibold fs-5">{{ $user->username ?? 'Administrator' }}</div>
            <div class="mt-2">
              <span class="role-badge">
                <i class="fas fa-shield-alt"></i>
                Administrator
              </span>
            </div>

            @if(isset($user->created_at))
              <div class="subtxt mt-3">
                <i class="fas fa-clock me-1"></i>
                Bergabung {{ $user->created_at->format('d M Y') }}
              </div>
            @endif
          </div>
        </div>
      </div>

      {{-- PHOTO MANAGEMENT --}}
      <div class="card card-soft">
        <div class="card-body p-4">
          <h5 class="fw-semibold mb-1">Kelola Foto Profil</h5>
          <p class="text-muted small mb-3">
            Unggah foto profil baru. Format: JPG/PNG.
          </p>

          <form method="POST" action="{{ route('admin.profil.photo') }}" enctype="multipart/form-data" class="mb-3">
            @csrf
            <div class="position-relative mb-2">
              <input type="file"
                     name="photo"
                     id="photo"
                     class="file-upload-input"
                     accept="image/jpeg,image/png,image/jpg"
                     onchange="updateFileName(this)">
              <label for="photo" class="file-upload-label" id="fileLabel">
                <i class="fas fa-cloud-upload-alt fa-lg d-block mb-2"></i>
                <span>Klik untuk memilih file</span>
                <div class="subtxt">atau drag & drop file di sini</div>
              </label>
            </div>

            <button type="submit" class="btn btn-brand w-100 d-inline-flex justify-content-center gap-2">
              <i class="fas fa-upload"></i>
              <span>Unggah Foto Baru</span>
            </button>
          </form>

          @if(isset($user->photo) && $user->photo)
            <div class="divider"></div>

            <button type="button"
                    class="btn btn-danger-soft w-100 d-inline-flex justify-content-center gap-2"
                    data-bs-toggle="modal"
                    data-bs-target="#hapusFotoProfilModal">
              <i class="fas fa-trash"></i>
              <span>Hapus Foto Profil</span>
            </button>


          @endif

        </div>
      </div>
    </div>

    {{-- RIGHT --}}
    <div class="col-12 col-lg-8">
      {{-- USERNAME --}}
      <div class="card card-soft mb-4">
        <div class="card-body p-4">
          <h5 class="fw-semibold mb-1">Ubah Username</h5>
          <p class="text-muted small mb-3">
            Username digunakan untuk login. Pastikan unik dan tanpa spasi.
          </p>

          <form method="POST" action="{{ route('admin.profil.username') }}" id="usernameForm">
            @csrf
            <div class="mb-3">
              <label for="username" class="form-label fw-semibold">Username Baru</label>
              <input type="text"
                     id="username"
                     name="username"
                     value="{{ old('username', $user->username ?? '') }}"
                     class="form-control"
                     placeholder="Masukkan username baru"
                     required>
              <div class="subtxt">
                <i class="fas fa-info-circle me-1"></i>
                Username harus unik
              </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
              <button type="submit" class="btn btn-brand d-inline-flex align-items-center gap-2">
                <i class="fas fa-save"></i>
                <span>Simpan Username</span>
              </button>
              <button type="button" onclick="resetUsername()" class="btn btn-ghost d-inline-flex align-items-center gap-2">
                <i class="fas fa-undo"></i>
                <span>Reset</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- PASSWORD --}}
      <div class="card card-soft">
        <div class="card-body p-4">
          <h5 class="fw-semibold mb-1">Ubah Password</h5>
          <p class="text-muted small mb-3">
            Untuk keamanan akun, gunakan password yang kuat.
          </p>

          <form method="POST" action="{{ route('admin.profil.password') }}" id="passwordForm">
            @csrf

            <div class="mb-3">
              <label for="old_password" class="form-label fw-semibold">Password Saat Ini</label>
              <input type="password"
                     id="old_password"
                     name="old_password"
                     class="form-control"
                     placeholder="Masukkan password saat ini"
                     required>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-12 col-md-6">
                <label for="password" class="form-label fw-semibold">Password Baru</label>
                <input type="password"
                       id="password"
                       name="password"
                       class="form-control"
                       placeholder="Password baru"
                       required>
              </div>
              <div class="col-12 col-md-6">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Ulangi password baru"
                       required>
              </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
              <button type="submit" class="btn btn-brand d-inline-flex align-items-center gap-2">
                <i class="fas fa-lock"></i>
                <span>Perbarui Password</span>
              </button>
              <button type="button" onclick="resetPassword()" class="btn btn-ghost d-inline-flex align-items-center gap-2">
                <i class="fas fa-times"></i>
                <span>Batalkan</span>
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

</div>

@push('scripts')
<script>
function updateFileName(input) {
  const label = document.getElementById('fileLabel');
  if (input.files && input.files[0]) {
    const fileName = input.files[0].name;
    label.innerHTML = `
      <i class="fas fa-file-alt fa-lg d-block mb-2"></i>
      <span class="fw-semibold">${fileName}</span>
      <div class="subtxt">File siap diunggah</div>
    `;
  }
}

function resetUsername() {
  const originalUsername = "{{ $user->username ?? '' }}";
  document.getElementById('username').value = originalUsername;
  showNotification('Username telah direset ke nilai awal');
}

function resetPassword() {
  document.getElementById('old_password').value = '';
  document.getElementById('password').value = '';
  document.getElementById('password_confirmation').value = '';
  showNotification('Field password telah dikosongkan');
}

function showNotification(message) {
  const el = document.createElement('div');
  el.className = 'toast-note';
  el.innerHTML = `
    <i class="fas fa-check-circle"></i>
    <div>${message}</div>
  `;
  document.body.appendChild(el);

  setTimeout(() => {
    el.classList.add('hide');
    setTimeout(() => el.remove(), 300);
  }, 2500);
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
      const btn = this.querySelector('button[type="submit"]');
      if (!btn) return;
      btn.classList.add('loading');
      btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>`;
    });
  });
});
</script>

<div class="modal fade modal-delete-question" id="hapusFotoProfilModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title fw-bold">Hapus Foto Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p class="mb-3">Anda yakin ingin menghapus foto profil?</p>

        <div class="delete-box">
          <div class="delete-title">Foto Profil</div>
          <div class="delete-warn">Tindakan ini tidak dapat dibatalkan.</div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-del-cancel" data-bs-dismiss="modal">Batal</button>

        <form method="POST" action="{{ route('admin.profil.photo.delete') }}" class="m-0">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-del-confirm">Ya, Hapus</button>
        </form>
      </div>

    </div>
  </div>
</div>

@endsection
@endpush

