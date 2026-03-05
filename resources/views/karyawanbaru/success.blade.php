<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PT Citra Satria Utama</title>
        <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- CoreUI CSS -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- CoreUI JS -->
        <script src="{{ asset('public/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else

        @endif
    </head>
    <body class="bg-[#161615] dark:bg-[#161615] text-[#EDEDEC] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">           
    </header>

    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
            <!-- Gambar -->
            <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-20 bg-[#161615] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
                <!-- Tulisan -->
                <h1 class="font-bold mb-6 text-gray-900 dark:text-white" style="font-family: 'BD-Wurst'; font-size: 80px; text-align: center; line-height: 1.0;">
                    Daftar <br>
                    Berhasil<br>
                </h1>
                <h4 class="font-inter font-bold mb-4 text-gray-900 dark:text-white" style="font-size: 18px; text-align: center; line-height: 1.0;">DATA PENDAFTARAN ANDA AKAN SEGERA KAMI PROSES</h4>
            </div>
            <div class="bg-[#161615] dark:bg-[#161615] relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg w-full lg:w-[438px] shrink-0 overflow-hidden shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] flex justify-center items-center">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo CSU" class="w-full h-full object-contain" />
            </div>
        </main>
    </div>
            <!-- Tombol daftar karyawan -->
            <div class="mt-auto w-full lg:w-[438px]">
            <a
                href="{{ url('/') }}"
                style="font-inter; font-weight: bold"
                class="inline-block w-full border-4 px-8 py-4 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-lg leading-normal text-center">
                KEMBALI KE HALAMAN UTAMA
            </a>
        </div>
    </body>
</html>
