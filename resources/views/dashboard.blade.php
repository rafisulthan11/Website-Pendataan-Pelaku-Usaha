<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl sm:text-3xl text-slate-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Welcome card -->
            <div class="bg-white/90 border border-slate-200 shadow-sm rounded-md p-5 sm:p-6 mb-6">
                <h3 class="text-xl font-extrabold text-slate-800 mb-2">
                    Selamat Datang, {{ auth()->user()->nama_lengkap }} ({{ auth()->user()->role->nama_role }})!
                </h3>
                <p class="text-slate-600">Anda telah masuk ke sistem informasi pendataan bidang perikanan budidaya dan pasca panen dinas perikanan jember.</p>
            </div>

            @if(auth()->user()->isAdminOrSuperAdmin())
            <!-- Grafik Statistik (placeholder cards) -->
            <h4 class="text-lg sm:text-xl font-extrabold text-slate-800 mb-3">Grafik Statistik</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
                    <div class="bg-indigo-200/60 rounded-md shadow-[0_6px_0_rgba(15,23,42,0.3)]">
                    <div class="p-4">
                        <p class="font-semibold text-slate-800">Pelaku Usaha</p>
                        <div class="mt-4 h-16 flex items-center justify-end text-slate-700">
                            <img src="{{ asset('images/ikon-grafik-pelaku-usaha.png') }}" alt="Ikon Pelaku Usaha" class="w-16 h-16 object-contain">
                        </div>
                    </div>
                    <a href="{{ route('grafik.pelaku.usaha') }}" class="flex items-center justify-center gap-2 bg-slate-800 text-white rounded-b-md px-4 py-2 text-sm font-semibold">
                        Lihat Detail
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <div class="bg-indigo-200/60 rounded-md shadow-[0_6px_0_rgba(15,23,42,0.3)]">
                    <div class="p-4">
                        <p class="font-semibold text-slate-800">Harga Ikan</p>
                        <div class="mt-4 h-16 flex items-center justify-end text-slate-700">
                            <img src="{{ asset('images/ikon-grafik-harga-ikan.png') }}" alt="Ikon Harga Ikan" class="w-16 h-16 object-contain">
                        </div>
                    </div>
                    <a href="{{ route('grafik.harga.ikan.segar') }}" class="flex items-center justify-center gap-2 bg-slate-800 text-white rounded-b-md px-4 py-2 text-sm font-semibold">
                        Lihat Detail
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                    <div class="bg-indigo-200/60 rounded-md shadow-[0_6px_0_rgba(15,23,42,0.3)]">
                    <div class="p-4">
                        <p class="font-semibold text-slate-800">Produksi Ikan</p>
                        <div class="mt-4 h-16 flex items-center justify-end text-slate-700">
                            <img src="{{ asset('images/ikon-grafik-produksi-ikan.png') }}" alt="Ikon Produksi Ikan" class="w-16 h-16 object-contain">
                        </div>
                    </div>
                    <a href="{{ route('grafik.produksi.ikan') }}" class="flex items-center justify-center gap-2 bg-slate-800 text-white rounded-b-md px-4 py-2 text-sm font-semibold">
                        Lihat Detail
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif

            <!-- Ringkasan -->
            <h4 class="text-lg sm:text-xl font-extrabold text-slate-800 mb-3">Ringkasan Jumlah Pembudidaya, Pemasar dan Pengolah</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="bg-cyan-200/60 rounded-md shadow-[0_6px_0_rgba(15,23,42,0.3)]">
                    <div class="p-4">
                        <div class="text-slate-800 text-sm">{{ $pembudidayaCount }}</div>
                        <p class="font-semibold text-slate-800">Jumlah Pembudidaya</p>
                        <div class="mt-4 h-10 flex items-center justify-end text-slate-700">
                            <img src="{{ asset('images/ikon-pembudidaya.png') }}" alt="Ikon Pembudidaya" class="w-12 h-12 object-contain">
                        </div>
                    </div>
                    <a href="{{ route('pembudidaya.index') }}" class="flex items-center justify-center gap-2 bg-slate-800 text-white rounded-b-md px-4 py-2 text-sm font-semibold">
                        Lihat Detail
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <div class="bg-cyan-200/60 rounded-md shadow-[0_6px_0_rgba(15,23,42,0.3)]">
                    <div class="p-4">
                        <div class="text-slate-800 text-sm">{{ $pemasarCount }}</div>
                        <p class="font-semibold text-slate-800">Jumlah Pemasar</p>
                        <div class="mt-4 h-10 flex items-center justify-end text-slate-700">
                            <img src="{{ asset('images/ikon-pemasar.png') }}" alt="Ikon Pemasar" class="w-12 h-12 object-contain">
                        </div>
                    </div>
                    <a href="{{ route('pemasar.index') }}" class="flex items-center justify-center gap-2 bg-slate-800 text-white rounded-b-md px-4 py-2 text-sm font-semibold">
                        Lihat Detail
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <div class="bg-cyan-200/60 rounded-md shadow-[0_6px_0_rgba(15,23,42,0.3)]">
                    <div class="p-4">
                        <div class="text-slate-800 text-sm">{{ $pengolahCount }}</div>
                        <p class="font-semibold text-slate-800">Jumlah Pengolah</p>
                        <div class="mt-4 h-10 flex items-center justify-end text-slate-700">
                            <img src="{{ asset('images/ikon-pengolah.png') }}" alt="Ikon Pengolah" class="w-12 h-12 object-contain">
                        </div>
                    </div>
                    <a href="{{ route('pengolah.index') }}" class="flex items-center justify-center gap-2 bg-slate-800 text-white rounded-b-md px-4 py-2 text-sm font-semibold">
                        Lihat Detail
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
