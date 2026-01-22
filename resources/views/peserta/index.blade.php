@extends('layouts.app')

@section('title', 'Data Peserta')

@section('content')
<div class="container py-5">

  <h2 class="mb-4">Daftar Peserta (Cek Database)</h2>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if($pesertas->isEmpty())
    <div class="alert alert-warning">
      Belum ada data peserta
    </div>
  @else
    <table class="table table-bordered">
      <thead class="table-danger">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No HP</th>
          <th>Waktu Absen</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pesertas as $p)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $p->nama_peserta }}</td>
          <td>{{ $p->email }}</td>
          <td>{{ $p->no_hp }}</td>
          <td>{{ $p->waktu_absen }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif

</div>
@endsection
