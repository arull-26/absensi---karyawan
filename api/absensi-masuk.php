<?php
header("Content-Type: application/json");
require "config.php";

$pegawai_id = $_POST['pegawai_id'] ?? '';
$foto = $_POST['foto'] ?? null; // base64 foto jika ada

if ($pegawai_id == '') {
    echo json_encode([
        "status" => "error",
        "msg" => "pegawai_id tidak boleh kosong"
    ]);
    exit;
}

$tanggal = date("Y-m-d");

// Cek apakah sudah absen hari ini
$cek = $conn->prepare("SELECT * FROM absensi WHERE pegawai_id = ? AND tanggal = ?");
$cek->bind_param("is", $pegawai_id, $tanggal);
$cek->execute();
$res = $cek->get_result();

if ($res->num_rows > 0) {
    echo json_encode([
        "status" => "error",
        "msg" => "Anda sudah melakukan absensi masuk hari ini"
    ]);
    exit;
}

// Simpan absensi masuk
$jam_masuk = date("H:i:s");

$stmt = $conn->prepare("
    INSERT INTO absensi (pegawai_id, tanggal, jam_masuk, foto_masuk, status)
    VALUES (?, ?, ?, ?, 'hadir')
");

$stmt->bind_param("isss", $pegawai_id, $tanggal, $jam_masuk, $foto);
$stmt->execute();

echo json_encode([
    "status" => "success",
    "msg" => "Absensi masuk berhasil dicatat",
    "tanggal" => $tanggal,
    "jam_masuk" => $jam_masuk
]);
