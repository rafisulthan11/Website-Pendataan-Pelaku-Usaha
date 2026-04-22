<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Creating Test Data as Staff ===\n\n";

// Get staff user (ID: 2 - zai)
$staffId = 2;
$staff = DB::table('users')->where('id_user', $staffId)->first();

echo "Creating data as: {$staff->nama_lengkap} (ID:{$staff->id_user})\n\n";

// Create test pembudidaya
$pembudidayaId = DB::table('pembudidayas')->insertGetId([
    'tahun_pendataan' => 2026,
    'nama_lengkap' => 'TEST DATA - For Notification Testing',
    'nik_pembudidaya' => '9999' . rand(100000000000, 999999999999),
    'id_kecamatan' => 1,
    'id_desa' => 1,
    'jenis_kegiatan_usaha' => 'Test',
    'jenis_budidaya' => 'Test',
    'status' => 'pending',
    'created_by' => $staffId,  // Created by staff ID 2
    'updated_by' => $staffId,
    'created_at' => now(),
    'updated_at' => now()
]);

echo "✓ Created pembudidaya ID: {$pembudidayaId}\n";
echo "  Status: pending\n";
echo "  Created by: {$staffId} (staff)\n\n";

echo "=== Verification Test ===\n";
echo "Now you should:\n";
echo "1. Login as admin (Kepala Bidang)\n";
echo "2. Go to pembudidaya list\n";
echo "3. Click 'Verifikasi' on the test data (ID: {$pembudidayaId})\n";
echo "4. Check bell icon - notification should NOT appear for admin\n";
echo "5. Logout and login as staff (zai)\n";
echo "6. Check bell icon - notification SHOULD appear for staff\n\n";

echo "To verify in database, run:\n";
echo "php check_notification_result.php\n";
