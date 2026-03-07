<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="block h-9 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-8">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if(in_array(auth()->user()->role, ['admin', 'hsd', 'pimpinan']))
                        <x-nav-link :href="route('attendances.index')" :active="request()->routeIs('attendances.index')">
                            Absensi
                        </x-nav-link>
                    @endif

                    <!-- Cuti Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="bg-transparent text-gray-800 hover:text-gray-900 text-sm font-medium flex items-center transition-colors">
                                Cuti
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('leaves.index')">Daftar Cuti</x-dropdown-link>
                            <x-dropdown-link :href="route('jenis-cuti.index')">Jenis Cuti</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Karyawan Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="bg-transparent text-gray-800 hover:text-gray-900 text-sm font-medium flex items-center transition-colors">
                                Karyawan
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('karyawan.index')">Daftar Karyawan</x-dropdown-link>
                            @if(in_array(auth()->user()->role, ['admin', 'hsd', 'pimpinan']))
                                <x-dropdown-link :href="route('karyawanbaru.index')">Karyawan Baru</x-dropdown-link>
                            @endif
                        </x-slot>
                    </x-dropdown>

                    <!-- Struktur Organisasi Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="bg-transparent text-gray-800 hover:text-gray-900 text-sm font-medium flex items-center transition-colors">
                                Struktur Organisasi
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('departemen.index')">Departemen</x-dropdown-link>
                            <x-dropdown-link :href="route('jabatan.index')">Jabatan</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                </div>
                @endauth
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 transition">
                            {{ Auth::user()->name }}
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="text-gray-700 p-2">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden bg-white border-t border-gray-200">
        <div class="px-4 py-4 space-y-2 text-gray-700">
            <!-- Mobile links sama seperti sebelumnya, tinggal copy kalau perlu -->
        </div>
    </div>
    <!-- Mobile Menu (sudah disesuaikan juga) -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            
            @if(in_array(auth()->user()->role, ['admin', 'hsd', 'pimpinan']))
                <x-responsive-nav-link :href="route('attendances.index')" :active="request()->routeIs('attendances.index')">
                    Absensi
                </x-responsive-nav-link>
            @endif

            <div class="px-4 py-2 text-xs font-medium text-gray-400">CUTI</div>
            <x-responsive-nav-link :href="route('leaves.index')" :active="request()->routeIs('leaves.index')">
                Daftar Cuti
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('jenis-cuti.index')" :active="request()->routeIs('jenis-cuti.index')">
                Jenis Cuti
            </x-responsive-nav-link>

            <div class="px-4 py-2 text-xs font-medium text-gray-400">KARYAWAN</div>
            <x-responsive-nav-link :href="route('karyawan.index')" :active="request()->routeIs('karyawan.index')">
                Daftar Karyawan
            </x-responsive-nav-link>
            @if(in_array(auth()->user()->role, ['admin', 'hsd', 'pimpinan']))
                <x-responsive-nav-link :href="route('karyawanbaru.index')" :active="request()->routeIs('karyawanbaru.index')">
                    Karyawan Baru
                </x-responsive-nav-link>
            @endif

            <div class="px-4 py-2 text-xs font-medium text-gray-400">STRUKTUR ORGANISASI</div>
            <x-responsive-nav-link :href="route('departemen.index')" :active="request()->routeIs('departemen.index')">
                Departemen
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('jabatan.index')" :active="request()->routeIs('jabatan.index')">
                Jabatan
            </x-responsive-nav-link>
        </div>
    </div>
</nav>