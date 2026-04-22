<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Simulating Verify Process ===\n\n";

// Get the test pembudidaya
$testId = 17;
$pembudidaya = \App\Models\Pembudidaya::find($testId);

if (!$pembudidaya) {
    echo "Test data not found!\n";
    exit;
}

echo "Before verify:\n";
echo "  ID: {$pembudidaya->id_pembudidaya}\n";
echo "  Name: {$pembudidaya->nama_lengkap}\n";
echo "  Status: {$pembudidaya->status}\n";
echo "  created_by: {$pembudidaya->created_by}\n";
echo "  updated_by: " . ($pembudidaya->updated_by ?? 'NULL') . "\n\n";

// Capture created_by BEFORE update (simulating the fix)
$createdBy = $pembudidaya->created_by;
$updatedBy = $pembudidaya->updated_by;

echo "Captured values:\n";
echo "  \$createdBy = {$createdBy}\n";
echo "  \$updatedBy = " . ($updatedBy ?? 'NULL') . "\n";
echo "  \$targetUserId = " . ($createdBy ?? $updatedBy) . "\n\n";

// Simulate admin verify (admin ID = 1)
$adminId = 1;
$pembudidaya->update([
    'status' => 'verified',
    'verified_by' => $adminId,
    'verified_at' => now(),
]);

echo "After update:\n";
echo "  Status: {$pembudidaya->status}\n";
echo "  verified_by: {$pembudidaya->verified_by}\n\n";

// Check if created_by still exists
$pembudidaya->refresh();
echo "After refresh:\n";
echo "  created_by: " . ($pembudidaya->created_by ?? 'NULL') . "\n";
echo "  updated_by: " . ($pembudidaya->updated_by ?? 'NULL') . "\n\n";

// Create notification using the captured value
$targetUserId = $createdBy ?? $updatedBy;

echo "Creating notification...\n";
echo "  Target user_id: {$targetUserId}\n";

// Create notification
$notificationId = DB::table('notifications')->insertGetId([
    'user_id' => $targetUserId,
    'type' => 'verified',
    'title' => 'TEST: Data Pembudidaya Diverifikasi',
    'message' => 'This is a test notification',
    'module' => 'pembudidaya',
    'module_id' => $testId,
    'url' => route('pembudidaya.show', $testId),
    'created_at' => now(),
    'updated_at' => now()
]);

echo "✓ Notification created with ID: {$notificationId}\n\n";

// Verify the notification
$notification = DB::table('notifications')
    ->join('users', 'notifications.user_id', '=', 'users.id_user')
    ->where('notifications.id', $notificationId)
    ->select('notifications.*', 'users.nama_lengkap')
    ->first();

echo "Verification:\n";
echo "  Notification ID: {$notification->id}\n";
echo "  Sent to user_id: {$notification->user_id}\n";
echo "  Sent to: {$notification->nama_lengkap}\n";

if ($notification->user_id == 2) {
    echo "\n✓✓✓ SUCCESS! Notification sent to correct user (staff ID: 2)\n";
} else {
    echo "\n✗✗✗ FAILED! Notification sent to wrong user\n";
    echo "Expected: User ID 2 (staff)\n";
    echo "Got: User ID {$notification->user_id}\n";
}
