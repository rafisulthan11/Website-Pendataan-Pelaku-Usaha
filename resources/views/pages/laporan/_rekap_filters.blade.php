<form method="GET" class="mb-4 bg-gray-100 p-4 rounded border border-gray-200">
    <div class="flex flex-col lg:flex-row lg:items-center gap-3">
        <div class="lg:w-auto">
            <span class="font-semibold">{{ $title ?? 'Data' }}</span>
        </div>
        <div class="flex-1 flex flex-wrap items-center justify-end gap-2">
            @if($show_kecamatan ?? true)
            <select name="kecamatan" class="px-3 h-9 w-full sm:w-auto sm:min-w-[140px] border rounded bg-white text-sm pr-8">
                <option value="">Semua Kecamatan</option>
                @foreach($kecamatans as $kec)
                    <option value="{{ $kec->id_kecamatan }}" {{ request('kecamatan') == $kec->id_kecamatan ? 'selected' : '' }}>{{ $kec->nama_kecamatan }}</option>
                @endforeach
            </select>
            @endif

            @if($show_komoditas ?? true)
            <select name="{{ $komoditas_name ?? 'komoditas' }}" class="px-3 h-9 w-full sm:w-auto sm:min-w-[140px] border rounded bg-white text-sm pr-8">
                <option value="">{{ $komoditas_label ?? 'Semua Komoditas' }}</option>
                @foreach($komoditas as $kom)
                    <option value="{{ $kom }}" {{ request($komoditas_name ?? 'komoditas') == $kom ? 'selected' : '' }}>{{ $kom }}</option>
                @endforeach
            </select>
            @endif

            <select name="kategori" class="px-3 h-9 w-full sm:w-auto sm:min-w-[140px] border rounded bg-white text-sm pr-8">
                <option value="">{{ $kategori_label ?? 'Semua Kategori' }}</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>

            @if(isset($jenis_kegiatan_usaha_list))
            <select name="jenis_kegiatan_usaha" class="px-3 h-9 w-full sm:w-auto sm:min-w-[140px] border rounded bg-white text-sm pr-8">
                <option value="">Semua Jenis Kegiatan Usaha</option>
                @foreach($jenis_kegiatan_usaha_list as $jku)
                    <option value="{{ $jku }}" {{ request('jenis_kegiatan_usaha') == $jku ? 'selected' : '' }}>{{ $jku }}</option>
                @endforeach
            </select>
            @endif

            @if($show_bulan ?? true)
            <select name="bulan" class="px-3 h-9 w-full sm:w-auto sm:min-w-[140px] border rounded bg-white text-sm">
                <option value="">Semua Bulan</option>
                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                    <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                @endforeach
            </select>
            @endif

            @if($show_tahun ?? true)
            <select name="tahun" class="px-3 h-9 w-full sm:w-auto sm:min-w-[140px] border rounded bg-white text-sm">
                <option value="">Semua Tahun</option>
                @php
                    $currentYear = date('Y');
                    $years = range(2026, $currentYear + 5);
                @endphp
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            @endif

            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded text-sm whitespace-nowrap">Filter</button>
            <a href="{{ $reset_route ?? url()->current() }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm whitespace-nowrap">Reset</a>
        </div>
    </div>
</form>
