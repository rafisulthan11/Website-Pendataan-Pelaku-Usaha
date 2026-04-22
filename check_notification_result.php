<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Checking Notification Result ===\n\n";

// Get the test pembudidaya
$testId = 17;
$pembudidaya = DB::table('pembudidayas')->where('id_pembudidaya', $testId)->first();

if (!$pembudidaya) {
    echo "Test data not found!\n";
    exit;
}

echo "Test Data (Pembudidaya ID: {$testId}):\n";
echo "  Name: {$pembudidaya->nama_lengkap}\n";
echo "  Status: {$pembudidaya->status}\n";
echo "  Created by: {$pembudidaya->created_by}\n";
echo "  Verified by: " . ($pembudidaya->verified_by ?? 'NULL') . "\n\n";

// Check latest notifications
echo "=== Latest Notifications ===\n";
$notifications = DB::table('notifications')
    ->join('users', 'notifications.user_id', '=', 'users.id_user')
    ->join('roles', 'users.id_role', '=', 'roles.id_role')
    ->select(
        'notifications.id',
        'notifications.user_id',
        'users.nama_lengkap',
        'roles.nama_role',
        'notifications.type',
        'notifications.title',
        'notifications.module_id',
        'notifications.created_at'
    )
    ->orderBy('notifications.id', 'desc')
    ->take(5)
    ->get();

foreach($notifications as $n) {
    $indicator = '';
    if ($n->module_id == $testId && $n->type == 'verified') {
        $indicator = ' <-- THIS IS THE TEST NOTIFICATION';
        if ($n->user_id == 2) {
            $indicator .= ' ✓ CORRECT (went to staff)';
        } else {
            $indicator .= ' ✗ WRONG (went to ' . $n->nama_role . ')';
        }
    }
    
    echo sprintf(
        "ID: %s | To: %s (ID:%s, %s) | Type: %s | Module_ID: %s%s\n",
        $n->id,
        $n->nama_lengkap,
        $n->user_id,
        $n->nama_role,
        $n->type,
        $n->module_id ?? 'N/A',
        $indicator
    );
}

echo "\n=== Analysis ===\n";
$testNotification = DB::table('notifications')
    ->where('module_id', $testId)
    ->where('type', 'verified')
    ->orderBy('id', 'desc')
    ->first();

if ($testNotification) {
    if ($testNotification->user_id == 2) {
        echo "✓ SUCCESS: Notification correctly sent to staff (ID: 2)\n";
    } else {
        echo "✗ FAILED: Notification sent to user ID {$testNotification->user_id} instead of staff (ID: 2)\n";
        echo "\nDEBUG INFO:\n";
        echo "Expected recipient: User ID 2 (staff who created the data)\n";
        echo "Actual recipient: User ID {$testNotification->user_id}\n";
    }
} else {
    echo "No verification notification found for test data.\n";
    echo "Please verify the data first using admin account.\n";
}
