@extends('layouts.app')
@section('title', 'Landing | Layanan E-Sertifikat Webinar')

@push('styles')
<style>
  /* ===========================
     FLOATING CARD: KHUSUS LANDING PAGE
     (biar card di halaman lain nggak ikut melayang)
     =========================== */
  @keyframes floatCard{
    0%, 100% { transform: translateY(0px); }
    50%      { transform: translateY(-8px); }
  }

  /* Target hanya card yg ada di landing (card-shadow), bukan semua .card global */
  .landing-page .card.card-shadow{
    animation: floatCard 4s ease-in-out infinite;
    will-change: transform;
  }

  /* beda timing biar nggak bareng */
  .landing-page .card.card-shadow:nth-of-type(2){ animation-duration: 4.6s; }
  .landing-page .card.card-shadow:nth-of-type(3){ animation-duration: 5.2s; }
  .landing-page .card.card-shadow:nth-of-type(4){ animation-duration: 5.8s; }

  /* hover (landing saja) */
  .landing-page .card.card-shadow:hover{
    transform: translateY(-8px) scale(1.01);
    transition: transform .25s ease, box-shadow .25s ease;
  }

  /* ===========================
     KONTAK: FIX jadi 2x2 kartu
     =========================== */
  #kontak .contact-card{
    background:#fff;
    border-radius: 26px;
    padding: 28px 30px;
    box-shadow: 0 18px 40px rgba(2,6,23,.10);
    border: 1px solid rgba(15,23,42,.06);
    min-height: 150px;

    cursor:pointer;
    transition: transform .25s ease, background .25s ease, box-shadow .25s ease, border-color .25s ease;
  }

  #kontak .contact-title{
    margin:0 0 10px;
    font-weight: 800;
    font-size: 20px;
    display:flex;
    align-items:center;
    gap: 14px;
    color: #0f172a;
  }

  #kontak .contact-desc{
    margin:0;
    font-size: 15px;
    color: rgba(15,23,42,.78);
    line-height: 1.6;
  }

  #kontak .contact-ico{
    width: 34px;
    height: 34px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    color: rgba(15,23,42,.88);
    flex: 0 0 auto;
  }

  /* Hover jadi merah */
  #kontak .contact-card:hover{
    background:#9b0000;
    border-color: rgba(155,0,0,.35);
    transform: translateY(-4px);
    box-shadow: 0 22px 48px rgba(155,0,0,.22);
  }
  #kontak .contact-card:hover .contact-title,
  #kontak .contact-card:hover .contact-desc,
  #kontak .contact-card:hover .contact-ico{
    color:#fff !important;
  }

  /* click feel */
  #kontak .contact-card:active{
    transform: translateY(-1px) scale(.99);
  }

  /* default merah (Kontak Kami) */
  #kontak .contact-card.is-red{
    background:#9b0000;
    border-color: rgba(155,0,0,.35);
    box-shadow: 0 22px 48px rgba(155,0,0,.22);
  }
  #kontak .contact-card.is-red .contact-title,
  #kontak .contact-card.is-red .contact-desc,
  #kontak .contact-card.is-red .contact-ico{
    color:#fff !important;
  }

  /* ====== KECILIN NAVBAR (HEADER MENU) ====== */
  .navbar{
    padding-top: 8px !important;
    padding-bottom: 8px !important;
    min-height: 64px;
  }

  .navbar .navbar-nav .nav-link{
    padding: 8px 12px !important;
    font-size: 15px !important;
    line-height: 1.2 !important;
  }

  .navbar .btn,
  .navbar .nav-item .btn{
    padding: 8px 12px !important;
    font-size: 15px !important;
  }

  .navbar .navbar-toggler{
    padding: 6px 10px !important;
  }

  /* ===========================
     HERO: AKSEN MERAH DIAGONAL
     =========================== */
  .hero{
    position: relative;
    overflow: hidden;
    background: #f6f7f9 !important;
  }

  .hero::after{
    content:"";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 520px;
    height: 380px;
    background: #9b0000;
    clip-path: polygon(0 55%, 38% 100%, 0 100%);
    z-index: 0;
    pointer-events: none;
  }

  .hero .container{
    position: relative;
    z-index: 2;
  }

  .hero-left-inner{
    max-width: 640px;
    padding-bottom: 20px;
  }

  .hero-title{
    margin-bottom: 16px !important;
  }

  .hero-subtitle{
    margin-bottom: 22px !important;
    color: rgba(31,41,55,.78) !important;
  }

  .hero .btn-brand{
    box-shadow: 0 12px 26px rgba(155,0,0,.28);
    margin-top: 6px;
  }

  /* ===== NAVBAR ===== */
  .navbar .container{
    padding-top: 6px !important;
    padding-bottom: 6px !important;
  }

  .navbar{
    min-height: 54px !important;
  }

  /* paksa logo supaya gak ikut ukuran asli gambar */
  .navbar .navbar-brand img,
  .navbar .brand-logo{
    width: 34px !important;
    height: 34px !important;
    max-width: 34px !important;
    max-height: 34px !important;
    object-fit: contain !important;
  }

  /* kecilin teks brand */
  .navbar .navbar-brand .fw-bold{
    font-size: 14px !important;
    line-height: 1.1 !important;
  }
  .navbar .navbar-brand .small{
    font-size: 12px !important;
    line-height: 1.1 !important;
  }

  /* kecilin menu kanan */
  .navbar .navbar-nav .nav-link{
    padding: 6px 10px !important;
    font-size: 13px !important;
    line-height: 1.1 !important;
  }

  /* kecilin tombol hamburger */
  .navbar .navbar-toggler{
    padding: 4px 8px !important;
  }
</style>
@endpush

@section('content')
<div class="landing-page">
<!-- HERO -->
<section class="hero py-5">
  <div class="container">
    <div class="row g-4 hero-row">
      <div class="col-lg-6 hero-left">
        <div class="hero-left-inner">
          <h1 class="section-title mb-3">
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
        <div class="card card-shadow rounded-16 overflow-hidden hero-card">
          <img src="{{ asset('images/hero.jpg') }}" class="hero-img" alt="Hero Bapelkum">
          <div class="p-3 bg-white">
            <div class="fw-semibold">Balai Pelatihan Hukum Semarang</div>
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
        <h2 class="section-title mb-3">Deskripsi Umum Webinar Bapelkum</h2>
        <p class="text-muted mb-3">
          Webinar Bapelkum merupakan kegiatan pengembangan kompetensi yang diselenggarakan untuk mendukung
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
          <img
            src="{{ asset('images/tentang.jpg') }}"
            class="w-100"
            style="height:300px;object-fit:cover;object-position:30% 70%;"
            alt="Tentang Bapelkum"
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
    <p class="text-muted mb-4">Balai Pelatihan Hukum Semarang</p>

    <div class="row g-4">
      <div class="col-lg-7">
        <div class="card card-shadow rounded-16 overflow-hidden">
          <iframe
            src="https://www.google.com/maps?q=Bapelkum%20Semarang&output=embed"
            width="100%" height="360" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="card card-shadowsadow rounded-16 p-4 h-100">
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

<!-- KONTAK (2x2 KARTU + hover merah, telepon default merah) -->
<section id="kontak" class="py-5">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-4">
      <div>
        <h2 class="section-title mb-1">Kontak</h2>
        <div class="text-muted">Informasi kontak resmi Balai Pelatihan Hukum Semarang.</div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Lokasi -->
      <div class="col-lg-6">
        <div class="contact-card" role="button" tabindex="0"
          onclick="document.getElementById('lokasi')?.scrollIntoView({behavior:'smooth'})">
          <div class="contact-title">
            <span class="contact-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="32" height="32" fill="none">
                <path d="M12 21s7-5.1 7-11a7 7 0 1 0-14 0c0 5.9 7 11 7 11Z" stroke="currentColor" stroke-width="2"/>
                <path d="M12 10.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" stroke="currentColor" stroke-width="2"/>
              </svg>
            </span>
            Lokasi Kami
          </div>
          <p class="contact-desc">
            Jl. Raya Mr. Moch Ichsan No.114, Wates, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50188
          </p>
        </div>
      </div>

      <!-- Email -->
      <div class="col-lg-6">
        <div class="contact-card" role="button" tabindex="0"
          onclick="window.location.href='mailto:bapelkum.jateng@kemenkum.go.id'">
          <div class="contact-title">
            <span class="contact-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="32" height="32" fill="none">
                <path d="M4 6h16v12H4V6Z" stroke="currentColor" stroke-width="2"/>
                <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="2"/>
              </svg>
            </span>
            Email Kami
          </div> 
          <p class="contact-desc">bapelkum.jateng@kemenkum.go.id</p>
        </div>
      </div>

      <!-- Telepon -->
      <div class="col-lg-6">
        <div class="contact-card" role="button" tabindex="0"
          onclick="window.location.href='tel:+628112896960'">
          <div class="contact-title">
            <span class="contact-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="32" height="32" fill="none">
                <path d="M7 3h3l2 6-2 1c1.5 3 3.5 5 6.5 6.5l1-2 6 2v3c0 1-1 2-2 2C9.5 22 2 14.5 2 5c0-1 1-2 2-2h3Z" stroke="currentColor" stroke-width="2"/>
              </svg>
            </span>
            Kontak Kami
          </div>
          <p class="contact-desc fw-bold">
            (024) 35320020<br>
            0811-2896-960
          </p>
        </div>
      </div>

      <!-- Office Hours -->
      <div class="col-lg-6">
        <div class="contact-card">
          <div class="contact-title">
            <span class="contact-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="32" height="32" fill="none">
                <path d="M7 3v3M17 3v3" stroke="currentColor" stroke-width="2"/>
                <path d="M4 7h16v13H4V7Z" stroke="currentColor" stroke-width="2"/>
                <path d="M7 11h3M7 15h3M13 11h3M13 15h3" stroke="currentColor" stroke-width="2"/>
              </svg>
            </span>
            Office Hours
          </div>
          <p class="contact-desc text-uppercase fw-bold" style="font-size:18px;">
            Senin – Jumat (08:00 WIB – 16:00 WIB)
          </p>
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
        <img src="{{ asset('images/logobapelkum.jpg') }}" class="brand-logo-sm" alt="Logo BApelkum">
        <div>
          <div class="fw-semibold">© {{ date('Y') }} Balai Pelatihan Hukum Semarang</div>
          <div class="small">Layanan E-Sertifikat Webinar</div>
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

@endsection
