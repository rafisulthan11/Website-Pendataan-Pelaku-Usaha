<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Simulating Admin Verify Process ===\n\n";

// Admin ID
$adminId = 1;

// Find test data
$pembudidaya = \App\Models\Pembudidaya::where('nama_lengkap', 'STAFF TEST DATA')
    ->orderBy('id_pembudidaya', 'desc')
    ->first();

if (!$pembudidaya) {
    echo "Test data not found!\n";
    exit;
}

echo "Before verify:\n";
echo "  ID: {$pembudidaya->id_pembudidaya}\n";
echo "  Name: {$pembudidaya->nama_lengkap}\n";
echo "  Status: {$pembudidaya->status}\n";
echo "  Created by: {$pembudidaya->created_by}\n";
echo "  Updated by: " . ($pembudidaya->updated_by ?? 'NULL') . "\n\n";

// ===== THIS IS THE FIX CODE =====
// Capture created_by BEFORE update
$createdBy = $pembudidaya->created_by;
$updatedBy = $pembudidaya->updated_by;

echo "Captured values (BEFORE update):\n";
echo "  \$createdBy = {$createdBy}\n";
echo "  \$updatedBy = " . ($updatedBy ?? 'NULL') . "\n";
echo "  \$targetUserId = " . ($createdBy ?? $updatedBy) . "\n\n";

// Update status (simulate admin verify)
echo "Admin (ID: {$adminId}) is verifying...\n";
$pembudidaya->update([
    'status' => 'verified',
    'verified_by' => $adminId,
    'verified_at' => now(),
]);

echo "✓ Status updated to: {$pembudidaya->status}\n";
echo "✓ Verified by: {$pembudidaya->verified_by}\n\n";

// Check if created_by still exists after update
$pembudidaya->refresh();
echo "After update (from database):\n";
echo "  created_by: " . ($pembudidaya->created_by ?? 'NULL') . "\n";
echo "  updated_by: " . ($pembudidaya->updated_by ?? 'NULL') . "\n\n";

// Create notification using captured value
$targetUserId = $createdBy ?? $updatedBy;

echo "Creating notification...\n";
echo "  Target user_id: {$targetUserId}\n";

// Create notification (simulating the controller code)
$adminUser = \App\Models\User::find($adminId);
$notificationId = DB::table('notifications')->insertGetId([
    'user_id' => $targetUserId,
    'type' => 'verified',
    'title' => 'Data Pembudidaya Diverifikasi',
    'message' => 'Admin ' . $adminUser->nama_lengkap . ' telah memverifikasi data pembudidaya: ' . $pembudidaya->nama_lengkap,
    'module' => 'pembudidaya',
    'module_id' => $pembudidaya->id_pembudidaya,
    'url' => route('pembudidaya.show', $pembudidaya->id_pembudidaya),
    'is_read' => false,
    'created_at' => now(),
    'updated_at' => now()
]);

echo "✓ Notification created with ID: {$notificationId}\n\n";

// Verify the notification
$notification = DB::table('notifications')
    ->join('users', 'notifications.user_id', '=', 'users.id_user')
    ->join('roles', 'users.id_role', '=', 'roles.id_role')
    ->where('notifications.id', $notificationId)
    ->select('notifications.*', 'users.nama_lengkap', 'roles.nama_role')
    ->first();

echo "=== VERIFICATION RESULT ===\n";
echo "Notification ID: {$notification->id}\n";
echo "Sent to user_id: {$notification->user_id}\n";
echo "Sent to: {$notification->nama_lengkap}\n";
echo "Role: {$notification->nama_role}\n";
echo "Is Read: " . ($notification->is_read ? 'Yes' : 'No') . "\n";
echo "Created at: {$notification->created_at}\n\n";

if ($notification->user_id == 2 && $notification->nama_role == 'staff') {
    echo "✅✅✅ SUCCESS!\n";
    echo "Notification correctly sent to STAFF (user_id: 2)\n\n";
    
    echo "Now check in browser:\n";
    echo "1. Login as staff: {$notification->nama_lengkap}\n";
    echo "2. Click bell icon in top-right\n";
    echo "3. You should see unread notification (red badge with number 1)\n";
    echo "4. Dropdown should show: 'Data Pembudidaya Diverifikasi'\n";
} else {
    echo "❌ FAILED!\n";
    echo "Expected: user_id=2, role=staff\n";
    echo "Got: user_id={$notification->user_id}, role={$notification->nama_role}\n";
}

echo "\n=== Check Current Unread Notifications for Staff ===\n";
$staffNotifications = DB::table('notifications')
    ->where('user_id', 2)
    ->where('is_read', false)
    ->orderBy('created_at', 'desc')
    ->get();

echo "Staff (user_id: 2) has {$staffNotifications->count()} unread notification(s):\n\n";
foreach($staffNotifications as $n) {
    echo "- {$n->title} (created: {$n->created_at})\n";
}
