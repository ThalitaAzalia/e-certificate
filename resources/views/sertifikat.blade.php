@extends('layouts.app')

@section('title', 'Unduh Sertifikat Digital')

@section('content')
<div class="certificate-container min-vh-100 d-flex align-items-center justify-content-center py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-5">

        {{-- Pesan Sukses --}}
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0" role="alert">
            <div class="d-flex align-items-center">
              <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" class="me-2">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
              </svg>
              <span class="fw-medium">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
          </div>
        @endif

        {{-- Kartu Sertifikat --}}
        <div class="card border-0 shadow-lg overflow-hidden">

          {{-- Header --}}
          <div class="certificate-header position-relative text-white py-4 px-4">
            <div class="position-absolute top-0 end-0 mt-3 me-3">
              <svg width="24" height="24" viewBox="0 0 16 16" fill="currentColor">
                <path d="M8 0l1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864 8 0z"/>
                <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
              </svg>
            </div>
            <h1 class="h4 mb-0 fw-light">SERTIFIKAT DIGITAL</h1>
            <div class="small opacity-75 mt-1">Sertifikat Webinar</div>
          </div>

          {{-- Body --}}
          <div class="card-body p-4 p-md-5">

            {{-- Informasi Peserta --}}
            <div class="text-center mb-5">
              <div class="mb-3">
                <div class="text-uppercase small text-muted fw-semibold letter-spacing-wide">Penerima Sertifikat</div>
                <h2 class="display-5 fw-bold text-dark mt-2 mb-3">{{ $nama }}</h2>
                <div class="separator mx-auto"></div>
              </div>

              <p class="text-muted mb-0">
                Sertifikat ini diberikan sebagai bentuk apresiasi atas keikutsertaan peserta.
              </p>
            </div>

            {{-- Tombol Unduh --}}
            <div class="text-center pt-2">
              <a href="{{ route('sertifikat.download') }}" class="btn-download-certificate btn btn-lg w-100 py-3 fw-semibold shadow-sm">
                <div class="d-flex align-items-center justify-content-center">
                  <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" class="me-2">
                    <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                    <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                  </svg>
                  Unduh Sertifikat (PDF)
                </div>
                <div class="mt-1 small text-white opacity-75">Sertifikat digital resolusi tinggi (HD)</div>
              </a>

            </div>
          </div>

          {{-- Footer --}}
          <div class="card-footer bg-transparent border-0 text-center py-4"></div>
        </div>

        {{-- Catatan Verifikasi --}}
        <div class="text-center mt-4">
          <p class="small text-muted mb-0">
            Sertifikat digital ini aman dan dapat diverifikasi
          </p>
        </div>

      </div>
    </div>
  </div>
</div>
<style>

.certificate-container{
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  min-height: 100vh;
}

.certificate-header{
  background: linear-gradient(90deg, #9b0000 0%, #c62828 100%);
  position: relative;
  overflow: hidden;
}

.certificate-header::before{
  content:"";
  position:absolute;
  inset:0;
  background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
  opacity:.3;
}

.btn-download-certificate{
  background: linear-gradient(90deg, #9b0000 0%, #b10000 100%);
  border:none;
  color:#fff;
  transition: all .3s ease;
  position: relative;
  overflow: hidden;
}

.btn-download-certificate:hover{
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(155,0,0,.30) !important;
}

.btn-download-certificate::after{
  content:"";
  position:absolute;
  top:50%;
  left:50%;
  width:5px;
  height:5px;
  background: rgba(255,255,255,.5);
  opacity:0;
  border-radius:100%;
  transform: scale(1,1) translate(-50%);
  transform-origin: 50% 50%;
}

.btn-download-certificate:focus:not(:active)::after{
  animation: ripple 1s ease-out;
}

@keyframes ripple{
  0%{ transform: scale(0,0); opacity:.5; }
  100%{ transform: scale(40,40); opacity:0; }
}

.separator{
  width: 80px;
  height: 3px;
  background: linear-gradient(90deg, #9b0000 0%, #c62828 100%);
  margin: 1.5rem auto;
}

.certificate-details{
  border-left: 4px solid #9b0000;
}

.letter-spacing-wide{
  letter-spacing: .1em;
}

@media (max-width: 768px){
  .display-5{ font-size: 2.5rem; }
  .card-body{ padding: 2rem !important; }
}

@media print{
  .certificate-container{ background: #fff !important; }
  .btn-download-certificate,
  .card-footer,
  .border-top{ display: none !important; }
}

.certificate-date-card{
  background: linear-gradient(
    135deg,
    #fff5f5 0%,
    #ffecec 100%
  );
  border-left: 6px solid #9b0000;
  border-radius: 14px;

  box-shadow:
    0 12px 30px rgba(155, 0, 0, 0.18),
    0 4px 12px rgba(0, 0, 0, 0.08);
}

.certificate-date-card .label{
  font-size: 12px;
  font-weight: 700;
  color: #7a0000;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  margin-bottom: 6px;
}

.certificate-date-card .value{
  font-size: 22px;
  font-weight: 900;
  color: #2b2b2b;
}
/* =====================================
   TOMBOL UNDUH 
   ===================================== */

.btn-download-certificate{
  width: auto !important;          
  max-width: 250px;                
  margin: 0 auto;                 
  padding: 12px 16px !important;   
  border-radius: 14px !important;
  display: block;
}

/* teks utama */
.btn-download-certificate > div:first-child{
  font-size: 14px;
  font-weight: 700;
  white-space: nowrap;  
}

/* icon */
.btn-download-certificate svg{
  width: 15px;
  height: 15px;
}

.btn-download-certificate .small{
  font-size: 11px;
  margin-top: 2px !important;
  line-height: 1.2;
  opacity: .8;
}

@media (max-width: 572px){
  .btn-download-certificate{
    max-width: 260px;
    padding: 11px 14px !important;
  }

  .btn-download-certificate > div:first-child{
    font-size: 13px;
  }

  .btn-download-certificate .small{
    font-size: 10px;
  }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const card = document.querySelector('.card');
  if (!card) return;

  card.style.opacity = '0';
  card.style.transform = 'translateY(20px)';

  setTimeout(() => {
    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    card.style.opacity = '1';
    card.style.transform = 'translateY(0)';
  }, 100);

  const downloadBtn = document.querySelector('.btn-download-certificate');
  if (downloadBtn) {
    downloadBtn.addEventListener('click', function() {
      console.log('Unduh sertifikat dimulai untuk: {{ $nama }}');
    });
  }
});
</script>
@endsection
