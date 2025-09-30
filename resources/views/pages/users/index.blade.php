    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Akun') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="mb-4">
                            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Tambah User Baru
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                <thead class="text-left">
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">No</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Nama Lengkap</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Email</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Role</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Status</th>
                                        <th class="px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($users as $user)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $user->nama_lengkap }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $user->email }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{-- Cek role untuk styling --}}
                                            @if($user->role->nama_role == 'admin')
                                                <span class="inline-block whitespace-nowrap rounded-[0.27rem] bg-red-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-red-700">
                                                    {{ $user->role->nama_role }}
                                                </span>
                                            @else
                                                <span class="inline-block whitespace-nowrap rounded-[0.27rem] bg-blue-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-blue-700">
                                                    {{ $user->role->nama_role }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $user->status }}</td>
                                        <td class="whitespace-nowrap px-4 py-2">
                                            <div class="flex items-center gap-2">
                                                
                                                <a href="{{ route('users.edit', $user->id_user) }}" class="inline-block rounded bg-yellow-500 px-2 py-2 text-xs font-medium text-white hover:bg-yellow-600">
                                                    Edit
                                                </a>

                                                <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
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
                                        <td colspan="6" class="whitespace-nowrap px-4 py-2 text-center text-gray-500">
                                            Tidak ada data user.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>