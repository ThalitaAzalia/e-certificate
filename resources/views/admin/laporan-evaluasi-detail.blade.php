@extends('layouts.app')

@section('title', 'Detail Evaluasi')

@section('content')
<div class="container py-4">

  <div class="card card-soft rounded-16">
    <div class="card-body">

      <h4 class="fw-bold mb-3">Detail Evaluasi Peserta</h4>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <div class="muted small">Nama</div>
          <div class="fw-semibold">{{ $peserta->nama_peserta }}</div>
        </div>

        <div class="col-md-6">
          <div class="muted small">Email</div>
          <div class="fw-semibold">{{ $peserta->email }}</div>
        </div>

        <div class="col-md-6">
          <div class="muted small">Webinar</div>
          <div class="fw-semibold">{{ $peserta->webinar->judul }}</div>
        </div>

        <div class="col-md-6">
          <div class="muted small">Tanggal Isi</div>
          <div class="fw-semibold">
            {{ $peserta->created_at->format('d M Y • H:i') }}
          </div>
        </div>
      </div>

      <hr>

      <h6 class="fw-semibold mb-2">Jawaban Evaluasi</h6>

      @forelse($peserta->evaluasiAnswers as $ans)
        <div class="mb-3">
          <div class="fw-semibold small">
            {{ $ans->question->question ?? '-' }}
          </div>
          <div class="text-muted">
            {{ $ans->answer ?? $ans->rating }}
          </div>
        </div>
      @empty
        <div class="text-muted">Belum ada jawaban evaluasi.</div>
      @endforelse

      <a href="{{ route('admin.laporan.evaluasi.peserta', $peserta->webinar_id) }}"
         class="btn btn-ghost rounded-16 mt-3">
        ← Kembali ke Peserta
      </a>

    </div>
  </div>

</div>
@endsection
