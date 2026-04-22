<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Creating Test Data for ALL Modules (as STAFF) ===\n\n";

$staffId = 2; // Staff "zai"

// 1. Create Pengolah
echo "1️⃣  Creating PENGOLAH...\n";
$pengolahId = DB::table('pengolahs')->insertGetId([
    'tahun_pendataan' => 2026,
    'nama_lengkap' => 'TEST PENGOLAH - Staff Data',
    'nik_pengolah' => '7777' . rand(100000000000, 999999999999),
    'id_kecamatan' => 1,  // Required
    'id_desa' => 1,  // Required
    'id_kecamatan_usaha' => 1,
    'id_desa_usaha' => 1,
    'jenis_kegiatan_usaha' => 'Test Pengolah',
    'status' => 'pending',
    'created_by' => $staffId,
    'updated_by' => $staffId,
    'created_at' => now(),
    'updated_at' => now()
]);
echo "   ✓ Created pengolah ID: {$pengolahId} (created_by: {$staffId})\n\n";

// 2. Create Pemasar
echo "2️⃣  Creating PEMASAR...\n";
$pemasarId = DB::table('pemasars')->insertGetId([
    'tahun_pendataan' => 2026,
    'nama_lengkap' => 'TEST PEMASAR - Staff Data',
    'nik_pemasar' => '6666' . rand(100000000000, 999999999999),
    'id_kecamatan' => 1,  // Required
    'id_desa' => 1,  // Required
    'id_kecamatan_usaha' => 1,
    'id_desa_usaha' => 1,
    'jenis_kegiatan_usaha' => 'Test Pemasar',
    'status' => 'pending',
    'created_by' => $staffId,
    'updated_by' => $staffId,
    'created_at' => now(),
    'updated_at' => now()
]);
echo "   ✓ Created pemasar ID: {$pemasarId} (created_by: {$staffId})\n\n";

// 3. Create Harga Ikan Segar
echo "3️⃣  Creating HARGA IKAN SEGAR...\n";
$hargaIkanId = DB::table('harga_ikan_segars')->insertGetId([
    'tahun_pendataan' => 2026,
    'tanggal_input' => now()->toDateString(),
    'id_kecamatan' => 1,  // Required
    'id_desa' => 1,  // Required
    'jenis_ikan' => 'Ikan Test',  // Required
    'satuan' => 'kg',  // Required
    'nama_pasar' => 'Pasar Test',
    'nama_pedagang' => 'TEST PEDAGANG - Staff Data',
    'ukuran' => 'Sedang',
    'harga_produsen' => 45000,
    'harga_konsumen' => 50000,
    'status' => 'pending',
    'created_by' => $staffId,
    'updated_by' => $staffId,
    'created_at' => now(),
    'updated_at' => now()
]);
echo "   ✓ Created harga_ikan_segar ID: {$hargaIkanId} (created_by: {$staffId})\n\n";

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                   TEST DATA CREATED                            ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "📋 Summary:\n";
echo "   Pengolah ID: {$pengolahId}\n";
echo "   Pemasar ID: {$pemasarId}\n";
echo "   Harga Ikan ID: {$hargaIkanId}\n";
echo "   All created by: Staff (ID: {$staffId})\n";
echo "   Status: PENDING\n\n";

echo "📝 Testing Steps:\n\n";

echo "1️⃣  Test PENGOLAH:\n";
echo "   - Login as ADMIN\n";
echo "   - Go to 'Data Pengolah'\n";
echo "   - Find: 'TEST PENGOLAH - Staff Data' (ID: {$pengolahId})\n";
echo "   - Click 'Verifikasi'\n";
echo "   - Logout\n";
echo "   - Login as STAFF (zai)\n";
echo "   - Click bell icon → Should see notification ✅\n\n";

echo "2️⃣  Test PEMASAR:\n";
echo "   - Login as ADMIN\n";
echo "   - Go to 'Data Pemasar'\n";
echo "   - Find: 'TEST PEMASAR - Staff Data' (ID: {$pemasarId})\n";
echo "   - Click 'Verifikasi'\n";
echo "   - Logout\n";
echo "   - Login as STAFF (zai)\n";
echo "   - Click bell icon → Should see notification ✅\n\n";

echo "3️⃣  Test HARGA IKAN:\n";
echo "   - Login as ADMIN\n";
echo "   - Go to 'Data Harga Ikan Segar'\n";
echo "   - Find: 'TEST PEDAGANG - Staff Data' (ID: {$hargaIkanId})\n";
echo "   - Click 'Verifikasi'\n";
echo "   - Logout\n";
echo "   - Login as STAFF (zai)\n";
echo "   - Click bell icon → Should see notification ✅\n\n";

echo "💡 IMPORTANT:\n";
echo "   Data LAMA yang created_by = admin tidak akan kirim notifikasi ke staff.\n";
echo "   Data BARU yang created_by = staff akan kirim notifikasi ke staff.\n";
echo "   Ini adalah behavior yang BENAR!\n\n";

echo "Run this to verify notifications after admin verifies:\n";
echo "   php verify_all_notifications.php\n";
