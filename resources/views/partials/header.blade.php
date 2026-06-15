<!-- Header/Navigation -->
<nav class="fixed inset-x-0 top-0 bg-gradient-to-r from-[#82C17D] to-[#6fa86a] shadow-md z-50"
    x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-2.5 flex items-center justify-between">

        <!-- Mobile Menu Button (Left side on mobile) -->
        <div class="flex md:hidden items-center">
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="text-white hover:text-green-100 focus:outline-none p-1 rounded-md transition-colors">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <!-- Hamburger icon -->
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                    <!-- Close (X) icon -->
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                </svg>
            </button>
        </div>

        <!-- Logo (Center on mobile, Left on desktop) -->
        <div class="flex items-center justify-center flex-grow md:flex-grow-0">
            <a href="{{ route('dashboard') }}" class="transform hover:scale-105 transition duration-300">
                <img src="/images/kjpp_logo.png" alt="Logo"
                    class="h-9 md:h-10 w-auto rounded-xl shadow-sm border border-white/20">
            </a>
        </div>

        <!-- Navigation Links (Desktop) -->
        <div class="hidden md:flex items-center space-x-2">
            @php
                $role = Auth::user()->role;
            @endphp

            @if($role === 'pekerjaTambahan')
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 rounded-full text-white/90 font-medium hover:bg-white/20 hover:text-white transition-all duration-200 text-sm">Survey</a>
                <a href="{{ route('chats.index') }}"
                    class="px-4 py-2 rounded-full text-white/90 font-medium hover:bg-white/20 hover:text-white transition-all duration-200 text-sm">Obrolan</a>
            @else
                <a href="{{ $role === 'client' ? route('properti.client') : route('properti.karyawan') }}"
                    class="px-4 py-2 rounded-full text-white/90 font-medium hover:bg-white/20 hover:text-white transition-all duration-200 text-sm">
                    Properti
                </a>
                <a href="{{ route('laporan.project') }}"
                    class="px-4 py-2 rounded-full text-white/90 font-medium hover:bg-white/20 hover:text-white transition-all duration-200 text-sm">Laporan</a>
                <a href="{{ route('chats.index') }}"
                    class="px-4 py-2 rounded-full text-white/90 font-medium hover:bg-white/20 hover:text-white transition-all duration-200 text-sm">Obrolan</a>
            @endif
        </div>

        <!-- User Dropdown -->
        <div class="relative flex items-center" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open"
                class="flex items-center space-x-3 focus:outline-none p-1 md:p-1.5 md:pr-3 rounded-full hover:bg-white/10 transition-colors border border-transparent hover:border-white/20">
                <!-- Avatar -->
                <div class="relative">
                    @if (Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                            class="h-8 w-8 md:h-9 md:w-9 rounded-full border-2 border-white/80 object-cover shadow-sm">
                    @else
                        <!-- Using UI Avatars for a modern dynamic initial avatar -->
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=82C17D&background=ffffff&bold=true&font-size=0.4"
                            alt="{{ Auth::user()->name }}"
                            class="h-8 w-8 md:h-9 md:w-9 rounded-full border-2 border-white/80 shadow-sm object-cover">
                    @endif
                    <!-- Online indicator dot -->
                    <div
                        class="absolute bottom-0 right-0 h-2 w-2 md:h-2.5 md:w-2.5 rounded-full bg-green-300 border-2 border-[#6fa86a]">
                    </div>
                </div>

                <!-- User Info (Hidden on mobile) -->
                <div class="hidden md:flex flex-col items-start">
                    <span class="text-sm font-bold text-white leading-none mb-1">{{ Auth::user()->name }}</span>
                    <span
                        class="text-[10px] font-semibold text-green-100/90 uppercase tracking-widest leading-none">{{ Auth::user()->role }}</span>
                </div>

                <svg class="hidden md:block w-4 h-4 text-white/80 transition-transform duration-300"
                    :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Profile Dropdown Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                class="absolute right-0 top-full mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
                style="display: none;">

                <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50 md:hidden">
                    <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mt-0.5">
                        {{ Auth::user()->role }}</p>
                </div>

                <div class="p-2">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-3 px-3 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-[#82C17D] transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Pengaturan Profil</span>
                    </a>

                    <div class="h-px bg-gray-100 my-2 mx-2"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center space-x-3 w-full text-left px-3 py-2.5 text-sm font-medium text-red-600 rounded-xl hover:bg-red-50 transition-colors">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu (Dropdown) -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full left-0 top-full"
        style="display: none;">

        <div class="px-4 py-4 flex flex-col space-y-2">
            @if($role === 'pekerjaTambahan')
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-3 rounded-xl text-gray-700 font-bold hover:bg-gray-50 hover:text-[#82C17D] flex items-center gap-3 transition">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    Survey
                </a>
                <a href="{{ route('chats.index') }}"
                    class="px-4 py-3 rounded-xl text-gray-700 font-bold hover:bg-gray-50 hover:text-[#82C17D] flex items-center gap-3 transition">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    Obrolan
                </a>
            @else
                <a href="{{ $role === 'client' ? route('properti.client') : route('properti.karyawan') }}"
                    class="px-4 py-3 rounded-xl text-gray-700 font-bold hover:bg-gray-50 hover:text-[#82C17D] flex items-center gap-3 transition">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Properti
                </a>
                <a href="{{ route('laporan.project') }}"
                    class="px-4 py-3 rounded-xl text-gray-700 font-bold hover:bg-gray-50 hover:text-[#82C17D] flex items-center gap-3 transition">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Laporan
                </a>
                <a href="{{ route('chats.index') }}"
                    class="px-4 py-3 rounded-xl text-gray-700 font-bold hover:bg-gray-50 hover:text-[#82C17D] flex items-center gap-3 transition">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    Obrolan
                </a>
            @endif
        </div>
    </div>
</nav>