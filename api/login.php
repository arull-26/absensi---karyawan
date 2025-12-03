<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nik = $_POST['nik'];
    $password = md5($_POST['password']); // karena DB kamu pakai MD5

    $query = "SELECT * FROM pegawai WHERE nik = '$nik' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['nik'] = $data['nik'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'pegawai') {
            header("Location: pegawai/dashboard.php");
            exit();
        } else if ($data['role'] == 'admin') {
            header("Location: admin/dashboard.php");
            exit();
        }

    } else {
        echo "<script>alert('NIK atau Password salah!'); window.location='index.php';</script>";
    }
}
?>
