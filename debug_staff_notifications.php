<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Debug: Checking Staff Notifications ===\n\n";

// Staff user ID
$staffId = 2; // zai

echo "Checking notifications for staff user ID: {$staffId}\n\n";

// Get user info
$user = DB::table('users')
    ->join('roles', 'users.id_role', '=', 'roles.id_role')
    ->where('users.id_user', $staffId)
    ->select('users.*', 'roles.nama_role')
    ->first();

echo "User: {$user->nama_lengkap}\n";
echo "Role: {$user->nama_role}\n";
echo "User Primary Key (id_user): {$user->id_user}\n\n";

// Check all notifications for this user
echo "=== All Notifications for this User ===\n";
$allNotifications = DB::table('notifications')
    ->where('user_id', $staffId)
    ->orderBy('created_at', 'desc')
    ->get();

echo "Total notifications: " . $allNotifications->count() . "\n\n";

foreach($allNotifications as $n) {
    echo sprintf(
        "ID: %s | Type: %s | Title: %s | Read: %s | Created: %s\n",
        $n->id,
        $n->type,
        $n->title,
        $n->is_read ? 'Yes' : 'No',
        $n->created_at
    );
}

// Check unread notifications
echo "\n=== Unread Notifications ===\n";
$unreadNotifications = DB::table('notifications')
    ->where('user_id', $staffId)
    ->where('is_read', false)
    ->orderBy('created_at', 'desc')
    ->get();

echo "Total unread: " . $unreadNotifications->count() . "\n\n";

foreach($unreadNotifications as $n) {
    echo sprintf(
        "ID: %s | Type: %s | Title: %s | Created: %s\n",
        $n->id,
        $n->type,
        $n->title,
        $n->created_at
    );
}

// Test what API would return
echo "\n=== Simulating API Response ===\n";
echo "auth()->id() would return: {$user->id_user}\n";
echo "Query: SELECT * FROM notifications WHERE user_id = {$user->id_user} AND is_read = 0\n\n";

// Check if there are any notifications at all
echo "=== All Notifications in System ===\n";
$allSystemNotifications = DB::table('notifications')
    ->join('users', 'notifications.user_id', '=', 'users.id_user')
    ->select('notifications.*', 'users.nama_lengkap')
    ->orderBy('notifications.created_at', 'desc')
    ->take(10)
    ->get();

foreach($allSystemNotifications as $n) {
    $isForStaff = ($n->user_id == $staffId) ? ' <-- FOR STAFF' : '';
    echo sprintf(
        "ID: %s | To: %s (ID:%s) | Type: %s | Read: %s%s\n",
        $n->id,
        $n->nama_lengkap,
        $n->user_id,
        $n->type,
        $n->is_read ? 'Yes' : 'No',
        $isForStaff
    );
}

// Check recent verified pembudidaya
echo "\n=== Recent Verified Pembudidaya ===\n";
$verifiedData = DB::table('pembudidayas')
    ->where('status', 'verified')
    ->whereNotNull('verified_by')
    ->orderBy('verified_at', 'desc')
    ->take(5)
    ->get();

foreach($verifiedData as $p) {
    echo sprintf(
        "ID: %s | Name: %s | Created by: %s | Verified by: %s | Verified at: %s\n",
        $p->id_pembudidaya,
        $p->nama_lengkap,
        $p->created_by ?? 'NULL',
        $p->verified_by ?? 'NULL',
        $p->verified_at ?? 'NULL'
    );
}
