<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Checking Pembudidaya Data ===\n";
$pembudidayas = DB::table('pembudidayas')
    ->select('id_pembudidaya', 'nama_lengkap', 'created_by', 'updated_by', 'verified_by', 'status')
    ->orderBy('id_pembudidaya', 'desc')
    ->take(5)
    ->get();

foreach($pembudidayas as $p) {
    echo sprintf(
        "ID: %s | Name: %s | Created: %s | Updated: %s | Verified: %s | Status: %s\n",
        $p->id_pembudidaya,
        $p->nama_lengkap,
        $p->created_by ?? 'NULL',
        $p->updated_by ?? 'NULL',
        $p->verified_by ?? 'NULL',
        $p->status
    );
}

echo "\n=== Checking Users & Roles ===\n";
$users = DB::table('users')
    ->join('roles', 'users.id_role', '=', 'roles.id_role')
    ->select('users.id_user', 'users.nama_lengkap', 'roles.nama_role')
    ->get();

foreach($users as $u) {
    echo sprintf("ID: %s | Name: %s | Role: %s\n", $u->id_user, $u->nama_lengkap, $u->nama_role);
}

echo "\n=== Checking Notifications ===\n";
$notifications = DB::table('notifications')
    ->join('users', 'notifications.user_id', '=', 'users.id_user')
    ->join('roles', 'users.id_role', '=', 'roles.id_role')
    ->select('notifications.id', 'notifications.user_id', 'users.nama_lengkap', 'roles.nama_role', 'notifications.type', 'notifications.title', 'notifications.created_at')
    ->orderBy('notifications.created_at', 'desc')
    ->take(10)
    ->get();

foreach($notifications as $n) {
    echo sprintf(
        "ID: %s | User: %s (ID:%s) | Role: %s | Type: %s | Title: %s | Time: %s\n",
        $n->id,
        $n->nama_lengkap,
        $n->user_id,
        $n->nama_role,
        $n->type,
        $n->title,
        $n->created_at
    );
}

echo "\n=== Checking auth()->id() behavior ===\n";
echo "Primary key in User model: id_user\n";
echo "auth()->id() should return value from id_user column\n";
