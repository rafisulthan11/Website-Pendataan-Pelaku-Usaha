<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$tables = ['pengolahs', 'pemasars', 'harga_ikan_segars'];

foreach ($tables as $table) {
    echo "=== {$table} ===\n";
    $columns = DB::select("SHOW COLUMNS FROM {$table}");
    foreach($columns as $col) {
        $required = ($col->Null == 'NO' && $col->Default === null) ? ' [REQUIRED]' : '';
        echo "  {$col->Field}: {$col->Type} | Null:{$col->Null} | Default:{$col->Default}{$required}\n";
    }
    echo "\n";
}
