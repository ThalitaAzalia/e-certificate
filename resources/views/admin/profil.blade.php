@extends('layouts.app')

@section('title', 'Profil Admin')

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
    font-weight:900;
  }
  .btn-brand:hover{ background: var(--brand-2); color:#fff; }

  .btn-ghost{
    border:1px solid rgba(185,28,28,.35);
    background: rgba(255,255,255,.65);
    color: var(--brand);
    font-weight:900;
  }
  .btn-ghost:hover{ background: rgba(185,28,28,.08); color: var(--brand-3); }

  .form-control:focus, .form-select:focus{
    border-color: rgba(185,28,28,.55);
    box-shadow: 0 0 0 .25rem rgba(185,28,28,.18);
  }

  .hint{ font-size:.875rem; color: var(--muted); font-weight:800; }
  .divider-soft{ height:1px; background: rgba(185,28,28,.14); border-radius:999px; }

  /* ===== AVATAR ===== */
  .avatar{
    width:54px; height:54px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:1000;
    color:#fff;
    background: linear-gradient(135deg, var(--brand-3), var(--brand));
    box-shadow: 0 14px 30px rgba(185,28,28,.18);
    flex: 0 0 54px;
    overflow:hidden;
    position:relative;
  }
  .avatar-img{
    width:54px;
    height:54px;
    object-fit:cover;
    border-radius:16px;
    display:none; /* default hidden, muncul saat ada foto */
  }
  .avatar-initial{
    display:block; /* default tampil */
    line-height:1;
  }

  .sec-title{
    font-weight:1000;
    color: var(--ink);
    margin:0;
    font-size: 14px;
  }

  .danger-box{
    background: rgba(185,28,28,.06);
    border: 1px solid rgba(185,28,28,.14);
    border-radius: 16px;
    padding: 12px;
  }

  .pw-toggle{
    cursor:pointer;
    user-select:none;
    font-weight:900;
    color: var(--brand-3);
  }

  .chip{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:.35rem .6rem;
    border-radius:999px;
    font-weight:900;
    font-size:.85rem;
    border:1px solid rgba(185,28,28,.20);
    background: rgba(185,28,28,.06);
    color: var(--brand-3);
    white-space: nowrap;
  }

  /* preview box di modal */
  .photo-preview{
    width: 120px;
    height: 120px;
    border-radius: 20px;
    border: 1px dashed rgba(185,28,28,.28);
    background: rgba(255,255,255,.65);
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
  }
  .photo-preview img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:none;
  }
  .photo-preview .ph{
    color: var(--muted);
    font-weight:900;
    font-size: 12px;
    text-align:center;
    padding: 10px;
  }
  /* =========================
   MODAL UPLOAD FOTO (PRO)
========================= */
.modal-pro .modal-content{
  border-radius: 18px;
  border: 1px solid rgba(185,28,28,.14);
  overflow: hidden;
  box-shadow: 0 24px 70px rgba(17,24,39,.18);
}

.modal-pro .modal-header{
  background: linear-gradient(180deg, rgba(185,28,28,.07), rgba(255,255,255,.0));
  border-bottom: 1px solid rgba(185,28,28,.12);
  padding: 16px 18px;
}

.modal-pro .modal-title{
  font-weight: 1000;
  color: var(--ink);
  font-size: 16px;
}

.modal-pro .modal-body{
  padding: 18px;
}

.modal-pro .modal-footer{
  border-top: 1px solid rgba(185,28,28,.10);
  padding: 14px 18px;
  background: rgba(255,255,255,.6);
}

.modal-subtitle{
  color: var(--muted);
  font-weight: 800;
  font-size: 13px;
  line-height: 1.45;
  margin-bottom: 14px;
}

.photo-card{
  border: 1px solid rgba(185,28,28,.14);
  background: rgba(255,255,255,.72);
  border-radius: 16px;
  padding: 14px;
}

.photo-preview{
  width: 100%;
  height: 180px;
  border-radius: 16px;
  border: 1px dashed rgba(185,28,28,.28);
  background:
    radial-gradient(520px 220px at 20% 0%, rgba(185,28,28,.08), transparent 60%),
    rgba(255,255,255,.75);
  display:flex;
  align-items:center;
  justify-content:center;
  overflow:hidden;
  position: relative;
  transition: .18s ease;
}

.photo-preview:hover{
  border-color: rgba(185,28,28,.38);
  transform: translateY(-1px);
}

.photo-preview img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:none;
}

.photo-preview .ph{
  color: var(--muted);
  font-weight: 900;
  font-size: 12.5px;
  text-align:center;
  padding: 12px;
}

.photo-hint{
  margin-top: 10px;
  font-size: 12px;
  font-weight: 800;
  color: var(--muted);
}

.dropzone{
  border-radius: 16px;
  border: 1px solid rgba(185,28,28,.14);
  background: rgba(255,255,255,.72);
  padding: 14px;
}

.dropzone-label{
  display:flex;
  align-items:flex-start;
  gap: 12px;
  padding: 14px;
  border-radius: 14px;
  border: 1px dashed rgba(185,28,28,.28);
  background: rgba(185,28,28,.05);
  cursor: pointer;
  transition: .18s ease;
}

.dropzone-label:hover{
  border-color: rgba(185,28,28,.40);
  background: rgba(185,28,28,.07);
}

.dz-ico{
  width: 38px;
  height: 38px;
  border-radius: 14px;
  display:flex;
  align-items:center;
  justify-content:center;
  background: rgba(185,28,28,.10);
  border: 1px solid rgba(185,28,28,.18);
  font-weight: 1000;
  color: var(--brand-3);
  flex: 0 0 38px;
}

.dz-title{
  margin:0;
  font-weight: 1000;
  color: var(--ink);
  font-size: 13px;
  line-height: 1.25;
}

.dz-sub{
  margin:4px 0 0;
  color: var(--muted);
  font-weight: 800;
  font-size: 12px;
}

.dz-file{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap: 10px;
  margin-top: 12px;
  padding: 10px 12px;
  border-radius: 14px;
  background: rgba(255,255,255,.85);
  border: 1px solid rgba(185,28,28,.12);
}

.dz-file .name{
  font-weight: 900;
  color: var(--ink);
  font-size: 12.5px;
  overflow:hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  max-width: 100%;
}

.dz-file .tag{
  font-size: 11px;
  font-weight: 1000;
  color: var(--brand-3);
  background: rgba(185,28,28,.08);
  border: 1px solid rgba(185,28,28,.14);
  border-radius: 999px;
  padding: 6px 10px;
  white-space: nowrap;
}

.input-hidden{
  position:absolute;
  opacity:0;
  pointer-events:none;
  width:1px;height:1px;
}

.modal-actions{
  display:flex;
  gap: 10px;
  flex-wrap: wrap;
}

.btn-softred{
  border:1px solid rgba(185,28,28,.22);
  background: rgba(185,28,28,.07);
  color: var(--brand-3);
  font-weight: 1000;
  border-radius: 14px;
  padding: 10px 12px;
}

.btn-softred:hover{
  background: rgba(185,28,28,.10);
  color: var(--brand-3);
}

</style>
@endpush

@section('content')
<div class="container py-3">

  {{-- Header --}}
  <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
    <div>
      <h1 class="page-title mb-1">Profil Admin</h1>
      <div class="muted">Kelola akun admin: ubah username/password dan buat akun admin baru (UI saja).</div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
      {{-- ✅ Tambah fitur buat akun admin baru --}}
      <button class="btn btn-brand rounded-16" data-bs-toggle="modal" data-bs-target="#modalCreateAdmin">
        + Buat Admin Baru
      </button>
      <a href="{{ url('/admin/dashboard') }}" class="btn btn-ghost rounded-16">Kembali</a>
    </div>
  </div>

  <div class="row g-4">

    {{-- Left: Summary --}}
    <div class="col-lg-4">
      <div class="card card-soft rounded-16">
        <div class="card-body">

          <div class="d-flex gap-3 align-items-center">
            {{-- ✅ Avatar sekarang bisa foto --}}
            <div class="avatar">
              <img id="profileAvatarImg" class="avatar-img" alt="Foto Admin">
              <span id="profileAvatarInitial" class="avatar-initial">AD</span>
            </div>

            <div class="flex-grow-1">
              <div class="fw-bold" style="color:var(--ink); font-size:16px;">Admin Badiklat</div>
              <div class="muted small">Role: Admin</div>
              <div class="muted small">Terakhir login: 13 Jan 2026 • 09:12</div>

              {{-- ✅ tombol upload foto --}}
              <div class="mt-2 d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-ghost rounded-16 btn-sm" data-bs-toggle="modal" data-bs-target="#modalUploadPhoto">
                  Upload Foto
                </button>
                <button type="button" class="btn btn-outline-danger rounded-16 btn-sm" id="btnRemovePhoto" style="display:none;">
                  Hapus Foto
                </button>
              </div>

              <div class="hint mt-2">
                *Format disarankan: JPG/PNG. (UI saja, belum tersimpan)
              </div>
            </div>
          </div>

          <div class="divider-soft my-3"></div>

          <div class="danger-box">
            <div class="fw-bold text-danger">Catatan Keamanan</div>
            <div class="hint mt-1">
              Gunakan password kuat (min. 8 karakter) dan jangan dibagikan. Ini masih tampilan UI (belum tersimpan).
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- Right: Forms --}}
    <div class="col-lg-8">

      <div class="card card-soft rounded-16 mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <p class="sec-title">Ubah Username</p>
            <span class="chip">UI Only</span>
          </div>
          <div class="hint mb-3">Ganti username yang digunakan untuk login admin.</div>

          <form>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Username Saat Ini</label>
                <input type="text" class="form-control rounded-16" value="adminbadiklat" disabled>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Username Baru</label>
                <input type="text" class="form-control rounded-16" placeholder="contoh: admin.badiklat">
              </div>

              <div class="col-12 d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-brand rounded-16" data-bs-toggle="modal" data-bs-target="#modalSaveUsername">
                  Simpan Username
                </button>
                <button type="reset" class="btn btn-ghost rounded-16">Reset</button>
              </div>

              <div class="hint">
                *Tombol ini hanya tampilan. Nanti backend yang benar-benar menyimpan username.
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card card-soft rounded-16">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <p class="sec-title">Ubah Password</p>
            <span class="chip">UI Only</span>
          </div>
          <div class="hint mb-3">Masukkan password lama dan buat password baru.</div>

          <form>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Password Lama</label>
                <input type="password" class="form-control rounded-16" placeholder="••••••••" id="oldPassword">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Password Baru</label>
                <input type="password" class="form-control rounded-16" placeholder="min. 8 karakter" id="newPassword">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input type="password" class="form-control rounded-16" placeholder="ulangi password baru" id="confirmPassword">
              </div>

              <div class="col-md-6 d-flex align-items-end justify-content-between">
                <div class="hint">
                  Tips: kombinasi huruf besar, kecil, angka, simbol.
                </div>
                <span class="pw-toggle" id="togglePw">Lihat Password</span>
              </div>

              <div class="col-12 d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-brand rounded-16" data-bs-toggle="modal" data-bs-target="#modalSavePassword">
                  Simpan Password
                </button>
                <button type="reset" class="btn btn-ghost rounded-16">Reset</button>
              </div>

              <div class="hint">
                *Tombol ini hanya tampilan. Nanti backend akan validasi password lama & menyimpan password baru.
              </div>
            </div>
          </form>

        </div>
      </div>

    </div>

  </div>
</div>

{{-- =========================
  MODAL: UPLOAD FOTO (UI only)
========================= --}}
<div class="modal fade modal-pro" id="modalUploadPhoto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title">Upload Foto Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="modal-subtitle">
          Pilih foto untuk profil admin. <span class="muted">(Masih UI saja — belum tersimpan ke database)</span>
        </div>

        <form id="formUploadPhoto" enctype="multipart/form-data">
          <div class="row g-3">
            {{-- Preview --}}
            <div class="col-md-5">
              <div class="photo-card">
                <div class="photo-preview">
                  <img id="modalPhotoPreviewImg" alt="Preview Foto">
                  <div id="modalPhotoPlaceholder" class="ph">
                    Preview foto akan tampil di sini
                    <div class="mt-2" style="font-weight:900;color:var(--brand-3);">Rekomendasi 1:1 (kotak)</div>
                  </div>
                </div>
                <div class="photo-hint">
                  Tips: pakai foto jelas, wajah di tengah, background netral.
                </div>
              </div>
            </div>

            {{-- Picker --}}
            <div class="col-md-7">
              <div class="dropzone">
                <label class="dropzone-label" for="inputProfilePhoto">
                  <div class="dz-ico">⬆</div>
                  <div>
                    <p class="dz-title">Klik untuk pilih foto</p>
                    <p class="dz-sub">Format: JPG/PNG/WEBP • Saran max 2MB (nanti divalidasi backend)</p>
                  </div>
                </label>

                <input
                  id="inputProfilePhoto"
                  type="file"
                  class="input-hidden"
                  accept="image/png,image/jpeg,image/jpg,image/webp"
                >

                <div class="dz-file">
                  <div class="name" id="selectedFileName">Belum ada file dipilih</div>
                  <div class="tag">Photo</div>
                </div>

                <div class="divider-soft my-3"></div>

                <div class="modal-actions">
                  <button type="button" class="btn btn-brand rounded-16" id="btnApplyPhoto" disabled>
                    Pakai Foto Ini
                  </button>
                  <button type="button" class="btn btn-ghost rounded-16" id="btnClearSelectedPhoto" disabled>
                    Reset Pilihan
                  </button>
                </div>

                <div class="hint mt-3">
                  *Jika sudah pakai backend: simpan ke storage, simpan path ke tabel users/admins.
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


{{-- =========================
  MODAL: CREATE ADMIN BARU (UI only)
========================= --}}
<div class="modal fade" id="modalCreateAdmin" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Buat Akun Admin Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="muted mb-3">
          Isi data admin baru. (Masih tampilan UI — belum tersimpan ke database)
        </div>

        <form>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Nama Admin</label>
              <input type="text" class="form-control rounded-16" placeholder="Contoh: Admin Operator">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Username</label>
              <input type="text" class="form-control rounded-16" placeholder="contoh: adminoperator">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Status</label>
              <select class="form-select rounded-16">
                <option selected>Aktif</option>
                <option>Nonaktif</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Password</label>
              <input type="password" class="form-control rounded-16" placeholder="min. 8 karakter" id="createAdminPassword">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Konfirmasi Password</label>
              <input type="password" class="form-control rounded-16" placeholder="ulangi password" id="createAdminConfirmPassword">
            </div>

            <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div class="hint">
                *Nanti backend: validasi username unik + hash password + simpan ke DB.
              </div>
              <span class="pw-toggle" id="togglePwCreateAdmin">Lihat Password</span>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-brand rounded-16" type="button">Simpan Admin</button>
      </div>
    </div>
  </div>
</div>

{{-- =========================
  MODAL: SAVE USERNAME
========================= --}}
<div class="modal fade" id="modalSaveUsername" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Simpan Username</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="muted">Username akan diperbarui (UI saja).</div>

        <div class="mt-3 p-3 rounded-16" style="background: rgba(185,28,28,.06); border: 1px solid rgba(185,28,28,.12);">
          <div class="small muted">Username baru</div>
          <div class="fw-semibold">admin.badiklat</div>
        </div>

        <div class="hint mt-3">
          *Nanti backend yang menyimpan ke database.
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-brand rounded-16" type="button">Ya, Simpan</button>
      </div>
    </div>
  </div>
</div>

{{-- =========================
  MODAL: SAVE PASSWORD
========================= --}}
<div class="modal fade" id="modalSavePassword" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Simpan Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="muted">
          Password akan diperbarui (UI saja). Pastikan password baru sudah benar.
        </div>

        <div class="mt-3 p-3 rounded-16" style="background: rgba(46,125,50,.06); border: 1px solid rgba(46,125,50,.14);">
          <div class="fw-semibold" style="color:#2e7d32;">Checklist</div>
          <div class="small muted">✔ Minimal 8 karakter</div>
          <div class="small muted">✔ Kombinasi huruf & angka</div>
          <div class="small muted">✔ Tidak mudah ditebak</div>
        </div>

        <div class="hint mt-3">
          *Nanti backend yang validasi password lama dan menyimpan password baru.
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-ghost rounded-16" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-brand rounded-16" type="button">Ya, Simpan</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  const inputPhoto = document.getElementById('inputProfilePhoto');
  const avatarImg  = document.querySelector('.avatar img');
  const avatarInit = document.querySelector('.avatar-initial');

  if (!inputPhoto) return;

  inputPhoto.addEventListener('change', async function () {
    const file = this.files[0];
    if (!file) return;

    const allowed = ['image/jpeg','image/png','image/webp'];
    if (!allowed.includes(file.type)) {
      alert('Format harus JPG / PNG / WEBP');
      this.value = '';
      return;
    }

    const formData = new FormData();
    formData.append('photo', file);

    try {
      const response = await fetch("{{ route('admin.profil.photo') }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
      });

      if (!response.ok) {
        throw new Error('Upload gagal');
      }

      const data = await response.json();

      // update avatar
      if (avatarImg) {
        avatarImg.src = data.url;
        avatarImg.style.display = 'block';
      }
      if (avatarInit) {
        avatarInit.style.display = 'none';
      }

    } catch (err) {
      alert('Gagal upload foto');
      console.error(err);
    }
  });

});
</script>
@endpush

@endsection