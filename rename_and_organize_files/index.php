<?php

$folder = "dokumen_lama";
$daftarFile = scandir($folder);
$timestamp = date('Y-m-d');
$nomor = 1;

foreach($daftarFile as $nama){
    // lewati 2 entri bawaam system
    if($nama === '.' || $nama === '..'){
        continue;
    }

    // ambil ekstensi file (bagian setelah . terakhir ex: jpg, png, dsb)
    $ekstensi = pathinfo($nama, PATHINFO_EXTENSION);

    $namaBaru = $timestamp . '_dokumen_' . $nomor . '.' . $ekstensi;

    // gabungkan dengan path folder
    $pathLama = $folder . '/' . $nama;
    $pathBaru = $folder . '/' . $namaBaru;

    rename($pathLama, $pathBaru);

    echo 'Rename: ' . $nama . ' -> ' . $namaBaru . PHP_EOL;

    $nomor++;
}

echo PHP_EOL;
echo 'Selesai! Semua file sudah di rename';
// print_r($daftarFile);