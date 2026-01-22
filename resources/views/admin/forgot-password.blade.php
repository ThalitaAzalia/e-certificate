@extends('layouts.app')

@section('title', 'Reset Password | Admin')

@section('content')
<style>
  :root{
    --red-800:#9b0000;
    --red-700:#b10000;
    --ink:#1b1b1b;
    --muted:#6b7280;
    --card-radius:28px;
  }

  body{
    margin:0;
    background:
      radial-gradient(900px 520px at 25% 25%, rgba(155,0,0,.12), transparent 60%),
      radial-gradient(850px 520px at 80% 70%, rgba(155,0,0,.10), transparent 55%),
      linear-gradient(180deg, #ffffff 0%, #ffffff 35%, #f6f7f9 100%);
  }

  .stage{
    min-height: calc(100vh - 60px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding: 28px 16px;
  }

  .phone{
    width: min(520px, 100%);
    border-radius: 34px;
    background: #fff;
    box-shadow: 0 30px 85px rgba(0,0,0,.22);
    overflow:hidden;
  }

  .hero{
    padding: 28px 24px 80px;
    color:#fff;
    background: linear-gradient(135deg, #7a0000, #9b0000);
  }

  .hero h1{
    margin:0;
    font-weight:900;
    font-size:28px;
  }

  .hero p{
    margin-top:6px;
    font-size:13px;
    opacity:.9;
  }

  .card-wrap{
    margin-top:-56px;
    padding: 0 16px 18px;
  }

  .cardx{
    border-radius: var(--card-radius);
    background:#fff;
    box-shadow: 0 24px 70px rgba(122,0,0,.18);
    padding:18px;
  }

  .form-label{
    font-weight:800;
    font-size:12px;
    margin-bottom:6px;
  }

  .inputx{
    width:100%;
    border-radius:14px;
    padding:12px 14px;
    border:1px solid rgba(0,0,0,.12);
  }

  .inputx:focus{
    outline:none;
    border-color:#9b0000;
    box-shadow:0 0 0 3px rgba(155,0,0,.15);
  }

  .btn-red{
    width:100%;
    margin-top:14px;
    border:0;
    border-radius:14px;
    padding:12px;
    color:#fff;
    font-weight:900;
    background: linear-gradient(135deg, #7a0000, #b10000);
  }

  .note{
    margin-top:10px;
    font-size:12px;
    color:rgba(0,0,0,.55);
  }

  .back{
    margin-top:12px;
    display:inline-block;
    font-weight:800;
    color:#9b0000;
    text-decoration:none;
  }
</style>

<div class="stage">
  <div class="phone">

    <div class="hero">
      <h1>Reset Password</h1>
      <p>Masukkan username dan password baru untuk akun admin.</p>
    </div>

    <div class="card-wrap">
      <div class="cardx">

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
          <div class="alert alert-danger mb-3">
            {{ $errors->first() }}
          </div>
        @endif

        {{-- FORM RESET PASSWORD --}}
        <form method="POST" action="{{ route('admin.reset') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Username</label>
            <input
              class="inputx"
              type="text"
              name="username"
              placeholder="admin"
              required
            >
          </div>

          <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input
              class="inputx"
              type="password"
              name="password"
              required
            >
          </div>

          <div class="mb-2">
            <label class="form-label">Konfirmasi Password</label>
            <input
              class="inputx"
              type="password"
              name="password_confirmation"
              required
            >
          </div>

          <button type="submit" class="btn-red">
            Simpan Password
          </button>

          <div class="note">
            Password akan langsung diperbarui tanpa email.
          </div>

          <a class="back" href="{{ route('admin.login') }}">
            ← Kembali ke Login
          </a>
        </form>

      </div>
    </div>

  </div>
</div>
@endsection
