<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl sm:text-3xl text-slate-800 leading-tight">
            Rekapitulasi Pemasar
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header bar -->
                <div class="bg-blue-600 px-6 py-4">
                    <h3 class="text-white text-2xl font-bold">Rekapitulasi Pemasar</h3>
                </div>

                <div class="p-6">
                    @include('pages.laporan._rekap_filters', ['kecamatans' => $kecamatans, 'komoditas' => $komoditas, 'kategoris' => $kategoris, 'title' => 'Data Pemasar'])

                    <!-- Table controls -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <label class="text-sm">Show</label>
                            <select class="px-3 h-9 w-20 border rounded bg-white text-sm">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            <span class="text-sm">entries</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="sr-only">Search</label>
                            <div class="flex items-center gap-2 border rounded px-2 py-1">
                                <label class="text-sm">Search:</label>
                                <input type="text" class="border-0 focus:ring-0 px-2 h-8 text-sm w-48" />
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-auto">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-white border-t border-b">
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-r">Nama</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-r">Nama Kelompok</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-r">Desa</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-r">Kecamatan</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-r">Komoditas</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse($pemasars as $p)
                                <tr class="border-b">
                                    <td class="px-6 py-4 align-top text-sm">{{ $p->nama_lengkap }}</td>
                                    <td class="px-6 py-4 align-top text-sm">{{ $p->nama_usaha ?? '-' }}</td>
                                    <td class="px-6 py-4 align-top text-sm">{{ optional($p->desa)->nama_desa ?? '-' }}</td>
                                    <td class="px-6 py-4 align-top text-sm">{{ optional($p->kecamatan)->nama_kecamatan ?? '-' }}</td>
                                    <td class="px-6 py-4 align-top text-sm">{{ $p->jenis_kegiatan_usaha ?? '-' }}</td>
                                    <td class="px-6 py-4 align-top text-center">
                                        <a href="#" class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-full text-sm font-semibold">Lihat Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-6 text-center text-sm text-gray-500">Tidak ada data untuk ditampilkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                Menampilkan {{ $pemasars->firstItem() ?: 0 }} - {{ $pemasars->lastItem() ?: 0 }} dari {{ $pemasars->total() }} entri
                            </div>
                            <div>
                                {{ $pemasars->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
