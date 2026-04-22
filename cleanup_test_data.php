<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Cleaning up test notifications...\n";

$deleted = DB::table('notifications')->whereIn('id', [3,4,5,6,7,8])->delete();

echo "✓ Deleted {$deleted} test notifications\n";

// Also delete test pembudidaya
$deletedPembudidaya = DB::table('pembudidayas')->where('id_pembudidaya', 17)->delete();
echo "✓ Deleted test pembudidaya data\n";

echo "\nCleanup complete! You can now test with fresh data.\n";
