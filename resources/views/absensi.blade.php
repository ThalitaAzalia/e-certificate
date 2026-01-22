@extends('layouts.app')

@section('title', 'Form Absensi Webinar')

@section('content')
<div class="container py-5" style="max-width:600px">

  <div class="card shadow-sm border-0">
    <div class="card-body p-4">

      <h4 class="fw-bold mb-4 text-center">
        Form Absensi Webinar
      </h4>

      {{-- TAMPILKAN ERROR VALIDASI --}}
      @if ($errors->any())
        <div style="background:#fee; border:1px solid red; padding:10px; margin-bottom:15px;">
          <b>ERROR:</b>
          <ul class="mb-0">
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

        @foreach ($fields as $field)
          <div class="mb-3">
            <label class="form-label fw-semibold">
              {{ $field->label }}
              @if ($field->required)
                <span class="text-danger">*</span>
              @endif
            </label>

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

            @error($field->field_key)
              <div class="text-danger small mt-1">
                {{ $message }}
              </div>
            @enderror
          </div>
        @endforeach

        <button type="submit" class="btn btn-danger w-100 py-2 mt-3">
          Kirim Absensi
        </button>

      </form>

    </div>
  </div>

</div>
@endsection
