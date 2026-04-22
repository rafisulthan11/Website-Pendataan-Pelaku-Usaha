<?php

require __DIR__.'/vendor/autoload.php';

$app =require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║          QUICK CHECK - NOTIFICATION SYSTEM STATUS             ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Check 1: Staff user exists
echo "[1] Checking Staff User...\n";
$staff = DB::table('users')
    ->join('roles', 'users.id_role', '=', 'roles.id_role')
    ->where('users.id_user', 2)
    ->select('users.*', 'roles.nama_role')
    ->first();

if ($staff && $staff->nama_role == 'staff') {
    echo "    ✅ Staff user found: {$staff->nama_lengkap} (ID: {$staff->id_user})\n";
} else {
    echo "    ❌ Staff user not found or wrong role!\n";
    exit;
}

// Check 2: Unread notifications
echo "\n[2] Checking Unread Notifications for Staff...\n";
$unreadCount = DB::table('notifications')
    ->where('user_id', 2)
    ->where('is_read', false)
    ->count();

if ($unreadCount > 0) {
    echo "    ✅ Staff has {$unreadCount} unread notification(s)\n";
    
    $latest = DB::table('notifications')
        ->where('user_id', 2)
        ->where('is_read', false)
        ->orderBy('created_at', 'desc')
        ->first();
    
    echo "    📧 Latest: \"{$latest->title}\"\n";
    echo "       Created: {$latest->created_at}\n";
} else {
    echo "    ⚠️  No unread notifications found\n";
    echo "       Run: php create_real_test.php\n";
    echo "       Then: php simulate_admin_verify.php\n";
}

// Check 3: Test data exists
echo "\n[3] Checking Test Data...\n";
$testData = DB::table('pembudidayas')
    ->where('nama_lengkap', 'STAFF TEST DATA')
    ->orderBy('id_pembudidaya', 'desc')
    ->first();

if ($testData) {
    echo "    ✅ Test data exists: ID {$testData->id_pembudidaya}\n";
    echo "       Status: {$testData->status}\n";
    echo "       Created by: {$testData->created_by}\n";
    echo "       Verified by: " . ($testData->verified_by ?? 'Not yet') . "\n";
} else {
    echo "    ℹ️  No test data found (optional)\n";
}

// Check 4: API Route accessible
echo "\n[4] Checking API Route...\n";
try {
    $route = route('notifications.unread');
    echo "    ✅ Route exists: {$route}\n";
} catch (\Exception $e) {
    echo "    ❌ Route not found: {$e->getMessage()}\n";
}

// Check 5: Notification Model Scope
echo "\n[5] Testing Notification Model Scope...\n";
try {
    $notifications = \App\Models\Notification::forUser(2)->unread()->get();
    echo "    ✅ Scope works: Found {$notifications->count()} notification(s)\n";
} catch (\Exception $e) {
    echo "    ❌ Scope failed: {$e->getMessage()}\n";
}

// Check 6: Controller verify methods
echo "\n[6] Checking Controller Implementation...\n";
$controllers = [
    'PembudidayaController',
    'PengolahController',
    'PemasarController',
    'HargaIkanSegarController'
];

foreach ($controllers as $controller) {
    $file = "app/Http/Controllers/{$controller}.php";
    $content = file_get_contents($file);
    
    if (strpos($content, '$createdBy = $') !== false && 
        strpos($content, '$updatedBy = $') !== false) {
        echo "    ✅ {$controller}: Fix implemented\n";
    } else {
        echo "    ❌ {$controller}: Fix NOT found\n";
    }
}

// Summary
echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║                          SUMMARY                               ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

if ($unreadCount > 0) {
    echo "✅ SYSTEM READY!\n\n";
    echo "   Staff user '{$staff->nama_lengkap}' has {$unreadCount} unread notification(s).\n";
    echo "   Login as this user in browser to see the notification.\n\n";
    echo "   📖 Read: PANDUAN_TEST_NOTIFIKASI.txt for step-by-step guide\n";
} else {
    echo "⚠️  NO UNREAD NOTIFICATIONS\n\n";
    echo "   To create test notification:\n";
    echo "   1. php create_real_test.php\n";
    echo "   2. php simulate_admin_verify.php\n";
    echo "   3. Login as staff in browser\n";
}

echo "\n";
