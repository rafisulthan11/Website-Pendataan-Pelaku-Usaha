<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl sm:text-3xl text-slate-800 leading-tight">
            Rekapitulasi Pelaku Usaha
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header bar -->
                <div class="bg-blue-600 px-4 sm:px-6 py-4">
                    <h3 class="text-white text-2xl font-bold">Rekapitulasi Pelaku Usaha</h3>
                </div>

                <div class="p-4 sm:p-6">
                    <!-- Total Produksi Card -->
                    <div class="mb-6 bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-600 rounded-lg p-4 shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-600 rounded-full p-3">
                                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-600">Total Produksi Keseluruhan</h4>
                                    <p class="text-2xl font-bold text-blue-700">{{ number_format($totalProduksiKeseluruhan, 0, ',', '.') }} Kg</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Dari {{ $pelakuUsahaPaginated->total() }} Pelaku Usaha</p>
                                <p class="text-xs text-gray-500 mt-1">Pembudidaya & Pengolah</p>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <form method="GET" action="{{ route('laporan.rekapitulasi.pelaku.usaha') }}" class="mb-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                            <!-- Filter Kecamatan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                                <select name="kecamatan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Kecamatan</option>
                                    @foreach($kecamatans as $kec)
                                        <option value="{{ $kec->id_kecamatan }}" {{ request('kecamatan') == $kec->id_kecamatan ? 'selected' : '' }}>
                                            {{ $kec->nama_kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Tipe Pelaku -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Pelaku Usaha</label>
                                <select name="tipe_pelaku" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Tipe</option>
                                    @foreach($tipePelakuOptions as $tipe)
                                        <option value="{{ $tipe }}" {{ request('tipe_pelaku') == $tipe ? 'selected' : '' }}>
                                            {{ $tipe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Bulan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                                <select name="bulan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Bulan</option>
                                    <option value="Januari" {{ request('bulan') == 'Januari' ? 'selected' : '' }}>Januari</option>
                                    <option value="Februari" {{ request('bulan') == 'Februari' ? 'selected' : '' }}>Februari</option>
                                    <option value="Maret" {{ request('bulan') == 'Maret' ? 'selected' : '' }}>Maret</option>
                                    <option value="April" {{ request('bulan') == 'April' ? 'selected' : '' }}>April</option>
                                    <option value="Mei" {{ request('bulan') == 'Mei' ? 'selected' : '' }}>Mei</option>
                                    <option value="Juni" {{ request('bulan') == 'Juni' ? 'selected' : '' }}>Juni</option>
                                    <option value="Juli" {{ request('bulan') == 'Juli' ? 'selected' : '' }}>Juli</option>
                                    <option value="Agustus" {{ request('bulan') == 'Agustus' ? 'selected' : '' }}>Agustus</option>
                                    <option value="September" {{ request('bulan') == 'September' ? 'selected' : '' }}>September</option>
                                    <option value="Oktober" {{ request('bulan') == 'Oktober' ? 'selected' : '' }}>Oktober</option>
                                    <option value="November" {{ request('bulan') == 'November' ? 'selected' : '' }}>November</option>
                                    <option value="Desember" {{ request('bulan') == 'Desember' ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>

                            <!-- Filter Tahun -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                <select name="tahun" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Tahun</option>
                                    @for($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Button Filter & Reset -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">&nbsp;</label>
                                <div class="flex gap-2">
                                    <button type="submit" style="height: 38px;" class="flex-1 inline-flex items-center justify-center px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium border border-transparent">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/></svg>
                                        Filter
                                    </button>
                                    <a href="{{ route('laporan.rekapitulasi.pelaku.usaha') }}" style="height: 38px;" class="flex-1 inline-flex items-center justify-center px-4 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-sm font-medium border border-transparent">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Table controls -->
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <label class="text-sm">Show</label>
                            <select class="px-3 h-9 w-20 border rounded bg-white text-sm">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            <span class="text-sm">entries</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                            <label class="sr-only">Search</label>
                            <form method="GET" action="{{ route('laporan.rekapitulasi.pelaku.usaha') }}" class="flex items-center gap-2 border rounded px-2 py-1 w-full sm:w-auto">
                                <input type="hidden" name="kecamatan" value="{{ request('kecamatan') }}">
                                <input type="hidden" name="tipe_pelaku" value="{{ request('tipe_pelaku') }}">
                                <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                                <label class="text-sm">Search:</label>
                                <input type="text" name="search" value="{{ request('search') }}" class="border-0 focus:ring-0 px-2 h-8 text-sm w-full sm:w-48" />
                            </form>
                            <a href="{{ route('laporan.rekapitulasi.pelaku.usaha.excel', array_filter(['kecamatan' => request('kecamatan'), 'tipe_pelaku' => request('tipe_pelaku'), 'bulan' => request('bulan'), 'tahun' => request('tahun'), 'search' => request('search')])) }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-semibold w-full sm:w-auto">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Unduh Excel
                            </a>
                        </div>
                    </div>

                    <!-- Mobile cards -->
                    <div class="md:hidden space-y-3 mb-4">
                        @forelse($pelakuUsahaPaginated as $p)
                        <div class="rounded-lg border border-slate-200 p-4 bg-white shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $p->nama_lengkap }}</p>
                                    @if($p->nama_usaha)
                                        <p class="text-xs text-slate-500">{{ $p->nama_usaha }}</p>
                                    @endif
                                </div>
                                @if($p->tipe_pelaku === 'Pembudidaya')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Pembudidaya</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Pengolah</span>
                                @endif
                            </div>
                            <div class="mt-2 text-sm text-slate-700 space-y-1">
                                <p><span class="font-medium">Desa:</span> {{ optional($p->desa)->nama_desa ?? '-' }}</p>
                                <p><span class="font-medium">Kecamatan:</span> {{ optional($p->kecamatan)->nama_kecamatan ?? '-' }}</p>
                                <p><span class="font-medium">Jenis Kegiatan:</span> {{ $p->jenis_kegiatan_usaha ?? '-' }}</p>
                                <p><span class="font-medium">Total Produksi:</span> @if($p->total_produksi){{ number_format($p->total_produksi, 0, ',', '.') }} Kg@else-@endif</p>
                            </div>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @if($p->tipe_pelaku === 'Pembudidaya')
                                    <a href="{{ route('pembudidaya.show', ['pembudidaya' => $p->id, 'from_report' => 1]) }}" class="inline-flex items-center rounded bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700">Lihat Detail</a>
                                    <a href="{{ route('laporan.rekapitulasi.pembudidaya.pdf', $p->id) }}" class="inline-flex items-center rounded bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">Unduh PDF</a>
                                @else
                                    <a href="{{ route('pengolah.show', ['pengolah' => $p->id, 'from_report' => 1]) }}" class="inline-flex items-center rounded bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700">Lihat Detail</a>
                                    <a href="{{ route('laporan.rekapitulasi.pengolah.pdf', $p->id) }}" class="inline-flex items-center rounded bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">Unduh PDF</a>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="rounded-lg border border-slate-200 p-4 text-center text-slate-500">Tidak ada data untuk ditampilkan.</div>
                        @endforelse
                    </div>

                    <!-- Desktop table -->
                    <div class="hidden md:block overflow-x-auto">
                        <div class="rounded-md border border-slate-300 overflow-hidden">
                            <table class="min-w-full text-base">
                                <thead class="bg-slate-100 text-slate-800">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-[15px]">Tipe</th>
                                        <th class="px-4 py-3 text-left font-semibold text-[15px]">Nama Pelaku Usaha</th>
                                        <th class="px-4 py-3 text-left font-semibold text-[15px]">Desa</th>
                                        <th class="px-4 py-3 text-left font-semibold text-[15px]">Kecamatan</th>
                                        <th class="px-4 py-3 text-left font-semibold text-[15px]">Jenis Kegiatan</th>
                                        <th class="px-4 py-3 text-left font-semibold text-[15px]">Total Produksi</th>
                                        <th class="px-4 py-3 text-left font-semibold text-[15px]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pelakuUsahaPaginated as $p)
                                    <tr class="border-t border-slate-200">
                                        <td class="px-4 py-3 align-top">
                                            @if($p->tipe_pelaku === 'Pembudidaya')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Pembudidaya
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Pengolah
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 align-top text-slate-700">
                                            <div class="font-medium">{{ $p->nama_lengkap }}</div>
                                            @if($p->nama_usaha)
                                                <div class="text-sm text-gray-500">{{ $p->nama_usaha }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 align-top text-slate-700">{{ optional($p->desa)->nama_desa ?? '-' }}</td>
                                        <td class="px-4 py-3 align-top text-slate-700">{{ optional($p->kecamatan)->nama_kecamatan ?? '-' }}</td>
                                        <td class="px-4 py-3 align-top text-slate-700">{{ $p->jenis_kegiatan_usaha ?? '-' }}</td>
                                        <td class="px-4 py-3 align-top text-slate-700">
                                            @if($p->total_produksi)
                                                {{ number_format($p->total_produksi, 0, ',', '.') }} Kg
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 align-top">
                                            <div class="flex flex-wrap gap-2">
                                                @if($p->tipe_pelaku === 'Pembudidaya')
                                                    <a href="{{ route('pembudidaya.show', ['pembudidaya' => $p->id, 'from_report' => 1]) }}" class="inline-flex items-center rounded bg-green-600 px-3.5 py-1.5 text-sm font-semibold text-white hover:bg-green-700">
                                                        <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                        Lihat Detail
                                                    </a>
                                                    <a href="{{ route('laporan.rekapitulasi.pembudidaya.pdf', $p->id) }}" title="Unduh PDF" class="inline-flex items-center rounded bg-blue-600 px-3.5 py-1.5 text-sm font-semibold text-white hover:bg-blue-700">
                                                        <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                                        Unduh PDF
                                                    </a>
                                                @else
                                                    <a href="{{ route('pengolah.show', ['pengolah' => $p->id, 'from_report' => 1]) }}" class="inline-flex items-center rounded bg-green-600 px-3.5 py-1.5 text-sm font-semibold text-white hover:bg-green-700">
                                                        <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                        Lihat Detail
                                                    </a>
                                                    <a href="{{ route('laporan.rekapitulasi.pengolah.pdf', $p->id) }}" title="Unduh PDF" class="inline-flex items-center rounded bg-blue-600 px-3.5 py-1.5 text-sm font-semibold text-white hover:bg-blue-700">
                                                        <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                                        Unduh PDF
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-slate-500">Tidak ada data untuk ditampilkan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                Menampilkan {{ $pelakuUsahaPaginated->firstItem() ?: 0 }} - {{ $pelakuUsahaPaginated->lastItem() ?: 0 }} dari {{ $pelakuUsahaPaginated->total() }} entri
                            </div>
                            <div>
                                {{ $pelakuUsahaPaginated->links('components.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('error_export'))
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Dapat Mengunduh Excel',
                html: '<p class="text-gray-600">{{ session('error_export') }}</p>',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#dc2626',
                backdrop: true,
                allowOutsideClick: true,
                allowEscapeKey: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                },
                customClass: {
                    popup: 'rounded-2xl',
                    title: 'text-2xl font-bold text-gray-800',
                    confirmButton: 'px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200'
                }
            });
        });
    </script>
    @endif
</x-app-layout>
