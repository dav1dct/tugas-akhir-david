@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'hsd')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-1 mb-6 text-white">
        <div class="bg-gray-800 p-4 shadow">
            <h3 class="text-lg font-semibold">Jumlah Karyawan</h3>
            <p class="text-2xl">{{ $jumlahKaryawan }}</p>
        </div>
        <div class="bg-gray-800 p-4 shadow">
            <h3 class="text-lg font-semibold">Jumlah Karyawan Baru</h3>
            <p class="text-2xl">{{ $jumlahKaryawanBaru }}</p>
        </div>
    </div>
    @endif


    <section class="bg-white dark:bg-[#161615] border-4 border-black text-gray-800 dark:text-gray-200 p-8 shadow-md w-full max-w-3xl mx-auto mt-10 text-center">
    <h1 style="font-size: 36px" class="font-bold mb-6 pb-3">
        Profil Perusahaan
    </h1>
    <p class="text-base leading-relaxed space-y-4">
        Distributor produk Frisian Flag, Nestle, Mayora, Kalbe, Mondelez, Sosro & Otsuka di wilayah Palembang, OKI, Prabumulih, Banyuasin dan Musi Banyuasin. <br>
        <strong>PT Citra Satria Utama</strong> (disingkat <strong>CSU</strong>) berdiri pada tanggal <strong>11 Januari 2003</strong>, <br>
        merupakan perusahaan distribusi lokal dengan pemilik tunggal <strong>Chrysantus Hasan Taslim</strong>. <br>
        Produk yang pertama kali dipegang adalah <strong>Susu SGM</strong> dari <strong>Sari Husada</strong> selama kurang lebih 4 tahun hingga tahun 2007. <br>
        Setelah itu, perusahaan menjadi <strong>subdistributor produk Tiga Raksa Satria</strong> untuk area pemasaran di <br>
        Palembang, Prabumulih, Muara Enim, OKI, dan MUBA. <br>
        Kantor operasional berlokasi di <strong>Palembang</strong> dan <strong>Muara Enim</strong>. <br>
        Lokasi kantor dan gudang di Palembang awalnya di Jl. Perintis Kemerdekaan dan kemudian pindah ke Komplek Pergudangan Palembang Star. <br>
        Total karyawan pada saat itu sekitar <strong>30 orang</strong>. <br>
    </p>
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
