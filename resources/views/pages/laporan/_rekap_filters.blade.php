<form method="GET" class="mb-4 bg-gray-100 p-4 rounded border border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-12 items-center gap-3">
        <div class="md:col-span-3">
            <span class="font-semibold">{{ $title ?? 'Data' }}</span>
        </div>
        <div class="md:col-span-9 flex justify-end items-center space-x-3">
            @if($show_kecamatan ?? true)
            <select name="kecamatan" class="px-4 h-10 min-w-[140px] border rounded bg-white text-sm pr-8">
                <option value="">Semua Kecamatan</option>
                @foreach($kecamatans as $kec)
                    <option value="{{ $kec->id_kecamatan }}" {{ request('kecamatan') == $kec->id_kecamatan ? 'selected' : '' }}>{{ $kec->nama_kecamatan }}</option>
                @endforeach
            </select>
            @endif

            <select name="{{ $komoditas_name ?? 'komoditas' }}" class="px-4 h-10 min-w-[140px] border rounded bg-white text-sm pr-8">
                <option value="">{{ $komoditas_label ?? 'Semua Komoditas' }}</option>
                @foreach($komoditas as $kom)
                    <option value="{{ $kom }}" {{ request($komoditas_name ?? 'komoditas') == $kom ? 'selected' : '' }}>{{ $kom }}</option>
                @endforeach
            </select>

            <select name="kategori" class="px-4 h-10 min-w-[140px] border rounded bg-white text-sm pr-8">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>

            <select name="bulan" class="px-4 h-10 min-w-[140px] border rounded bg-white text-sm">
                <option value="">Semua Bulan</option>
                @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $num => $label)
                    <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded text-sm">Filter</button>
            <a href="{{ route('laporan.rekapitulasi.pembudidaya') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm">Reset</a>
        </div>
    </div>
</form>
