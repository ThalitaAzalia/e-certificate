@extends('layouts.app')

@section('title', 'Profil Admin')

@push('head')
<style>
:root{
  --primary:#b91c1c;
  --primary-dark:#991b1b;
  --bg:#f7e8e8;
  --card:#fff;
  --border:rgba(185,28,28,.2);
  --text:#111827;
  --muted:#6b7280;
}

body{
  background: var(--bg);
}

/* ===== CARD ===== */
.card-pro{
  background: var(--card);
  border-radius:18px;
  border:1px solid var(--border);
  box-shadow:0 25px 50px rgba(0,0,0,.08);
  animation:fadeUp .5s ease;
}

@keyframes fadeUp{
  from{opacity:0; transform:translateY(12px)}
  to{opacity:1; transform:none}
}

/* ===== AVATAR ===== */
.avatar{
  width:120px;
  height:120px;
  border-radius:24px;
  overflow:hidden;
  background:linear-gradient(135deg,var(--primary-dark),var(--primary));
  display:flex;
  align-items:center;
  justify-content:center;
  color:#fff;
  font-weight:900;
  font-size:34px;
  box-shadow:0 20px 40px rgba(185,28,28,.3);
}

.avatar img{
  width:100%;
  height:100%;
  object-fit:cover;
}

/* ===== BUTTON ===== */
.btn-red{
  background:var(--primary);
  color:#fff;
  border:none;
  padding:10px 18px;
  border-radius:14px;
  font-weight:800;
  transition:.2s;
}
.btn-red:hover{
  background:var(--primary-dark);
  transform:translateY(-1px);
}

.btn-outline-red{
  border:1px solid var(--primary);
  background:#fff;
  color:var(--primary);
  padding:10px 18px;
  border-radius:14px;
  font-weight:800;
}

/* ===== FORM ===== */
.form-control{
  border-radius:14px;
}
.form-control:focus{
  border-color:var(--primary);
  box-shadow:0 0 0 .2rem rgba(185,28,28,.2);
}

.section-title{
  font-weight:900;
  color:var(--text);
}

.muted{
  color:var(--muted);
  font-size:14px;
}
</style>
@endpush

@section('content')
<div class="container py-4">
<div class="d-flex align-items-center mb-4">
  <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
    ← Kembali ke Dashboard
  </a>
</div>

  {{-- HEADER --}}
  <div class="mb-4">
    <h2 class="fw-bold">Profil Admin</h2>
    <div class="muted">Kelola akun admin (username, password & foto)</div>
  </div>

  <div class="row g-4">

    {{-- LEFT --}}
    <div class="col-lg-4">
      <div class="card-pro p-4 text-center">

        {{-- AVATAR --}}
        <div class="d-flex justify-content-center mb-3">
          <div class="avatar">
            @if($user->photo)
              <img src="{{ asset('storage/'.$user->photo) }}">
            @else
              {{ strtoupper(substr($user->username,0,2)) }}
            @endif
          </div>
        </div>

        <h5 class="fw-bold mb-1">{{ $user->username }}</h5>
        <div class="muted mb-3">Administrator</div>

        {{-- UPLOAD FOTO --}}
        <form method="POST" action="{{ route('admin.profil.photo') }}" enctype="multipart/form-data">
          @csrf
          <input type="file" name="photo" class="form-control mb-2" required>
          <button class="btn-red w-100">Upload Foto</button>
        </form>

        {{-- HAPUS FOTO --}}
        @if($user->photo)
        <form method="POST" action="{{ route('admin.profil.photo.delete') }}" class="mt-2">
          @csrf
          @method('DELETE')
          <button class="btn-outline-red w-100">Hapus Foto</button>
        </form>
        @endif

      </div>
    </div>

    {{-- RIGHT --}}
    <div class="col-lg-8">

      {{-- USERNAME --}}
      <div class="card-pro p-4 mb-4">
        <h6 class="section-title mb-1">Ubah Username</h6>
        <div class="muted mb-3">Username digunakan untuk login admin</div>

        <form method="POST" action="{{ route('admin.profil.username') }}">
          @csrf
          <input type="text" name="username" value="{{ $user->username }}" class="form-control mb-3" required>
          <button class="btn-red">Simpan Username</button>
        </form>
      </div>

      {{-- PASSWORD --}}
      <div class="card-pro p-4">
        <h6 class="section-title mb-1">Ubah Password</h6>
        <div class="muted mb-3">Gunakan password yang kuat</div>

        <form method="POST" action="{{ route('admin.profil.password') }}">
          @csrf
          <input type="password" name="old_password" class="form-control mb-2" placeholder="Password lama" required>
          <input type="password" name="password" class="form-control mb-2" placeholder="Password baru" required>
          <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Konfirmasi password" required>
          <button class="btn-red">Simpan Password</button>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection
