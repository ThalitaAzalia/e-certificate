@extends('layouts.app')

@section('title','Unduh Sertifikat')

@section('content')
<div class="container py-5" style="max-width:600px">
  <div class="card shadow-sm border-0">
    <div class="card-body text-center p-4">

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <p class="text-muted mb-1">Nama Peserta</p>
      <div class="fs-4 fw-bold mb-4">{{ $nama }}</div>

      <a href="{{ route('sertifikat.download') }}" class="btn btn-danger w-100">
    Unduh Sertifikat (PDF)
      </a>


    </div>
  </div>
</div>
@endsection
