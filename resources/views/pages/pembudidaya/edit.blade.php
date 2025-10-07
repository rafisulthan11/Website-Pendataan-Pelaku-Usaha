<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data: ') . $pembudidaya->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pembudidaya.update', $pembudidaya->id_pembudidaya) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Profil Pemilik</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                {{-- Nama Lengkap --}}
                                <div>
                                    <x-input-label for="nama_lengkap" :value="__('Nama Lengkap (Sesuai KTP)*')" />
                                    <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $pembudidaya->nama_lengkap)" required />
                                    <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                                </div>
                                {{-- NIK --}}
                                <div>
                                    <x-input-label for="nik_pembudidaya" :value="__('NIK (Sesuai KTP)*')" />
                                    <x-text-input id="nik_pembudidaya" class="block mt-1 w-full" type="text" name="nik_pembudidaya" :value="old('nik_pembudidaya', $pembudidaya->nik_pembudidaya)" required />
                                    <x-input-error :messages="$errors->get('nik_pembudidaya')" class="mt-2" />
                                </div>
                                {{-- Jenis Kelamin --}}
                                <div>
                                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $pembudidaya->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $pembudidaya->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                                </div>
                                {{-- Tempat Lahir --}}
                                <div>
                                    <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                    <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $pembudidaya->tempat_lahir)" />
                                    <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                                </div>
                                {{-- Tanggal Lahir --}}
                                <div>
                                    <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $pembudidaya->tanggal_lahir)" />
                                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                                </div>
                                {{-- Status Perkawinan --}}
                                <div>
                                    <x-input-label for="status_perkawinan" :value="__('Status Perkawinan')" />
                                    <select name="status_perkawinan" id="status_perkawinan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">Pilih Status</option>
                                        <option value="Belum Kawin" {{ old('status_perkawinan', $pembudidaya->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                        <option value="Kawin" {{ old('status_perkawinan', $pembudidaya->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="Cerai Hidup" {{ old('status_perkawinan', $pembudidaya->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ old('status_perkawinan', $pembudidaya->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status_perkawinan')" class="mt-2" />
                                </div>
                                {{-- Alamat Lengkap --}}
                                <div class="md:col-span-2 lg:col-span-3">
                                    <x-input-label for="alamat" :value="__('Alamat Lengkap (Sesuai KTP)')" />
                                    <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('alamat', $pembudidaya->alamat) }}</textarea>
                                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                                </div>
                                {{-- Kecamatan & Desa --}}
                                <div>
                                    <x-input-label for="id_kecamatan" :value="__('Kecamatan*')" />
                                    <select name="id_kecamatan" id="id_kecamatan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">Pilih Kecamatan</option>
                                        @foreach ($kecamatans as $kecamatan)
                                            <option value="{{ $kecamatan->id_kecamatan }}" {{ old('id_kecamatan', $pembudidaya->id_kecamatan) == $kecamatan->id_kecamatan ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('id_kecamatan')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="id_desa" :value="__('Desa/Kelurahan*')" />
                                    <select name="id_desa" id="id_desa" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="">Pilih Desa</option>
                                        @foreach ($desas as $desa)
                                            <option value="{{ $desa->id_desa }}" {{ old('id_desa', $pembudidaya->id_desa) == $desa->id_desa ? 'selected' : '' }}>{{ $desa->nama_desa }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('id_desa')" class="mt-2" />
                                </div>
                                {{-- No Telepon --}}
                                <div>
                                    <x-input-label for="kontak" :value="__('No. Telepon / HP')" />
                                    <x-text-input id="kontak" class="block mt-1 w-full" type="text" name="kontak" :value="old('kontak', $pembudidaya->kontak)" />
                                    <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                                </div>
                                {{-- Email --}}
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $pembudidaya->email)" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                {{-- NPWP --}}
                                <div>
                                    <x-input-label for="no_npwp" :value="__('No. NPWP')" />
                                    <x-text-input id="no_npwp" class="block mt-1 w-full" type="text" name="no_npwp" :value="old('no_npwp', $pembudidaya->no_npwp)" />
                                    <x-input-error :messages="$errors->get('no_npwp')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Profil Usaha</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nama_usaha" :value="__('Nama Usaha')" />
                                    <x-text-input id="nama_usaha" class="block mt-1 w-full" type="text" name="nama_usaha" :value="old('nama_usaha', $pembudidaya->nama_usaha)" />
                                    <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                                </div>
                               <div>
                                    <x-input-label for="jenis_kegiatan_usaha" :value="__('Jenis Kegiatan Usaha*')" />
                                    <select name="jenis_kegiatan_usaha" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="Pembenihan" {{ old('jenis_kegiatan_usaha', $pembudidaya->jenis_kegiatan_usaha) == 'Pembenihan' ? 'selected' : '' }}>Pembenihan</option>
                                        <option value="Pembesaran" {{ old('jenis_kegiatan_usaha', $pembudidaya->jenis_kegiatan_usaha) == 'Pembesaran' ? 'selected' : '' }}>Pembesaran</option>
                                        <option value="Tambak" {{ old('jenis_kegiatan_usaha', $pembudidaya->jenis_kegiatan_usaha) == 'Tambak' ? 'selected' : '' }}>Tambak</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('jenis_kegiatan_usaha')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="jenis_budidaya" :value="__('Jenis Budidaya*')" />
                                    <select name="jenis_budidaya" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                        <option value="Kolam" {{ old('jenis_budidaya', $pembudidaya->jenis_budidaya) == 'Kolam' ? 'selected' : '' }}>Kolam</option>
                                        <option value="Mina Padi" {{ old('jenis_budidaya', $pembudidaya->jenis_budidaya) == 'Mina Padi' ? 'selected' : '' }}>Mina Padi</option>
                                        <option value="Keramba" {{ old('jenis_budidaya', $pembudidaya->jenis_budidaya) == 'Keramba' ? 'selected' : '' }}>Keramba</option>
                                        <option value="Tambak" {{ old('jenis_budidaya', $pembudidaya->jenis_budidaya) == 'Tambak' ? 'selected' : '' }}>Tambak</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('jenis_budidaya')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pembudidaya.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Update Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>