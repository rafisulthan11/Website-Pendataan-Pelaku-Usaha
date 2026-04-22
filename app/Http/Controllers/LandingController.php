<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;
use App\Models\Pengolah;
use App\Models\Pemasar;
use App\Models\HargaIkanSegar;

class LandingController extends Controller
{
    public function index()
    {
        // Get statistics from verified data only
        // For business actors, count unique NIK to avoid double counting
        $totalPembudidaya = Pembudidaya::where('status', 'verified')
            ->whereNotNull('nik_pembudidaya')
            ->where('nik_pembudidaya', '!=', '')
            ->distinct('nik_pembudidaya')
            ->count('nik_pembudidaya');

        $totalPengolah = Pengolah::where('status', 'verified')
            ->whereNotNull('nik_pengolah')
            ->where('nik_pengolah', '!=', '')
            ->distinct('nik_pengolah')
            ->count('nik_pengolah');

        $totalPemasar = Pemasar::where('status', 'verified')
            ->whereNotNull('nik_pemasar')
            ->where('nik_pemasar', '!=', '')
            ->distinct('nik_pemasar')
            ->count('nik_pemasar');

        // Harga ikan tidak memiliki NIK, jadi dihitung berdasarkan total data verified
        $totalHargaIkan = HargaIkanSegar::where('status', 'verified')->count();
        
        return view('welcome', compact(
            'totalPembudidaya',
            'totalPengolah',
            'totalPemasar',
            'totalHargaIkan'
        ));
    }
}
