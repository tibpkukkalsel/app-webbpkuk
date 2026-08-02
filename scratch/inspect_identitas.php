<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$identitas = \App\Models\Identitas::all();
foreach ($identitas as $id) {
    echo $id->id_identitas . " | " . ($id->nama ?? '') . " | " . ($id->keterangan ?? '') . " | " . ($id->status ?? '') . "\n";
}
