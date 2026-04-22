<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Verifying Notification was Sent Correctly ===\n\n";

// Find the test data
$testData = DB::table('pembudidayas')
    ->where('nama_lengkap', 'STAFF TEST DATA')
    ->orderBy('id_pembudidaya', 'desc')
    ->first();

if (!$testData) {
    echo "❌ Test data not found. Please run create_real_test.php first\n";
    exit;
}

echo "Test Data:\n";
echo "  ID: {$testData->id_pembudidaya}\n";
echo "  Name: {$testData->nama_lengkap}\n";
echo "  Status: {$testData->status}\n";
echo "  Created by: {$testData->created_by}\n";
echo "  Verified by: " . ($testData->verified_by ?? 'NOT YET') . "\n\n";

if ($testData->status !== 'verified') {
    echo "⏳ Data has not been verified yet.\n";
    echo "   Please login as admin and verify this data first.\n";
    exit;
}

// Check if notification was created
echo "Checking notifications...\n\n";

$notification = DB::table('notifications')
    ->where('module', 'pembudidaya')
    ->where('module_id', $testData->id_pembudidaya)
    ->where('type', 'verified')
    ->orderBy('created_at', 'desc')
    ->first();

if (!$notification) {
    echo "❌ NO NOTIFICATION FOUND\n";
    echo "   This means the notification was NOT created!\n\n";
    echo "Debug info:\n";
    echo "  Looking for: module=pembudidaya, module_id={$testData->id_pembudidaya}, type=verified\n";
    exit;
}

// Check who received the notification
$recipient = DB::table('users')
    ->join('roles', 'users.id_role', '=', 'roles.id_role')
    ->where('users.id_user', $notification->user_id)
    ->select('users.*', 'roles.nama_role')
    ->first();

echo "Notification Found:\n";
echo "  Notification ID: {$notification->id}\n";
echo "  Sent to user_id: {$notification->user_id}\n";
echo "  Sent to: {$recipient->nama_lengkap}\n";
echo "  Role: {$recipient->nama_role}\n";
echo "  Type: {$notification->type}\n";
echo "  Title: {$notification->title}\n";
echo "  Read: " . ($notification->is_read ? 'Yes' : 'No') . "\n";
echo "  Created: {$notification->created_at}\n\n";

// Verify correctness
if ($notification->user_id == $testData->created_by) {
    echo "✅ SUCCESS!\n";
    echo "   Notification correctly sent to the staff who created the data.\n";
    
    if ($recipient->nama_role == 'staff') {
        echo "✅ Confirmed: Recipient is a STAFF user.\n\n";
        
        echo "Now test in browser:\n";
        echo "1. Login as staff: {$recipient->nama_lengkap}\n";
        echo "2. Click bell icon\n";
        echo "3. You should see the verification notification\n";
    } else {
        echo "⚠️  WARNING: Recipient role is {$recipient->nama_role}, not staff\n";
    }
} else {
    echo "❌ FAILED!\n";
    echo "   Notification sent to wrong user.\n";
    echo "   Expected: user_id = {$testData->created_by} (staff who created data)\n";
    echo "   Actual: user_id = {$notification->user_id}\n";
}
