<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapitulasiPelakuUsahaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $pelakuUsaha;

    public function __construct($pelakuUsaha)
    {
        $this->pelakuUsaha = $pelakuUsaha;
    }

    public function collection()
    {
        return $this->pelakuUsaha;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tipe Pelaku',
            'NIK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Desa',
            'Kecamatan',
            'No. Telepon',
            'Email',
            'No. NPWP Pribadi',
            'Nama Usaha',
            'Nama Kelompok',
            'Jenis Kegiatan Usaha',
            'Jenis Pengolahan/Budidaya',
            'Skala Usaha',
            'Status Usaha',
            'Tahun Mulai Usaha',
            'Kecamatan Usaha',
            'Desa Usaha',
            'Alamat Usaha',
            'No. Telp Usaha',
            'Email Usaha',
            'NPWP Usaha',
            'Komoditas',
            'Latitude',
            'Longitude',
            'Detail Produksi',
            'Total Produksi (Kg)',
        ];
    }

    public function map($pelaku): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $pelaku->tipe_pelaku,
            $pelaku->tipe_pelaku === 'Pembudidaya' ? ($pelaku->nik_pembudidaya ?? '-') : ($pelaku->nik_pengolah ?? '-'),
            $pelaku->nama_lengkap ?? '-',
            $pelaku->jenis_kelamin ?? '-',
            $pelaku->tempat_lahir ?? '-',
            $pelaku->tanggal_lahir ?? '-',
            $pelaku->alamat ?? '-',
            optional($pelaku->desa)->nama_desa ?? '-',
            optional($pelaku->kecamatan)->nama_kecamatan ?? '-',
            $pelaku->kontak ?? '-',
            $pelaku->email ?? '-',
            $pelaku->no_npwp ?? '-',
            $pelaku->nama_usaha ?? '-',
            $pelaku->nama_kelompok ?? '-',
            $pelaku->jenis_kegiatan_usaha ?? '-',
            $pelaku->tipe_pelaku === 'Pembudidaya' ? ($pelaku->jenis_budidaya ?? '-') : ($pelaku->jenis_pengolahan ?? '-'),
            $pelaku->skala_usaha ?? '-',
            $pelaku->status_usaha ?? '-',
            $pelaku->tahun_mulai_usaha ?? '-',
            optional($pelaku->kecamatanUsaha)->nama_kecamatan ?? '-',
            optional($pelaku->desaUsaha)->nama_desa ?? '-',
            $pelaku->alamat_usaha ?? '-',
            $pelaku->telp_usaha ?? '-',
            $pelaku->email_usaha ?? '-',
            $pelaku->npwp_usaha ?? '-',
            $pelaku->komoditas ?? '-',
            $pelaku->latitude ?? '-',
            $pelaku->longitude ?? '-',
            $this->formatDetailProduksi($pelaku),
            $pelaku->total_produksi ? number_format($pelaku->total_produksi, 2, ',', '.') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2563EB']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }

    private function formatDetailProduksi($pelaku)
    {
        if (!isset($pelaku->detail_produksi) || $pelaku->detail_produksi->isEmpty()) {
            return '-';
        }

        $details = [];
        $bulanNama = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agt',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        foreach ($pelaku->detail_produksi as $produksi) {
            if ($pelaku->tipe_pelaku === 'Pembudidaya') {
                // Pastikan data memiliki field yang diperlukan
                if (!isset($produksi->bulan) || !isset($produksi->tahun) || !isset($produksi->total_produksi)) {
                    continue;
                }
                $bulan = $bulanNama[$produksi->bulan] ?? $produksi->bulan;
                $tahun = $produksi->tahun;
                $qty = number_format($produksi->total_produksi, 2, ',', '.');
                $details[] = "{$bulan} {$tahun}: {$qty} kg";
            } else { // Pengolah
                // Pastikan data memiliki field yang diperlukan
                if (!isset($produksi['bulan']) || !isset($produksi['tahun']) || !isset($produksi['jumlah_produk_qty'])) {
                    continue;
                }
                $bulan = $bulanNama[$produksi['bulan']] ?? $produksi['bulan'];
                $tahun = $produksi['tahun'];
                $qty = number_format($produksi['jumlah_produk_qty'], 2, ',', '.');
                $details[] = "{$bulan} {$tahun}: {$qty} kg";
            }
        }

        return implode('; ', $details);
    }
}
