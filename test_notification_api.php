<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Notification API Directly ===\n\n";

// Simulate authenticated request as staff (ID: 2)
$staffUser = \App\Models\User::find(2);

if (!$staffUser) {
    echo "Staff user not found!\n";
    exit;
}

echo "Simulating request as: {$staffUser->nama_lengkap} (ID: {$staffUser->id_user})\n\n";

// Test the Notification scope directly
echo "Testing Notification::forUser(2)->unread() query:\n";

$notifications = \App\Models\Notification::forUser($staffUser->id_user)
    ->unread()
    ->orderByDesc('created_at')
    ->limit(10)
    ->get();

echo "Found {$notifications->count()} unread notification(s)\n\n";

foreach($notifications as $n) {
    echo "Notification ID: {$n->id}\n";
    echo "  Type: {$n->type}\n";
    echo "  Title: {$n->title}\n";
    echo "  Message: {$n->message}\n";
    echo "  Module: {$n->module}\n";
    echo "  Module ID: {$n->module_id}\n";
    echo "  URL: {$n->url}\n";
    echo "  Is Read: " . ($n->is_read ? 'Yes' : 'No') . "\n";
    echo "  Created: {$n->created_at}\n\n";
}

// Test what the API would return
$response = [
    'notifications' => $notifications,
    'unread_count' => $notifications->count(),
];

echo "=== API Response (as JSON) ===\n";
echo json_encode($response, JSON_PRETTY_PRINT) . "\n\n";

// Check the scope implementation
echo "=== Verifying Scope Logic ===\n";
echo "Notification model scope 'forUser' filters by: user_id = {$staffUser->id_user}\n";
echo "Notification model scope 'unread' filters by: is_read = false\n\n";

// Raw query test
echo "=== Raw Query Test ===\n";
$rawNotifications = DB::table('notifications')
    ->where('user_id', $staffUser->id_user)
    ->where('is_read', false)
    ->orderByDesc('created_at')
    ->limit(10)
    ->get();

echo "Raw query found: {$rawNotifications->count()} unread notification(s)\n";

if ($notifications->count() != $rawNotifications->count()) {
    echo "⚠️  WARNING: Scope and raw query results differ!\n";
    echo "   Scope: {$notifications->count()}\n";
    echo "   Raw: {$rawNotifications->count()}\n";
} else {
    echo "✓ Scope and raw query match\n";
}
