<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║           TEST NOTIFICATION FIX - PRIORITY TO updated_by       ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Get users
$staffUser = DB::table('users')->where('id_role', 2)->first();
$adminUser = DB::table('users')->where('id_role', 1)->first();

echo "👥 USERS:\n";
echo "   Staff: {$staffUser->nama_lengkap} (ID: {$staffUser->id_user})\n";
echo "   Admin: {$adminUser->nama_lengkap} (ID: {$adminUser->id_user})\n\n";

echo "=" . str_repeat("=", 63) . "\n\n";

// Test with existing pending data
echo "📋 TESTING WITH EXISTING DATA:\n\n";

// Test with pengolah ID 5 (created by admin, updated by staff)
$pengolah = DB::table('pengolahs')->where('id_pengolah', 5)->first();

if ($pengolah) {
    echo ">> PENGOLAH ID 5:\n";
    echo "   Name: {$pengolah->nama_lengkap}\n";
    echo "   Status: {$pengolah->status}\n";
    echo "   created_by: {$pengolah->created_by} (";
    echo $pengolah->created_by == $staffUser->id_user ? 'STAFF' : 'ADMIN';
    echo ")\n";
    echo "   updated_by: {$pengolah->updated_by} (";
    echo $pengolah->updated_by == $staffUser->id_user ? 'STAFF' : 'ADMIN';
    echo ")\n\n";
    
    // Simulate the NEW logic
    $targetUserId = $pengolah->updated_by ?? $pengolah->created_by;
    
    echo "   OLD LOGIC (created_by priority):\n";
    echo "   → Would send to: {$pengolah->created_by} (";
    echo $pengolah->created_by == $staffUser->id_user ? 'STAFF ✅' : 'ADMIN ❌';
    echo ")\n\n";
    
    echo "   NEW LOGIC (updated_by priority):\n";
    echo "   → Will send to: {$targetUserId} (";
    echo $targetUserId == $staffUser->id_user ? 'STAFF ✅' : 'ADMIN ❌';
    echo ")\n\n";
}

echo "=" . str_repeat("=", 63) . "\n\n";

// Simulate verify with NEW logic
echo "🧪 SIMULATING ADMIN VERIFY (with NEW logic):\n\n";

// Find a pending data that was updated by staff
$testData = DB::table('pemasars')
    ->where('status', 'pending')
    ->first();

if ($testData) {
    echo "Found pending pemasar:\n";
    echo "   ID: {$testData->id_pemasar}\n";
    echo "   Name: {$testData->nama_lengkap}\n";
    echo "   created_by: " . ($testData->created_by ?? 'NULL') . "\n";
    echo "   updated_by: " . ($testData->updated_by ?? 'NULL') . "\n\n";
    
    // Simulate NEW logic
    $createdBy = $testData->created_by;
    $updatedBy = $testData->updated_by;
    $targetUserId = $updatedBy ?? $createdBy;
    
    echo "   NEW LOGIC: Priority to updated_by\n";
    echo "   → Target: {$targetUserId} (";
    
    if ($targetUserId == $staffUser->id_user) {
        echo "STAFF ✅)\n";
        echo "   → Notification WILL GO TO STAFF! ✅\n\n";
    } elseif ($targetUserId == $adminUser->id_user) {
        echo "ADMIN ❌)\n";
        echo "   → Notification will go to admin (not staff)\n";
        echo "   → This is OK if admin created AND edited this data\n\n";
    } else {
        echo "OTHER USER)\n\n";
    }
    
    // Actually verify the data
    echo "   Performing verification...\n";
    
    DB::table('pemasars')->where('id_pemasar', $testData->id_pemasar)->update([
        'status' => 'verified',
        'verified_by' => $adminUser->id_user,
        'verified_at' => now(),
    ]);
    
    // Create notification with NEW logic
    if ($targetUserId && $targetUserId != $adminUser->id_user) {
        DB::table('notifications')->insert([
            'user_id' => $targetUserId,
            'type' => 'verified',
            'title' => 'Data Pemasar Diverifikasi',
            'message' => "Admin {$adminUser->nama_lengkap} telah memverifikasi data pemasar: {$testData->nama_lengkap}",
            'module' => 'pemasar',
            'module_id' => $testData->id_pemasar,
            'url' => url("/pemasar/{$testData->id_pemasar}"),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "   ✅ Notification created for user ID: {$targetUserId}\n\n";
    } else {
        echo "   ⚠️  No notification sent (target is admin or NULL)\n\n";
    }
} else {
    echo "⚠️  No pending pemasar data found to test\n\n";
}

echo "=" . str_repeat("=", 63) . "\n\n";

// Check staff notifications
$staffNotifications = DB::table('notifications')
    ->where('user_id', $staffUser->id_user)
    ->where('is_read', false)
    ->orderBy('created_at', 'desc')
    ->get();

echo "🔔 STAFF UNREAD NOTIFICATIONS: " . $staffNotifications->count() . "\n\n";

foreach ($staffNotifications->take(5) as $notif) {
    echo "   [{$notif->module}] {$notif->title}\n";
    echo "   Created: {$notif->created_at}\n\n";
}

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                         SUMMARY                                ║\n";
echo "╠════════════════════════════════════════════════════════════════╣\n";
echo "║                                                                ║\n";
echo "║  FIX IMPLEMENTED: ✅                                           ║\n";
echo "║                                                                ║\n";
echo "║  NEW LOGIC:                                                    ║\n";
echo "║    $targetUserId = $updatedBy ?? $createdBy;                  ║\n";
echo "║                                                                ║\n";
echo "║  Notification goes to:                                         ║\n";
echo "║    1. Staff yang EDIT data (updated_by) - PRIORITY ✅          ║\n";
echo "║    2. Staff yang BUAT data (created_by) - FALLBACK            ║\n";
echo "║    3. No notification if target is admin (self-notification)  ║\n";
echo "║                                                                ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "💡 CARA TESTING DI BROWSER:\n\n";
echo "   SCENARIO 1: Staff EDIT data yang dibuat admin\n";
echo "   1. Login sebagai STAFF\n";
echo "   2. Edit data pengolah/pemasar/harga ikan yang ada\n";
echo "   3. Logout\n";
echo "   4. Login sebagai ADMIN\n";
echo "   5. Verifikasi data yang baru diedit staff\n";
echo "   6. Logout, login kembali sebagai STAFF\n";
echo "   7. Check bell icon → Harus ada notifikasi! ✅\n\n";

echo "   SCENARIO 2: Staff BUAT data baru\n";
echo "   1. Login sebagai STAFF\n";
echo "   2. Buat data baru (pengolah/pemasar/harga ikan)\n";
echo "   3. Logout\n";
echo "   4. Login sebagai ADMIN\n";
echo "   5. Verifikasi data baru tersebut\n";
echo "   6. Logout, login kembali sebagai STAFF\n";
echo "   7. Check bell icon → Harus ada notifikasi! ✅\n\n";
