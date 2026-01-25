@extends('layouts.app')
@section('title', 'Form Absensi Webinar')

@push('styles')
<style>
  /* ====== CARD LOOK (premium) ====== */
  .abs-wrap{ position: relative; }

  .abs-card{
    position: relative;
    border-radius: 28px;
    background:
      radial-gradient(420px 180px at 20% 0%, rgba(185,28,28,.08), transparent 60%),
      rgba(255,255,255,.88);
    border: 1px solid rgba(255,255,255,.75);
    box-shadow:
      0 40px 90px rgba(17,24,39,.18),
      0 18px 45px rgba(185,28,28,.14);
    overflow: hidden;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
  }
  .abs-card::before{
    content:"";
    position:absolute;
    inset:0;
    border-radius: inherit;
    padding:1px;
    background: linear-gradient(135deg, rgba(255,255,255,.85), rgba(185,28,28,.35), rgba(255,255,255,.55));
    -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
    -webkit-mask-composite: xor;
            mask-composite: exclude;
    pointer-events:none;
  }

  .abs-card-body{ padding: 26px 26px 22px; }

  .abs-head{
    position: relative;
    padding: 18px 18px 16px;
    margin-bottom: 18px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(185,28,28,.10), rgba(255,255,255,.75));
    border: 1px solid rgba(185,28,28,.14);
    text-align:center;
  }
  .abs-head::after{
    content:"";
    position:absolute;
    inset:-2px;
    border-radius: inherit;
    background-image: radial-gradient(rgba(185,28,28,.08) 1px, transparent 1px);
    background-size: 16px 16px;
    opacity:.25;
    pointer-events:none;
  }
  .abs-title{
    margin:0;
    font-weight: 900;
    letter-spacing: -.4px;
    font-size: 28px;
    color: #111827;
    position: relative;
    z-index: 1;
  }
  .abs-desc{
    margin: 10px auto 0;
    max-width: 52ch;
    color: rgba(17,24,39,.68);
    font-weight: 500;
    line-height: 1.55;
    position: relative;
    z-index: 1;
  }
  .abs-divider{
    height: 3px;
    width: 60px;
    margin: 14px auto 0;
    border-radius: 999px;
    background: linear-gradient(90deg, #b91c1c, #dc2626);
    position: relative;
    z-index: 1;
  }

  /* ====== FORM ====== */
  .form-label{
    font-weight: 650;
    color: #111827;
    font-size: .92rem;
  }

  .field{ position: relative; }
  .field .ico{
    position:absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    border-radius: 14px;
    display:flex;
    align-items:center;
    justify-content:center;
    background: rgba(185,28,28,.08);
    border: 1px solid rgba(185,28,28,.14);
    color: #991b1b;
    font-weight: 800;
    pointer-events:none;
  }

  .form-control{
    border-radius: 18px;
    border: 1px solid rgba(17,24,39,.10);
    background: rgba(255,255,255,.86);
    padding: .72rem .9rem .72rem 58px;
  }
  textarea.form-control{
    min-height: 110px;
    padding-top: .75rem;
    padding-bottom: .75rem;
  }
  .form-control:focus{
    border-color: rgba(185,28,28,.45);
    box-shadow: 0 0 0 .25rem rgba(185,28,28,.14);
    background: rgba(255,255,255,.94);
  }

  /* ====== ALERT ====== */
  .alert-soft{
    border-radius: 18px;
    border: 1px solid rgba(185,28,28,.14);
    background: rgba(255,255,255,.75);
  }

  /* ====== BUTTON ====== */
  .btn-submit{
    width: 100%;
    border: none;
    border-radius: 18px;
    padding: .85rem 1rem;
    font-weight: 750;
    color:#fff;
    background: linear-gradient(135deg, #b91c1c, #dc2626);
    box-shadow: 0 18px 36px rgba(185,28,28,.18);
    transition: transform .15s ease, filter .15s ease;
  }
  .btn-submit:hover{
    transform: translateY(-1px);
    filter: brightness(1.02);
  }
</style>
@endpush

@section('content')
<div class="container py-4 abs-wrap" style="max-width:720px">

  <div class="abs-card">
    <div class="abs-card-body">

      <div class="abs-head">
        <h1 class="abs-title">Form Absensi Webinar</h1>
        <p class="abs-desc">
          Isi data berikut dengan benar. Setelah berhasil, kamu akan diarahkan ke halaman evaluasi.
        </p>
        <div class="abs-divider"></div>
      </div>

      {{-- TAMPILKAN ERROR VALIDASI (DB/LOGIC TETAP) --}}
      @if ($errors->any())
        <div class="alert alert-danger alert-soft mb-3">
          <div class="fw-semibold mb-1">Periksa lagi ya:</div>
          <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ url('/absensi') }}">
        @csrf

        {{-- SATU-SATUNYA WEBINAR ID (DARI URL) --}}
        <input type="hidden" name="webinar_id" value="{{ request()->query('webinar_id') }}">

        {{-- ✅ INI BAGIAN DATABASE: TIDAK DIUBAH --}}
        @foreach ($fields as $field)
          @php
            // icon cuma tampilan (tidak ngubah database)
            $ico = '📝';
            if (in_array($field->type, ['text'])) $ico = '👤';
            if (in_array($field->type, ['email'])) $ico = '✉';
            if (in_array($field->type, ['tel'])) $ico = '📱';
            if (in_array($field->type, ['number'])) $ico = '🔢';
            if (in_array($field->type, ['date'])) $ico = '📅';
            if ($field->type === 'textarea') $ico = '🗒️';
          @endphp

          <div class="mb-3">
            <label class="form-label fw-semibold">
              {{ $field->label }}
              @if ($field->required)
                <span class="text-danger">*</span>
              @endif
            </label>

            <div class="field">
              <div class="ico">{{ $ico }}</div>

              @if ($field->type === 'textarea')
                <textarea
                  name="{{ $field->field_key }}"
                  class="form-control"
                  placeholder="{{ $field->placeholder }}"
                  {{ $field->required ? 'required' : '' }}
                >{{ old($field->field_key) }}</textarea>
              @else
                <input
                  type="{{ $field->type }}"
                  name="{{ $field->field_key }}"
                  class="form-control"
                  placeholder="{{ $field->placeholder }}"
                  value="{{ old($field->field_key) }}"
                  {{ $field->required ? 'required' : '' }}
                >
              @endif
            </div>

            @error($field->field_key)
              <div class="text-danger small mt-1">
                {{ $message }}
              </div>
            @enderror
          </div>
        @endforeach

        <button type="submit" class="btn-submit mt-2">
          Kirim Absensi
        </button>

      </form>

    </div>
  </div>

</div>
@endsection
