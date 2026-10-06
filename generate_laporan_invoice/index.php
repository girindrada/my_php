<?php

$file = fopen('data_gaji.csv', 'r');
$header = fgetcsv($file);

while(($baris = fgetcsv($file)) !== false){
    $nama = $baris[0];
    $jabatan = $baris[1];
    $gajiPokok = $baris[2];
    $tunjangan = $baris[3];
    $potongan = $baris[4];

    $gajiBersih = $gajiPokok + $tunjangan - $potongan;

    // echo "$nama ($jabatan): Gaji bersih = $gajiBersih" . PHP_EOL;

    $isiSlip = 'SLIP GAJI KARYAWAN' . PHP_EOL;
    $isiSlip .= str_repeat('=', 30) . PHP_EOL;
    $isiSlip .= 'Nama           : ' . $nama . PHP_EOL;
    $isiSlip .= 'Jabatan        : ' . $jabatan . PHP_EOL;
    $isiSlip .= str_repeat('-', 30) . PHP_EOL;
    $isiSlip .= 'Gaji Pokok     : ' . number_format($gajiPokok, 0, ',', '.') . PHP_EOL;
    $isiSlip .= 'Tunjangan      : ' . number_format($tunjangan, 0, ',', '.') . PHP_EOL;
    $isiSlip .= 'Potongan       : ' . number_format($potongan, 0, ',', '.') . PHP_EOL;
    $isiSlip .= str_repeat('-', 30) . PHP_EOL;
    $isiSlip .= 'Gaji Bersih    : Rp ' . number_format($gajiBersih, 0, ',', '.');

    //  buat nama file unik per karyawan
    $namaFile = 'slip_gaji_' . $nama . '.txt';

    $fileSlip = fopen($namaFile, 'w');
    fwrite($fileSlip, $isiSlip);
    fclose($fileSlip);

    echo 'Slip gaji untuk ' . $nama . ' berhasil dibuat ' . $namaFile . PHP_EOL;
}

fclose($file);