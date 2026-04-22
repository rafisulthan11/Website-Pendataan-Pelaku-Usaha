<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Creating Real Test Data ===\n\n";

// Create test data as staff (ID: 2)
$staffId = 2;

echo "Step 1: Creating data as STAFF (ID: {$staffId})...\n";

$pembudidayaId = DB::table('pembudidayas')->insertGetId([
    'tahun_pendataan' => 2026,
    'nama_lengkap' => 'STAFF TEST DATA',
    'nik_pembudidaya' => '8888' . rand(100000000000, 999999999999),
    'id_kecamatan' => 1,
    'id_desa' => 1,
    'jenis_kegiatan_usaha' => 'Test Staff',
    'jenis_budidaya' => 'Test',
    'status' => 'pending',
    'created_by' => $staffId,  // IMPORTANT: Created by staff
    'updated_by' => $staffId,
    'created_at' => now(),
    'updated_at' => now()
]);

echo "✓ Created pembudidaya ID: {$pembudidayaId}\n";
echo "  Status: pending\n";
echo "  Created by: {$staffId} (STAFF)\n\n";

echo "Step 2: Now ADMIN will verify this data...\n";
echo "  Please login as admin and verify pembudidaya ID: {$pembudidayaId}\n\n";

echo "Step 3: After admin verifies, run this command:\n";
echo "  php verify_notification_sent.php\n\n";

echo "Expected behavior:\n";
echo "  - Admin verifies the data\n";
echo "  - Notification SHOULD be sent to staff (ID: {$staffId})\n";
echo "  - Staff bell icon should show the notification\n";
echo "  - Admin bell icon should NOT show the verification notification\n";
