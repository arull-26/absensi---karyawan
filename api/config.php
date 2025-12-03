<?php
header("Content-Type: application/json");
require "../config.php";

if (!isset($_POST['nik']) || !isset($_POST['password'])) {
    echo json_encode(["status" => "error", "msg" => "Data tidak lengkap"]);
    exit;
}

$nik = $_POST['nik'];
$password = md5($_POST['password']); // sesuai database kamu

$sql = "SELECT * FROM pegawai WHERE nik = '$nik' AND password = '$password' LIMIT 1";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "msg" => "Query error: " . $conn->error
    ]);
    exit;
}

if ($result->num_rows == 0) {
    echo json_encode([
        "status" => "error",
        "msg" => "NIK atau Password salah!"
    ]);
    exit;
}

$user = $result->fetch_assoc();

echo json_encode([
    "status" => "success",
    "user" => [
        "id" => $user['id'],
        "nik" => $user['nik'],
        "nama" => $user['nama'],
        "role" => $user['role']
    ]
]);
?>
