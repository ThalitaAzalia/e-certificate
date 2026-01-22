@extends('layouts.app')

@section('title', 'Peserta Evaluasi')

@section('content')
<div class="container py-4">

  {{-- HEADER --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="fw-bold mb-1">Peserta Evaluasi</h3>
      <div class="text-muted">
        Webinar: <b>{{ $webinar->judul }}</b>
      </div>
    </div>

    <a href="{{ route('admin.laporan.evaluasi') }}"
       class="btn btn-outline-secondary">
      ← Kembali
    </a>
  </div>

  {{-- TABLE --}}
  <div class="card shadow-sm border-0">
    <div class="card-body">

      @if($pesertas->isEmpty())
        <div class="text-center text-muted py-4">
          Belum ada peserta yang mengisi evaluasi.
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th width="50">#</th>
                <th>Peserta</th>
                <th>Email</th>
                <th>Waktu Absensi</th>
                <th class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pesertas as $i => $peserta)
                <tr>
                  <td>{{ $i + 1 }}</td>

                  <td>
                    <div class="fw-semibold">
                      {{ $peserta->nama_peserta }}
                    </div>
                  </td>

                  <td>
                    {{ $peserta->email ?? '-' }}
                  </td>

                  <td>
                    {{ \Carbon\Carbon::parse($peserta->waktu_absen)->format('d M Y H:i') }}
                  </td>

                  <td class="text-end">
                    <a href="{{ route('admin.laporan.evaluasi.detail', $peserta->id) }}"
                       class="btn btn-sm btn-outline-primary">
                      Detail
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

    </div>
  </div>

</div>
@endsection
