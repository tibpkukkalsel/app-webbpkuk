<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$items = \App\Models\GisIdentifikasi::with('wilayah')->get();
foreach ($items as $i) {
    echo "Wilayah: " . ($i->wilayah->nama ?? 'N/A') . " | Tahun: " . $i->tahun . " | SDM: " . $i->jenis_sdm . " | Keterangan: " . $i->keterangan . "\n";
}
