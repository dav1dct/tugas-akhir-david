@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<!-- LOGO PERUSAHAAN -->
<div class="container flex justify-center mb-10 bg-white border-none">
        <img src="{{ asset('assets/img/LogoFull.png') }}" 
             alt="Logo PT Citra Satria Utama" 
             class="max-h-28 w-auto drop-shadow-md">
</div>

<div class="container mx-auto px-6 py-10 max-w-7xl">
    <!-- Header -->
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Dashboard</h1>
        <p class="text-white mt-2 text-xl">Selamat datang kembali, {{ auth()->user()->name }}</p>
    </div>

    <!-- Judul Profil dengan gap besar -->
    <h2 class="text-4xl font-bold text-white text-center">Profil Perusahaan</h2>
    <h2 class="text-center">‎</h2>

    <!-- ==================== PROFIL PERUSAHAAN ==================== -->
    <div class="mb-12 bg-white rounded-3xl shadow-xl border-2 border-gray-200 p-12 md:p-16">
        <div class="prose prose-lg text-gray-700 leading-relaxed max-w-none">
            <p>Distributor produk Frisian Flag, Nestle, Mayora, Kalbe, Mondelez, Sosro & Otsuka di wilayah Palembang, OKI, Prabumulih, Banyuasin dan Musi Banyuasin.</p>
            <p><strong>PT Citra Satria Utama</strong> (disingkat <strong>CSU</strong>) berdiri pada tanggal <strong>11 Januari 2003</strong>, merupakan perusahaan distribusi lokal dengan pemilik tunggal <strong>Chrysantus Hasan Taslim</strong>.</p>
            <p>Produk yang pertama kali dipegang adalah <strong>Susu SGM</strong> dari <strong>Sari Husada</strong> selama kurang lebih 4 tahun hingga tahun 2007. Setelah itu, perusahaan menjadi <strong>subdistributor produk Tiga Raksa Satria</strong> untuk area pemasaran di Palembang, Prabumulih, Muara Enim, OKI, dan MUBA.</p>
            <p>Kantor operasional berlokasi di <strong>Palembang</strong> dan <strong>Muara Enim</strong>. Lokasi kantor dan gudang di Palembang awalnya di Jl. Perintis Kemerdekaan dan kemudian pindah ke Komplek Pergudangan Palembang Star.</p>
            <p>Total karyawan pada saat itu sekitar <strong>30 orang</strong>.</p>
        </div>
    </div>
</div>
</section>

    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'hsd')
        <div class="container">
            <h2>PENGUMUMAN</h2>

            @if (session('success'))
                <div class="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('dashboard.upload.pdf') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Upload Pengumuman (PDF):</label>
                    <input type="file" name="file" id="file" accept="application/pdf" required>
                </div>
                <button type="submit">Upload</button>
            </form>
        </div>
    @endif

@endsection
