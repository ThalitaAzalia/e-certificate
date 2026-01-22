@extends('layouts.app')
@section('title', 'Landing | E-Sertifikat & Webinar')

@section('content')

<!-- HERO -->
<section class="hero py-5">
  <div class="container">
    <div class="row g-4 hero-row"> {{-- ✅ sejajarkan tinggi kolom --}}
      
      <div class="col-lg-6 hero-left"> {{-- ✅ bikin isi kolom bisa center vertikal --}}
        <div class="hero-left-inner">
          <h1 class="hero-title mb-3">
            Platform Webinar Terintegrasi dengan Sistem E-Sertifikat Otomatis
          </h1>

          <p class="hero-subtitle text-muted mb-4">
            Platform resmi yang disediakan sebagai sarana pendukung pelaksanaan kegiatan webinar, yang mencakup pengelolaan 
            absensi peserta, evaluasi kepuasan kegiatan, serta penerbitan e-sertifikat secara otomatis. Kehadiran sistem ini
            bertujuan untuk meningkatkan kualitas pelayanan, efektivitas pelaksanaan kegiatan, serta tertib administrasi 
            di lingkungan penyelenggaraan webinar.
          </p>

          <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-brand rounded-16" href="#webinar">Lihat Webinar Terbaru</a>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card card-shadow rounded-16 overflow-hidden hero-card"> {{-- ✅ full height --}}
          <img
            src="{{ asset('images/hero.jpg') }}"
            class="hero-img"
            alt="Hero Badiklat"
          >

          <div class="p-3 bg-white">
            <div class="fw-semibold">Badiklat Hukum Jawa Tengah</div>
            <div class="small text-muted">Pusat pengembangan kompetensi & pelatihan hukum.</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- TENTANG -->
<section id="tentang" class="py-5">
  <div class="container">
    <div class="row g-4 align-items-center">
      <div class="col-lg-6">
        <h2 class="section-title mb-3">Deskripsi Umum Webinar Badiklat</h2>
        <p class="text-muted mb-3">
          Webinar Badiklat merupakan kegiatan pengembangan kompetensi yang diselenggarakan untuk mendukung
          peningkatan pengetahuan dan kapasitas peserta di bidang hukum. Melalui pemanfaatan sistem digital, 
          peserta dapat mengikuti kegiatan secara daring, melakukan absensi, mengisi evaluasi, serta memperoleh 
          e-sertifikat sebagai bukti keikutsertaan.<br>
          Melalui platform ini, peserta dapat melakukan absensi, mengisi evaluasi kepuasan, dan mengunduh e-sertifikat.
        </p>
        <ul class="text-muted mb-0">
          <li>Absensi mudah tanpa login</li>
          <li>Survei evaluasi webinar untuk peningkatan kualitas</li>
          <li>E-sertifikat otomatis setelah evaluasi selesai</li>
        </ul>
      </div>

      <div class="col-lg-6">
        <div class="card card-shadow rounded-16 overflow-hidden">
          <!-- ✅ TENTANG IMAGE -->
          <img
            src="{{ asset('images/tentang.jpg') }}"
            class="w-100"
            style="height:300px;object-fit:cover;object-position:30% 70%;"
            alt="Tentang Badiklat"
          >
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WEBINAR TERBARU -->
<section id="webinar" class="py-5 bg-soft">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
      <div>
        <h2 class="section-title mb-1">Webinar Terbaru</h2>
        <div class="text-muted">Informasi webinar aktif/terbaru akan tampil di sini.</div>
      </div>
    </div>

    @forelse ($webinars as $webinar)
      <div class="card card-shadow rounded-16 overflow-hidden mb-4">
        <div class="row g-0">

          <div class="col-lg-4">
            <img
              src="{{ $webinar->poster ? asset('storage/'.$webinar->poster) : asset('images/webinar.jpg') }}"
              class="w-100 h-100"
              style="object-fit:cover;min-height:220px;"
              alt="Banner Webinar"
            >
          </div>

          <div class="col-lg-8">
            <div class="p-4">

              <h3 class="h5 fw-bold mb-2">
                {{ $webinar->judul }}
              </h3>

              <p class="text-muted mb-3">
                {{ $webinar->deskripsi }}
              </p>

              <div class="row g-3 text-muted small">
                <div class="col-md-6">
                  <div>
                    <span class="fw-semibold">Tanggal:</span>
                    {{ \Carbon\Carbon::parse($webinar->tanggal)->translatedFormat('d F Y') }}
                  </div>

                  @if($webinar->waktu)
                    <div>
                      <span class="fw-semibold">Waktu:</span>
                      {{ \Carbon\Carbon::parse($webinar->waktu)->format('H:i') }} WIB
                    </div>
                  @endif
                </div>

                <div class="col-md-6">
                  @if($webinar->narasumber)
                    <div>
                      <span class="fw-semibold">Narasumber:</span>
                      {{ $webinar->narasumber }}
                    </div>
                  @endif

                  @if($webinar->media)
                    <div>
                      <span class="fw-semibold">Media:</span>
                      {{ $webinar->media }}
                    </div>
                  @endif
                </div>
              </div>

              <div class="d-flex gap-2 flex-wrap mt-4">
                <a href="{{ url('/absensi?webinar_id='.$webinar->id) }}"
                   class="btn btn-brand rounded-16">
                  Isi Absensi
                </a>

                @if($webinar->link_detail)
                  <a href="{{ $webinar->link_detail }}"
                     class="btn btn-outline-danger rounded-16">
                    Lihat Detail
                  </a>
                @endif
              </div>

            </div>
          </div>

        </div>
      </div>
    @empty
      <div class="text-center text-muted py-5">
        Belum ada webinar yang dipublikasikan.
      </div>
    @endforelse

  </div>
</section>


<!-- LOKASI / MAPS -->
<section id="lokasi" class="py-5 bg-soft">
  <div class="container">
    <h2 class="section-title mb-2">Lokasi Kami</h2>
    <p class="text-muted mb-4">Badiklat Hukum Jawa Tengah</p>

    <div class="row g-4">
      <div class="col-lg-7">
        <div class="card card-shadow rounded-16 overflow-hidden">
          <iframe
            src="https://www.google.com/maps?q=Badiklat%20Hukum%20Jawa%20Tengah&output=embed"
            width="100%" height="360" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="card card-shadow rounded-16 p-4 h-100">
          <div class="fw-bold mb-2 text-brand">Alamat</div>
          <div class="text-muted">
            Jl. Raya Mr. Moch Ichsan No.114, Wates, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50188, Indonesia
          </div>

          <hr class="my-4">

          <div class="fw-bold mb-2 text-brand">Jam Kerja</div>
          <div class="text-muted">
            Senin – Jumat<br>
            08.00 – 16.00 WIB
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- KONTAK -->
<section id="kontak" class="py-5">
  <div class="container">
    <div class="row g-4 align-items-stretch">

      <div class="col-lg-6">
        <h2 class="section-title mb-2">Kontak</h2>
        <p class="text-muted mb-4">Hubungi kami melalui kontak resmi berikut.</p>

        <div class="card card-shadow rounded-16 p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="fw-semibold text-brand">Learning Center</div>
              <div class="text-muted">badiklat.jateng@kemenkum.go.id</div>
            </div>
            <div class="col-md-6">
              <div class="fw-semibold text-brand">Telepon</div>
              <div class="text-muted">(+62)811-2896-960</div>
            </div>
            <div class="col-12">
              <div class="fw-semibold text-brand">Lokasi</div>
              <div class="text-muted">Kota Semarang, Jawa Tengah</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card card-shadow rounded-16 p-4 bg-soft h-100">
          <h3 class="h6 fw-bold mb-2 text-brand">Bantuan Cepat</h3>
          <p class="text-muted mb-3">
            Jika sudah mengisi data diri tetapi belum bisa mengakses survei/sertifikat,
            pastikan email benar dan coba ulangi pengisian data.
          </p>
          <a href="/absensi" class="btn btn-brand rounded-16 w-100">Ke Halaman Absensi</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer py-4">
  <div class="container">
    <div class="row g-3 align-items-center">
      <div class="col-md-6 d-flex align-items-center gap-2">
        <!-- ✅ logo sesuai file kamu -->
        <img src="{{ asset('images/logobadiklat.jpg') }}" class="brand-logo-sm" alt="Logo Badiklat">
        <div>
          <div class="fw-semibold">© {{ date('Y') }} Badiklat Hukum Jawa Tengah</div>
          <div class="small">E-Sertifikat & Webinar</div>
        </div>
      </div>

      <div class="col-md-6 text-md-end small">
        <a href="#tentang" class="me-3">Tentang</a>
        <a href="#webinar" class="me-3">Webinar</a>
        <a href="#lokasi" class="me-3">Lokasi</a>
        <a href="#kontak">Kontak</a>
      </div>
    </div>
  </div>
</footer>

<!-- MODAL detail webinar -->
<div class="modal fade" id="detailWebinarModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-16">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Detail Webinar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted mb-0">
          (Di sini nanti bisa menampilkan detail webinar lebih panjang, agenda, link zoom, dsb.)
        </p>
      </div>
      <div class="modal-footer">
        <a href="/absensi" class="btn btn-brand rounded-16" data-bs-dismiss="modal">Isi Data Diri</a>
        <button type="button" class="btn btn-outline-secondary rounded-16" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection