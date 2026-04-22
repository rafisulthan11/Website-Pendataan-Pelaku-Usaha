<?php

namespace App\Http\Controllers;

use App\Models\Pembudidaya;
use App\Models\Pemasar;
use App\Models\Pengolah;

class DashboardController extends Controller
{
    public function index()
    {
        // Count only verified data and avoid double count for same NIK
        $pembudidayaCount = Pembudidaya::where('status', 'verified')
            ->whereNotNull('nik_pembudidaya')
            ->where('nik_pembudidaya', '!=', '')
            ->distinct('nik_pembudidaya')
            ->count('nik_pembudidaya');

        $pemasarCount = Pemasar::where('status', 'verified')
            ->whereNotNull('nik_pemasar')
            ->where('nik_pemasar', '!=', '')
            ->distinct('nik_pemasar')
            ->count('nik_pemasar');

        $pengolahCount = Pengolah::where('status', 'verified')
            ->whereNotNull('nik_pengolah')
            ->where('nik_pengolah', '!=', '')
            ->distinct('nik_pengolah')
            ->count('nik_pengolah');

        return view('dashboard', compact('pembudidayaCount', 'pemasarCount', 'pengolahCount'));
    }
}
