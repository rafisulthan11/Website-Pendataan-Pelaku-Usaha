<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Testing Notification Flow ===\n\n";

// Get a pending pembudidaya
$pembudidaya = DB::table('pembudidayas')
    ->where('status', 'pending')
    ->first();

if (!$pembudidaya) {
    echo "No pending data found. Creating test data...\n";
    // Would need to create test data here
} else {
    echo "Found pending pembudidaya:\n";
    echo "ID: {$pembudidaya->id_pembudidaya}\n";
    echo "Name: {$pembudidaya->nama_lengkap}\n";
    echo "Created by: {$pembudidaya->created_by}\n";
    echo "Updated by: " . ($pembudidaya->updated_by ?? 'NULL') . "\n";
    echo "Status: {$pembudidaya->status}\n\n";
    
    // Check who created this
    if ($pembudidaya->created_by) {
        $creator = DB::table('users')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->where('users.id_user', $pembudidaya->created_by)
            ->select('users.id_user', 'users.nama_lengkap', 'roles.nama_role')
            ->first();
        
        if ($creator) {
            echo "Data created by:\n";
            echo "  ID: {$creator->id_user}\n";
            echo "  Name: {$creator->nama_lengkap}\n";
            echo "  Role: {$creator->nama_role}\n\n";
            echo "✓ Notification SHOULD go to user ID {$creator->id_user} ({$creator->nama_lengkap})\n";
        }
    }
}

echo "\n=== All Active Users ===\n";
$users = DB::table('users')
    ->join('roles', 'users.id_role', '=', 'roles.id_role')
    ->select('users.id_user', 'users.nama_lengkap', 'roles.nama_role')
    ->get();

foreach($users as $u) {
    echo "ID: {$u->id_user} | {$u->nama_lengkap} | Role: {$u->nama_role}\n";
}

echo "\n=== Recent Notifications (Last 5) ===\n";
$notifications = DB::table('notifications')
    ->join('users', 'notifications.user_id', '=', 'users.id_user')
    ->select(
        'notifications.id',
        'notifications.user_id',
        'users.nama_lengkap',
        'notifications.type',
        'notifications.title',
        'notifications.module_id',
        'notifications.created_at'
    )
    ->orderBy('notifications.id', 'desc')
    ->take(5)
    ->get();

foreach($notifications as $n) {
    echo sprintf(
        "ID: %s | To: %s (ID:%s) | Type: %s | Module_ID: %s | Time: %s\n",
        $n->id,
        $n->nama_lengkap,
        $n->user_id,
        $n->type,
        $n->module_id ?? 'N/A',
        $n->created_at
    );
}

echo "\n=== Instructions ===\n";
echo "1. Note the pending data and who created it\n";
echo "2. Login as admin and verify/reject that data\n";
echo "3. Run this script again to check if notification went to correct user\n";
