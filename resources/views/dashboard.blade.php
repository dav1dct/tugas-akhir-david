@extends('layouts.app')

@section('content')

<!-- LOGO PERUSAHAAN -->
<div class="text-center py-4 bg-white border-bottom">
    <img src="{{ asset('assets/img/LogoFull.png') }}"
         alt="Logo PT Citra Satria Utama"
         style="max-height: 120px; width: auto;">
</div>

<div class="container py-5">

    <!-- Header Selamat Datang -->
    <div class="mb-4">
        <h1 class="fw-bold text-dark">Dashboard</h1>
        <p class="text-muted fs-5">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong></p>
    </div>

    <!-- ===================== CAROUSEL ===================== -->
    <div id="dashboardCarousel" class="carousel slide mb-5 rounded-4 overflow-hidden shadow-sm"
         data-bs-ride="carousel" style="border: 2px solid #dee2e6;">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#dashboardCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#dashboardCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#dashboardCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://lh3.googleusercontent.com/gps-cs-s/AHVAweoLZgxjB-9jKrJy7VZe_r9DCWLXeNAklBmwJLfg24EW-9BXkbS8zlektUHyJUoyJRG4n-H0uUtPDEhAcbgRofN4jKNS08ngPLi3ypUNugHrhFipslnsZzFpVSOMB0A67V7XgvAh=s1360-w1360-h1020-rw"
                     class="d-block w-100" style="height: 450px; object-fit: contain; background-color: #f8f9fa;" alt="Gambar 1">
            </div>

            <div class="carousel-item">
                <img src="https://lh3.googleusercontent.com/gps-cs-s/AHVAweo8SUKRF6WJWAFNh-tdl_7wPjO-GK7-lWIjEh-ohdhbulIc7ILA6r7I48s44UfcnF6nBEuHWEIH_otVTxCO3cNFXhX90My0AHRNRQxRl4xY4FgtGJuCL3ZiPXhhJmYmW5Q8bTns=s1360-w1360-h1020-rw"
                     class="d-block w-100" style="height: 450px; object-fit: contain; background-color: #f8f9fa;" alt="Gambar 2">
            </div>
  
            <div class="carousel-item">
                <img src="https://lh3.googleusercontent.com/gps-cs-s/AHVAweqVyzqRv9u3a_EpmP_U4157CFu7giQGe30TYQsFO25CIKRUqbcI_qWLE7o-TpZZ6p94E6-1glx1kAMnyQy1KxuWQtlLJpRaXFiPyi0B4_CG9UHpYceRJxJfcrmK9RBJIYeiqpc=s1360-w1360-h1020-rw"
                     class="d-block w-100" style="height: 450px; object-fit: contain; background-color: #f8f9fa;" alt="Gambar 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" style="filter: invert(1) brightness(0);"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" style="filter: invert(1) brightness(0);"></span>
        </button>
    </div>
    <!-- ===================================================== -->

    <!-- Profil Perusahaan -->
    <h2 class="fw-bold text-center mb-4">Profil Perusahaan</h2>

    <div class="card shadow-sm rounded-4 p-4 p-md-5 mb-5" style="border: 2px solid #dee2e6;">
        <div class="card-body">
            <p class="text-muted">Distributor produk Frisian Flag, Nestle, Mayora, Kalbe, Mondelez, Sosro &amp; Otsuka di wilayah Palembang, OKI, Prabumulih, Banyuasin dan Musi Banyuasin.</p>
            <p><strong>PT Citra Satria Utama</strong> (disingkat <strong>CSU</strong>) berdiri pada tanggal <strong>11 Januari 2003</strong>, merupakan perusahaan distribusi lokal dengan pemilik tunggal <strong>Chrysantus Hasan Taslim</strong>.</p>
            <p>Produk yang pertama kali dipegang adalah <strong>Susu SGM</strong> dari <strong>Sari Husada</strong> selama kurang lebih 4 tahun hingga tahun 2007. Setelah itu, perusahaan menjadi <strong>subdistributor produk Tiga Raksa Satria</strong> untuk area pemasaran di Palembang, Prabumulih, Muara Enim, OKI, dan MUBA.</p>
            <p>Kantor operasional berlokasi di <strong>Palembang</strong> dan <strong>Muara Enim</strong>. Lokasi kantor dan gudang di Palembang awalnya di Jl. Perintis Kemerdekaan dan kemudian pindah ke Komplek Pergudangan Palembang Star.</p>
            <p class="mb-0">Total karyawan pada saat itu sekitar <strong>30 orang</strong>.</p>
        </div>
    </div>

    <!-- Upload Pengumuman (hanya admin & hsd) -->
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'hsd')
        <div class="card shadow-sm rounded-4 p-4 mb-5" style="border: 2px solid #dee2e6;">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Upload Pengumuman</h5>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('dashboard.upload.pdf') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">File Pengumuman (PDF)</label>
                        <input type="file" name="file" id="file" accept="application/pdf" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    @endif

</div>

@endsection