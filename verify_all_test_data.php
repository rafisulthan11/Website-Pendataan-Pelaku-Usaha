<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Notification;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║      SIMULATING ADMIN VERIFICATION FOR ALL TEST DATA           ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Admin ID
$adminId = 1;

// Get staff ID
$staffUser = DB::table('users')->where('id_role', 2)->first();
$staffId = $staffUser->id_user;
$staffName = $staffUser->nama_lengkap;

echo "👤 Admin ID: {$adminId}\n";
echo "👤 Staff ID: {$staffId} ({$staffName})\n\n";

// How many notifications before
$beforeCount = DB::table('notifications')
    ->where('user_id', $staffId)
    ->where('is_read', false)
    ->count();

echo "📊 Staff unread notifications BEFORE: {$beforeCount}\n\n";

echo "=" . str_repeat("=", 63) . "\n\n";

// 1. Verify PENGOLAH
echo "1️⃣  Verifying PENGOLAH...\n";
$pengolah = DB::table('pengolahs')
    ->where('nama_lengkap', 'LIKE', '%TEST PENGOLAH - Staff Data%')
    ->where('status', 'pending')
    ->orderBy('id_pengolah', 'desc')
    ->first();

if ($pengolah) {
    echo "   Found: ID {$pengolah->id_pengolah}, created_by: {$pengolah->created_by}\n";
    
    // Update status
    DB::table('pengolahs')->where('id_pengolah', $pengolah->id_pengolah)->update([
        'status' => 'verified',
        'verified_by' => $adminId,
        'verified_at' => now(),
        'updated_at' => now(),
    ]);
    
    // Create notification
    DB::table('notifications')->insert([
        'user_id' => $pengolah->created_by,
        'type' => 'verified',
        'title' => 'Data Pengolah Diverifikasi',
        'message' => "Data pengolah '{$pengolah->nama_lengkap}' telah diverifikasi oleh admin.",
        'module' => 'pengolah',
        'module_id' => $pengolah->id_pengolah,
        'url' => url("/pengolah/{$pengolah->id_pengolah}"),
        'is_read' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    echo "   ✅ VERIFIED! Notification sent to staff (ID: {$pengolah->created_by})\n\n";
} else {
    echo "   ⚠️  No pending pengolah test data found\n\n";
}

// 2. Verify PEMASAR
echo "2️⃣  Verifying PEMASAR...\n";
$pemasar = DB::table('pemasars')
    ->where('nama_lengkap', 'LIKE', '%TEST PEMASAR - Staff Data%')
    ->where('status', 'pending')
    ->orderBy('id_pemasar', 'desc')
    ->first();

if ($pemasar) {
    echo "   Found: ID {$pemasar->id_pemasar}, created_by: {$pemasar->created_by}\n";
    
    // Update status
    DB::table('pemasars')->where('id_pemasar', $pemasar->id_pemasar)->update([
        'status' => 'verified',
        'verified_by' => $adminId,
        'verified_at' => now(),
        'updated_at' => now(),
    ]);
    
    // Create notification
    DB::table('notifications')->insert([
        'user_id' => $pemasar->created_by,
        'type' => 'verified',
        'title' => 'Data Pemasar Diverifikasi',
        'message' => "Data pemasar '{$pemasar->nama_lengkap}' telah diverifikasi oleh admin.",
        'module' => 'pemasar',
        'module_id' => $pemasar->id_pemasar,
        'url' => url("/pemasar/{$pemasar->id_pemasar}"),
        'is_read' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    echo "   ✅ VERIFIED! Notification sent to staff (ID: {$pemasar->created_by})\n\n";
} else {
    echo "   ⚠️  No pending pemasar test data found\n\n";
}

// 3. Verify HARGA IKAN SEGAR
echo "3️⃣  Verifying HARGA IKAN SEGAR...\n";
$hargaIkan = DB::table('harga_ikan_segars')
    ->where('nama_pedagang', 'LIKE', '%TEST PEDAGANG - Staff Data%')
    ->where('status', 'pending')
    ->orderBy('id_harga', 'desc')
    ->first();

if ($hargaIkan) {
    echo "   Found: ID {$hargaIkan->id_harga}, created_by: {$hargaIkan->created_by}\n";
    
    // Update status
    DB::table('harga_ikan_segars')->where('id_harga', $hargaIkan->id_harga)->update([
        'status' => 'verified',
        'verified_by' => $adminId,
        'verified_at' => now(),
        'updated_at' => now(),
    ]);
    
    // Create notification
    DB::table('notifications')->insert([
        'user_id' => $hargaIkan->created_by,
        'type' => 'verified',
        'title' => 'Data Harga Ikan Segar Diverifikasi',
        'message' => "Data harga ikan segar untuk ikan '{$hargaIkan->jenis_ikan}' telah diverifikasi oleh admin.",
        'module' => 'harga_ikan_segar',
        'module_id' => $hargaIkan->id_harga,
        'url' => url("/harga-ikan-segar/{$hargaIkan->id_harga}"),
        'is_read' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    echo "   ✅ VERIFIED! Notification sent to staff (ID: {$hargaIkan->created_by})\n\n";
} else {
    echo "   ⚠️  No pending harga ikan test data found\n\n";
}

echo "=" . str_repeat("=", 63) . "\n\n";

// Check notifications after
$afterCount = DB::table('notifications')
    ->where('user_id', $staffId)
    ->where('is_read', false)
    ->count();

echo "📊 Staff unread notifications AFTER: {$afterCount}\n";
echo "📈 NEW notifications: " . ($afterCount - $beforeCount) . "\n\n";

// Show new notifications
echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║                    NEW STAFF NOTIFICATIONS                     ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

$newNotifications = DB::table('notifications')
    ->where('user_id', $staffId)
    ->where('is_read', false)
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

foreach ($newNotifications as $notif) {
    echo "🔔 [{$notif->module}] {$notif->title}\n";
    echo "   {$notif->message}\n";
    echo "   Created: {$notif->created_at}\n\n";
}

echo "✅ DONE! All test data verified.\n";
echo "💡 Now login as STAFF (zai) and check the bell icon! 🔔\n\n";
