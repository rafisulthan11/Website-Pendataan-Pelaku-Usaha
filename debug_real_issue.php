<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║         DEBUG: CHECKING REAL ISSUE WITH NOTIFICATIONS          ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Get users
$staffUser = DB::table('users')->where('id_role', 2)->first();
$adminUser = DB::table('users')->where('id_role', 1)->first();

if (!$staffUser || !$adminUser) {
    echo "❌ ERROR: Cannot find staff or admin user!\n";
    exit(1);
}

echo "👥 USERS IN SYSTEM:\n";
echo "   Staff: {$staffUser->nama_lengkap} (ID: {$staffUser->id_user})\n";
echo "   Admin: {$adminUser->nama_lengkap} (ID: {$adminUser->id_user})\n\n";

echo "=" . str_repeat("=", 63) . "\n\n";

// Check all data in each table
$modules = [
    'pembudidaya' => ['table' => 'pembudidayas', 'id' => 'id_pembudidaya', 'name' => 'nik_pembudidaya'],
    'pengolah' => ['table' => 'pengolahs', 'id' => 'id_pengolah', 'name' => 'nama_lengkap'],
    'pemasar' => ['table' => 'pemasars', 'id' => 'id_pemasar', 'name' => 'nama_lengkap'],
    'harga_ikan' => ['table' => 'harga_ikan_segars', 'id' => 'id_harga', 'name' => 'nama_pedagang']
];

echo "📊 CURRENT DATA IN DATABASE:\n\n";

foreach ($modules as $moduleName => $config) {
    echo ">> {$moduleName} ({$config['table']}):\n";
    
    $data = DB::table($config['table'])
        ->orderBy($config['id'], 'desc')
        ->limit(5)
        ->get();
    
    if ($data->isEmpty()) {
        echo "   ⚠️  No data found\n\n";
        continue;
    }
    
    foreach ($data as $row) {
        $id = $row->{$config['id']};
        $name = $row->{$config['name']} ?? 'N/A';
        $status = $row->status ?? 'N/A';
        $createdBy = $row->created_by ?? 'NULL';
        $updatedBy = $row->updated_by ?? 'NULL';
        
        $createdByName = $createdBy ? ($createdBy == $staffUser->id_user ? 'STAFF' : 'ADMIN') : 'NULL';
        
        echo "   ID {$id}: {$name}\n";
        echo "      Status: {$status} | created_by: {$createdBy} ({$createdByName}) | updated_by: {$updatedBy}\n";
    }
    echo "\n";
}

echo "=" . str_repeat("=", 63) . "\n\n";

// Check notifications
echo "🔔 CURRENT NOTIFICATIONS:\n\n";

$staffNotifications = DB::table('notifications')
    ->where('user_id', $staffUser->id_user)
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

echo "Staff ({$staffUser->nama_lengkap}) - Total: " . $staffNotifications->count() . " notifications\n";
foreach ($staffNotifications as $notif) {
    $readStatus = $notif->is_read ? '✓ READ' : '✗ UNREAD';
    echo "   [{$readStatus}] [{$notif->module}] {$notif->title}\n";
    echo "      Created: {$notif->created_at}\n";
}
echo "\n";

$adminNotifications = DB::table('notifications')
    ->where('user_id', $adminUser->id_user)
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

echo "Admin ({$adminUser->nama_lengkap}) - Total: " . $adminNotifications->count() . " notifications\n";
foreach ($adminNotifications as $notif) {
    $readStatus = $notif->is_read ? '✓ READ' : '✗ UNREAD';
    echo "   [{$readStatus}] [{$notif->module}] {$notif->title}\n";
    echo "      Created: {$notif->created_at}\n";
}

echo "\n" . str_repeat("=", 64) . "\n\n";

// Check which data is PENDING and ready for verification
echo "⏳ PENDING DATA (Ready for Admin Verification):\n\n";

foreach ($modules as $moduleName => $config) {
    $pending = DB::table($config['table'])
        ->where('status', 'pending')
        ->get();
    
    if ($pending->isEmpty()) {
        echo ">> {$moduleName}: No pending data\n";
        continue;
    }
    
    echo ">> {$moduleName}: {$pending->count()} pending item(s)\n";
    foreach ($pending as $row) {
        $id = $row->{$config['id']};
        $name = $row->{$config['name']} ?? 'N/A';
        $createdBy = $row->created_by ?? 'NULL';
        $createdByName = $createdBy ? ($createdBy == $staffUser->id_user ? 'STAFF ✅' : 'ADMIN ❌') : 'NULL ❌';
        
        echo "   ID {$id}: {$name} (created_by: {$createdBy} = {$createdByName})\n";
    }
}

echo "\n" . str_repeat("=", 64) . "\n\n";

// Analysis
echo "💡 ANALYSIS:\n\n";

$staffPendingCount = 0;
$adminPendingCount = 0;

foreach ($modules as $moduleName => $config) {
    $staffCount = DB::table($config['table'])
        ->where('status', 'pending')
        ->where('created_by', $staffUser->id_user)
        ->count();
    
    $adminCount = DB::table($config['table'])
        ->where('status', 'pending')
        ->where('created_by', $adminUser->id_user)
        ->count();
    
    $staffPendingCount += $staffCount;
    $adminPendingCount += $adminCount;
}

echo "1. Total PENDING data created by STAFF: {$staffPendingCount}\n";
echo "   → When admin verifies, notification SHOULD go to STAFF ✅\n\n";

echo "2. Total PENDING data created by ADMIN: {$adminPendingCount}\n";
echo "   → When admin verifies, notification WILL go to ADMIN ❌\n\n";

if ($staffPendingCount === 0) {
    echo "⚠️  WARNING: No pending data created by STAFF!\n";
    echo "   This means if admin verifies any data, notification will NOT go to staff.\n";
    echo "   Solution: Staff must CREATE NEW data, then admin verifies it.\n\n";
}

echo "3. Testing Steps:\n";
echo "   a. Login as STAFF\n";
echo "   b. Create NEW data (pengolah/pemasar/harga ikan)\n";
echo "   c. Logout\n";
echo "   d. Login as ADMIN\n";
echo "   e. Go to data list and verify the NEW data\n";
echo "   f. Logout\n";
echo "   g. Login as STAFF\n";
echo "   h. Check bell icon → Should have notification! ✅\n\n";

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                        IMPORTANT NOTE                          ║\n";
echo "╠════════════════════════════════════════════════════════════════╣\n";
echo "║ Notification system sends to whoever CREATED the data.         ║\n";
echo "║ If admin verifies data that admin created → notif to admin    ║\n";
echo "║ If admin verifies data that staff created → notif to staff    ║\n";
echo "║ This is CORRECT behavior!                                      ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";
