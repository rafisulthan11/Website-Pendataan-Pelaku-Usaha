<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pembudidaya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4">
                        <a href="{{ route('pembudidaya.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Tambah Pembudidaya
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="text-left">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Nama Lengkap</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Nama Usaha</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Jenis Budidaya</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Kecamatan</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse ($pembudidayas as $pembudidaya)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $pembudidaya->nama_lengkap }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $pembudidaya->nama_usaha }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $pembudidaya->jenis_budidaya }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $pembudidaya->kecamatan->nama_kecamatan ?? 'N/A' }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('pembudidaya.show', $pembudidaya->id_pembudidaya) }}" class="inline-block rounded bg-blue-600 px-2 py-2 text-xs font-medium text-white hover:bg-blue-700">
                                                Detail
                                            </a>
                                            <a href="{{ route('pembudidaya.edit', $pembudidaya->id_pembudidaya) }}" class="inline-block rounded bg-yellow-500 px-2 py-2 text-xs font-medium text-white hover:bg-yellow-600">
                                                Edit
                                            </a>
                                            <form action="{{ route('pembudidaya.destroy', $pembudidaya->id_pembudidaya) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block rounded bg-red-600 px-2 py-2 text-xs font-medium text-white hover:bg-red-700">
                                                    Delete
                                                </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="whitespace-nowrap px-4 py-2 text-center text-gray-500">
                                        Belum ada data pembudidaya.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Link Paginasi --}}
                    <div class="mt-4">
                        {{ $pembudidayas->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>