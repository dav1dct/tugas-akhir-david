<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PT Citra Satria Utama</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">

    <!-- CoreUI CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- CoreUI JS -->
    <script src="{{ asset('public/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-[#161615] dark:bg-[#161615] text-[#EDEDEC] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="w-full border-b-2 border-black dark:border-white pb-2 mb-6">
        <header class="w-full max-w-4xl mx-auto text-sm px-4">
            <div class="flex items-center justify-between w-full flex-wrap">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/img/logoFull.png') }}" alt="Logo PT Citra Satria Utama" class="w-16 h-16">
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        <nav class="flex flex-row items-center gap-2">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-2 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#EDEDEC] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-2 py-1.5 dark:text-[#EDEDEC] text-[#EDEDEC] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-2 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#EDEDEC] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </header>
    </div>

    @if (Storage::disk('public')->exists('pengumuman.pdf'))
    <div class="pengumuman-container">
        <h2 class="pengumuman-title">PENGUMUMAN</h2>
        <iframe src="{{ route('pengumuman.view') }}?v={{ now()->timestamp }}" class="pengumuman-frame" frameborder="0"></iframe>
    </div>
    @else
        <p class="text-white dark:text-white text-center">Belum ada pengumuman tersedia.</p>
    @endif


    <div class="my-4">
        <label class="inline-flex items-center">
            <input type="checkbox" id="toggleDaftar" class="form-checkbox text-blue-600">
            <span class="ml-2 text-black dark:text-white" style="font-inter; font-weight: bold">Saya ingin melamar</span>
        </label>
    </div>

    <div id="daftarContainer" class="hidden mt-4 w-full lg:w-[438px]">
        <a href="{{ url('/daftar') }}"
        class="inline-block w-full px-8 py-4 dark:text-[#EDEDEC] border-2 border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-lg leading-normal text-center"
        style="font-inter; font-weight: bold">
        FORM PENDAFTARAN KARYAWAN BARU
        </a>
    </div>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
    
    <script>
    const checkbox = document.getElementById('toggleDaftar');
    const daftarContainer = document.getElementById('daftarContainer');

    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            daftarContainer.classList.remove('hidden');
        } else {
            daftarContainer.classList.add('hidden');
        }
    });
</script> 
</body>
</html>
