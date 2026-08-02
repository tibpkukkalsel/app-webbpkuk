<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$wilayahs = \App\Models\GisWilayah::all();
foreach ($wilayahs as $w) {
    echo $w->id_wilayah . " | " . $w->kode_bps . " | " . $w->nama . " | lat: " . $w->latitude . ", lng: " . $w->longitude . " | geojson len: " . strlen($w->geojson ?? '') . "\n";
}
