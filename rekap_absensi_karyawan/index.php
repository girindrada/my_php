<?php

// buka file dan dibaca("r" = read)
$file = fopen("absensi.csv", "r");
$header = fgetcsv($file);

$rekap = []; // tempat menyimpan hasil rekap tiap karyawan
$batasMasuk = strtotime("08:00");

while(($baris = fgetcsv($file)) !== false){
    // print_r($baris);
    $nama = $baris[1];
    $jamMasuk = $baris[2];
    $status = $baris[3];

    // hanya override status kalau memang ada jam masuk
    if($jamMasuk !== "-"){
        $waktuMasuk = strtotime($jamMasuk);
        $status = ($waktuMasuk > $batasMasuk) ? "Telat" : "Hadir";
    }

    if(!isset($rekap[$nama])){
        $rekap[$nama] = [
            "Hadir" => 0,
            "Telat" => 0,
            "Izin" => 0,
            "Alpa" => 0,
        ];
    }

    // tambah counter sesuai status hari itu
    $rekap[$nama][$status]++;
}

fclose($file);

// print_r($rekap);
$file_laporan = fopen("laporan_absensi.txt", "w");
$judul = str_pad("Nama", 10) . str_pad("Hadir", 8) . str_pad("Telat", 8) . str_pad("Izin", 8) . str_pad("Alpa", 8) . "Persentase" . "\n";
$garis = str_repeat("-", 52) . "\n";

echo $judul;
echo $garis;

fwrite($file_laporan, $judul);
fwrite($file_laporan, $garis);

foreach($rekap as $nama => $data){
    $totalHariKerja = $data["Hadir"] + $data["Telat"] + $data["Alpa"];
    $persentase = ($totalHariKerja > 0) ? ($data["Hadir"] / $totalHariKerja) * 100 : 0;

    $rekap[$nama]["Persentase"] = round($persentase, 1);
}

// urutkan yang memiliki persentase tertinggi
uasort($rekap, function($a, $b){
    return $b["Persentase"] <=> $a["Persentase"];
});

foreach($rekap as $nama => $data){
    $baris = str_pad($nama, 10)
        . str_pad($data["Hadir"], 8)
        . str_pad($data["Telat"], 8)
        . str_pad($data["Izin"], 8)
        . str_pad($data["Alpa"], 8)
        . $data["Persentase"] . "%"
        . "\n";

        if($data["Alpa"] > 2){
            $baris .= "Perlu Perhatian!!!";
        }

        $baris .= "\n";

        echo $baris;
        fwrite($file_laporan, $baris);
}

fclose($file_laporan);

echo "\nLaporan berhasil disimpan";