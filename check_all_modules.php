<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Checking created_by for ALL Modules ===\n\n";

// Check Pembudidaya
echo "1️⃣  PEMBUDIDAYA:\n";
$pembudidayas = DB::table('pembudidayas')
    ->select('id_pembudidaya', 'nama_lengkap', 'created_by', 'status')
    ->orderBy('id_pembudidaya', 'desc')
    ->take(5)
    ->get();

foreach($pembudidayas as $p) {
    $creator = DB::table('users')->where('id_user', $p->created_by)->value('nama_lengkap');
    echo "   ID {$p->id_pembudidaya}: {$p->nama_lengkap} | Created by: {$p->created_by} ({$creator}) | Status: {$p->status}\n";
}

// Check Pengolah
echo "\n2️⃣  PENGOLAH:\n";
$pengolahs = DB::table('pengolahs')
    ->select('id_pengolah', 'nama_lengkap', 'created_by', 'status')
    ->orderBy('id_pengolah', 'desc')
    ->take(5)
    ->get();

if ($pengolahs->isEmpty()) {
    echo "   ⚠️  No data found\n";
} else {
    foreach($pengolahs as $p) {
        $creator = DB::table('users')->where('id_user', $p->created_by)->value('nama_lengkap');
        echo "   ID {$p->id_pengolah}: {$p->nama_lengkap} | Created by: {$p->created_by} ({$creator}) | Status: {$p->status}\n";
    }
}

// Check Pemasar
echo "\n3️⃣  PEMASAR:\n";
$pemasars = DB::table('pemasars')
    ->select('id_pemasar', 'nama_lengkap', 'created_by', 'status')
    ->orderBy('id_pemasar', 'desc')
    ->take(5)
    ->get();

if ($pemasars->isEmpty()) {
    echo "   ⚠️  No data found\n";
} else {
    foreach($pemasars as $p) {
        $creator = DB::table('users')->where('id_user', $p->created_by)->value('nama_lengkap');
        echo "   ID {$p->id_pemasar}: {$p->nama_lengkap} | Created by: {$p->created_by} ({$creator}) | Status: {$p->status}\n";
    }
}

// Check Harga Ikan Segar
echo "\n4️⃣  HARGA IKAN SEGAR:\n";
$hargaIkan = DB::table('harga_ikan_segars')
    ->select('id_harga', 'jenis_ikan', 'nama_pedagang', 'created_by', 'status')
    ->orderBy('id_harga', 'desc')
    ->take(5)
    ->get();

if ($hargaIkan->isEmpty()) {
    echo "   ⚠️  No data found\n";
} else {
    foreach($hargaIkan as $h) {
        $creator = DB::table('users')->where('id_user', $h->created_by)->value('nama_lengkap');
        echo "   ID {$h->id_harga}: {$h->jenis_ikan} ({$h->nama_pedagang}) | Created by: {$h->created_by} ({$creator}) | Status: {$h->status}\n";
    }
}

// Check all notifications
echo "\n\n=== ALL NOTIFICATIONS ===\n";
$notifications = DB::table('notifications')
    ->join('users', 'notifications.user_id', '=', 'users.id_user')
    ->select('notifications.*', 'users.nama_lengkap')
    ->orderBy('notifications.created_at', 'desc')
    ->take(15)
    ->get();

foreach($notifications as $n) {
    $module = strtoupper(substr($n->module, 0, 4));
    $toWhom = ($n->user_id == 1) ? '👨‍💼 ADMIN' : '👤 STAFF';
    echo "{$module} | To: {$n->nama_lengkap} {$toWhom} | Type: {$n->type} | Module_ID: {$n->module_id} | {$n->created_at}\n";
}

echo "\n\n=== ANALYSIS ===\n";

$staffNotifications = DB::table('notifications')->where('user_id', 2)->count();
$adminNotifications = DB::table('notifications')->where('user_id', 1)->count();

echo "Staff (ID:2) has {$staffNotifications} total notifications\n";
echo "Admin (ID:1) has {$adminNotifications} total notifications\n\n";

// Check verified data with wrong created_by
echo "=== PROBLEM DATA (verified but created_by = admin) ===\n";

$wrongPembudidaya = DB::table('pembudidayas')
    ->where('status', 'verified')
    ->where('created_by', 1) // Created by admin
    ->count();
    
$wrongPengolah = DB::table('pengolahs')
    ->where('status', 'verified')
    ->where('created_by', 1)
    ->count();
    
$wrongPemasar = DB::table('pemasars')
    ->where('status', 'verified')
    ->where('created_by', 1)
    ->count();
    
$wrongHargaIkan = DB::table('harga_ikan_segars')
    ->where('status', 'verified')
    ->where('created_by', 1)
    ->count();

echo "Pembudidaya: {$wrongPembudidaya} data (created_by = admin but verified)\n";
echo "Pengolah: {$wrongPengolah} data (created_by = admin but verified)\n";
echo "Pemasar: {$wrongPemasar} data (created_by = admin but verified)\n";
echo "Harga Ikan: {$wrongHargaIkan} data (created_by = admin but verified)\n\n";

echo "💡 SOLUTION:\n";
echo "Data lama yang created_by = admin akan mengirim notifikasi ke admin.\n";
echo "Untuk test dengan benar, buat data BARU sebagai STAFF.\n";
echo "\nJalankan:\n";
echo "  php create_test_all_modules.php\n";
