<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Data Pembudidaya: ') . $pembudidaya->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex items-center justify-end mb-6 gap-2">
                         <a href="{{ route('pembudidaya.index') }}" class="inline-block rounded bg-gray-400 px-4 py-2 text-xs font-medium text-white hover:bg-gray-500">
                            Kembali
                        </a>
                        <a href="{{ route('pembudidaya.edit', $pembudidaya->id_pembudidaya) }}" class="inline-block rounded bg-yellow-500 px-4 py-2 text-xs font-medium text-white hover:bg-yellow-600">
                            Edit
                        </a>
                    </div>

                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                        <h3 class="text-lg font-semibold border-b pb-2 mb-4">Profil Pemilik</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                            <div><strong class="font-medium text-gray-500">Nama Lengkap:</strong><p>{{ $pembudidaya->nama_lengkap }}</p></div>
                            <div><strong class="font-medium text-gray-500">NIK:</strong><p>{{ $pembudidaya->nik_pembudidaya }}</p></div>
                            <div><strong class="font-medium text-gray-500">Jenis Kelamin:</strong><p>{{ $pembudidaya->jenis_kelamin ?? '-' }}</p></div>
                            <div><strong class="font-medium text-gray-500">Tempat Lahir:</strong><p>{{ $pembudidaya->tempat_lahir ?? '-' }}</p></div>
                            <div><strong class="font-medium text-gray-500">Tanggal Lahir:</strong><p>{{ $pembudidaya->tanggal_lahir ? \Carbon\Carbon::parse($pembudidaya->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p></div>
                            <div><strong class="font-medium text-gray-500">Status Perkawinan:</strong><p>{{ $pembudidaya->status_perkawinan ?? '-' }}</p></div>
                            
                            {{-- 👇 PERUBAHAN ADA DI SINI 👇 --}}
                            {{-- Kita hapus col-span agar Alamat, Kecamatan, dan Desa lebarnya sama --}}
                            <div><strong class="font-medium text-gray-500">Alamat Lengkap:</strong><p>{{ $pembudidaya->alamat ?? '-' }}</p></div>
                            <div><strong class="font-medium text-gray-500">Kecamatan:</strong><p>{{ $pembudidaya->kecamatan->nama_kecamatan ?? '-' }}</p></div>
                            <div><strong class="font-medium text-gray-500">Desa/Kelurahan:</strong><p>{{ $pembudidaya->desa->nama_desa ?? '-' }}</p></div>

                            <div><strong class="font-medium text-gray-500">No. Telepon/HP:</strong><p>{{ $pembudidaya->kontak ?? '-' }}</p></div>
                            <div><strong class="font-medium text-gray-500">Email:</strong><p>{{ $pembudidaya->email ?? '-' }}</p></div>
                            <div><strong class="font-medium text-gray-500">No. NPWP:</strong><p>{{ $pembudidaya->no_npwp ?? '-' }}</p></div>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border">
                        <h3 class="text-lg font-semibold border-b pb-2 mb-4">Profil Usaha</h3>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div><strong class="font-medium text-gray-500">Nama Usaha:</strong><p>{{ $pembudidaya->nama_usaha ?? '-' }}</p></div>
                            <div><strong class="font-medium text-gray-500">Tahun Mulai Usaha:</strong><p>{{ $pembudidaya->tahun_mulai_usaha ?? '-' }}</p></div>
                            <div><strong class="font-medium text-gray-500">Jenis Kegiatan Usaha:</strong><p>{{ $pembudidaya->jenis_kegiatan_usaha }}</p></div>
                            <div><strong class="font-medium text-gray-500">Jenis Budidaya:</strong><p>{{ $pembudidaya->jenis_budidaya }}</p></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>