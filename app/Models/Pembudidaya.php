<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembudidaya extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pembudidaya';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tahun_pendataan',
        'status',
        'verified_by',
        'verified_at',
        'catatan_perbaikan',
        'created_by',
        'updated_by',
        'nik_pembudidaya',
        'nama_lengkap',
        'jenis_kelamin',     
        'tempat_lahir',     
        'tanggal_lahir',
        'pendidikan_terakhir',
        'no_npwp',
        'email',
        'status_perkawinan',
        'jumlah_tanggungan',
        'alamat',
        'id_kecamatan',
        'id_desa',
        'jenis_kegiatan_usaha',
        'jenis_budidaya',
        'nama_usaha',
        'nama_kelompok',
        'npwp_usaha',
        'alamat_usaha',
        'kecamatan_usaha',
        'desa_usaha',
        'alamat_lengkap_usaha',
        'telp_usaha',
        'email_usaha',
        'skala_usaha',
        'status_usaha',
        'tahun_mulai_usaha',
        'kontak',
        'latitude',
        'longitude',
        'latitude_usaha',
        'longitude_usaha',
        'foto_ktp',
        'foto_sertifikat',
        'foto_cpib_cbib',
        'foto_unit_usaha',
        'foto_kusuka',
        'foto_nib',
    ];

    // Definisikan relasi ke Kecamatan dan Desa
    public function kecamatan()
    {
        return $this->belongsTo(MasterKecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function desa()
    {
        return $this->belongsTo(MasterDesa::class, 'id_desa', 'id_desa');
    }

    public function kecamatanUsaha()
    {
        return $this->belongsTo(MasterKecamatan::class, 'kecamatan_usaha', 'id_kecamatan');
    }

    public function desaUsaha()
    {
        return $this->belongsTo(MasterDesa::class, 'desa_usaha', 'id_desa');
    }

    public function investasi()
    {
        return $this->hasOne(PembudidayaInvestasi::class, 'id_pembudidaya', 'id_pembudidaya');
    }

    public function izin()
    {
        return $this->hasOne(PembudidayaIzin::class, 'id_pembudidaya', 'id_pembudidaya');
    }

    public function produksi()
    {
        return $this->hasMany(PembudidayaProduksi::class, 'id_pembudidaya', 'id_pembudidaya');
    }
    
    // Untuk backward compatibility
    public function produksiFirst()
    {
        return $this->hasOne(PembudidayaProduksi::class, 'id_pembudidaya', 'id_pembudidaya');
    }

    public function kolam()
    {
        return $this->hasMany(PembudidayaKolam::class, 'id_pembudidaya', 'id_pembudidaya');
    }

    public function ikan()
    {
        return $this->hasMany(PembudidayaIkan::class, 'id_pembudidaya', 'id_pembudidaya');
    }

    public function tenagaKerja()
    {
        return $this->hasOne(PembudidayaTenagaKerja::class, 'id_pembudidaya', 'id_pembudidaya');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id_user');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id_user');
    }
}