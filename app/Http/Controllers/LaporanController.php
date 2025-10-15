<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;
use App\Models\MasterKecamatan;
use Illuminate\Support\Facades\View;

class LaporanController extends Controller
{
    /**
     * Show rekapitulasi pembudidaya with filters and pagination.
     */
    public function rekapitulasiPembudidaya(Request $request)
    {
        $query = Pembudidaya::with(['kecamatan','desa']);

        // filters
        if ($request->filled('kecamatan')) {
            $query->where('id_kecamatan', $request->kecamatan);
        }

        if ($request->filled('komoditas')) {
            $query->where('jenis_kegiatan_usaha', 'like', '%'.$request->komoditas.'%');
        }

        if ($request->filled('kategori')) {
            $query->where('jenis_budidaya', $request->kategori);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%'.$search.'%')
                  ->orWhere('nama_usaha', 'like', '%'.$search.'%')
                  ->orWhere('jenis_kegiatan_usaha', 'like', '%'.$search.'%');
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $pembudidayas = $query->orderBy('nama_lengkap')->paginate($perPage)->withQueryString();

        $kecamatans = MasterKecamatan::orderBy('nama_kecamatan')->get();

        // collect komoditas distinct values for filter
        $komoditas = Pembudidaya::select('jenis_kegiatan_usaha')
            ->whereNotNull('jenis_kegiatan_usaha')
            ->groupBy('jenis_kegiatan_usaha')
            ->orderBy('jenis_kegiatan_usaha')
            ->pluck('jenis_kegiatan_usaha');

        // collect kategori (jenis_budidaya) distinct values for filter
        $kategoris = Pembudidaya::select('jenis_budidaya')
            ->whereNotNull('jenis_budidaya')
            ->groupBy('jenis_budidaya')
            ->orderBy('jenis_budidaya')
            ->pluck('jenis_budidaya');

        return view('pages.laporan.rekapitulasi-pembudidaya', compact('pembudidayas','kecamatans','komoditas','kategoris'));
    }

    /**
     * Rekapitulasi Pengolah - visual parity with pembudidaya page.
     */
    public function rekapitulasiPengolah(Request $request)
    {
        // For now return an empty paginator to keep the UI identical and avoid model dependency
        $query = Pembudidaya::with(['kecamatan','desa'])->whereRaw('0 = 1');
        $perPage = (int) $request->input('per_page', 10);
        $pengolahs = $query->orderBy('nama_lengkap')->paginate($perPage)->withQueryString();

        $kecamatans = MasterKecamatan::orderBy('nama_kecamatan')->get();
        $komoditas = Pembudidaya::select('jenis_kegiatan_usaha')->whereNotNull('jenis_kegiatan_usaha')->groupBy('jenis_kegiatan_usaha')->orderBy('jenis_kegiatan_usaha')->pluck('jenis_kegiatan_usaha');
        $kategoris = Pembudidaya::select('jenis_budidaya')->whereNotNull('jenis_budidaya')->groupBy('jenis_budidaya')->orderBy('jenis_budidaya')->pluck('jenis_budidaya');

        return view('pages.laporan.rekapitulasi-pengolah', compact('pengolahs','kecamatans','komoditas','kategoris'));
    }

    /**
     * Rekapitulasi Pemasar - visual parity with pembudidaya page.
     */
    public function rekapitulasiPemasar(Request $request)
    {
        $query = Pembudidaya::with(['kecamatan','desa'])->whereRaw('0 = 1');
        $perPage = (int) $request->input('per_page', 10);
        $pemasars = $query->orderBy('nama_lengkap')->paginate($perPage)->withQueryString();

        $kecamatans = MasterKecamatan::orderBy('nama_kecamatan')->get();
        $komoditas = Pembudidaya::select('jenis_kegiatan_usaha')->whereNotNull('jenis_kegiatan_usaha')->groupBy('jenis_kegiatan_usaha')->orderBy('jenis_kegiatan_usaha')->pluck('jenis_kegiatan_usaha');
        $kategoris = Pembudidaya::select('jenis_budidaya')->whereNotNull('jenis_budidaya')->groupBy('jenis_budidaya')->orderBy('jenis_budidaya')->pluck('jenis_budidaya');

        return view('pages.laporan.rekapitulasi-pemasar', compact('pemasars','kecamatans','komoditas','kategoris'));
    }

    /**
     * Rekap Harga Ikan Segar - visual copy of other rekap pages.
     */
    public function rekapHargaIkanSegar(Request $request)
    {
        $query = Pembudidaya::with(['kecamatan','desa'])->whereRaw('0 = 1');
        $perPage = (int) $request->input('per_page', 10);
        $items = $query->orderBy('nama_lengkap')->paginate($perPage)->withQueryString();

        $kecamatans = MasterKecamatan::orderBy('nama_kecamatan')->get();
        $komoditas = Pembudidaya::select('jenis_kegiatan_usaha')->whereNotNull('jenis_kegiatan_usaha')->groupBy('jenis_kegiatan_usaha')->orderBy('jenis_kegiatan_usaha')->pluck('jenis_kegiatan_usaha');
        $kategoris = Pembudidaya::select('jenis_budidaya')->whereNotNull('jenis_budidaya')->groupBy('jenis_budidaya')->orderBy('jenis_budidaya')->pluck('jenis_budidaya');

        return view('pages.laporan.rekap_harga_ikan_segar', compact('items','kecamatans','komoditas','kategoris'));
    }
}
