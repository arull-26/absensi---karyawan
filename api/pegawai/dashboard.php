<?php
// pegawai/dashboard.php
session_start();

// Cek jika belum login
if (!isset($_SESSION['pegawai'])) {
    header("Location: ../index.php");
    exit;
}

$pegawai = $_SESSION['pegawai'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pegawai</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div id="app">

    <header class="topbar">
        <h2>Selamat Datang, <?= htmlspecialchars($pegawai['nama']) ?></h2>
        <button class="btn-logout" onclick="logout()">Keluar</button>
    </header>

    <div class="content">

        <!-- ================= CARD ABSENSI ================= -->
        <div class="card">
            <h3>Absensi Hari Ini</h3>

            <button class="btn-primary" id="btn-absen">Ambil Presensi</button>

            <!-- Section Kamera -->
            <div id="camera-section" class="hidden">
                <video id="camera-preview" autoplay></video>
                <button class="btn-success" id="btn-take-photo">Ambil Foto</button>
            </div>

            <p id="absen-msg" class="msg"></p>
        </div>

        <!-- ================= RIWAYAT ================= -->
        <div class="card">
            <h3>Riwayat Absensi</h3>

            <table id="tabel-riwayat">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>

</div>

<script>
// ========================== LOGOUT ==========================
function logout() {
    fetch("../api/logout.php")
        .then(() => { window.location.href = "../index.php"; });
}

// ========================== LOAD RIWAYAT ==========================
function loadRiwayat() {
    fetch("../api/pegawai/riwayat.php")
    .then(res => res.json())
    .then(data => {
        const tbody = document.querySelector("#tabel-riwayat tbody");
        tbody.innerHTML = "";

        if (data.status === "success") {
            data.data.forEach(r => {
                tbody.innerHTML += `
                    <tr>
                        <td>${r.tanggal}</td>
                        <td>${r.jenis}</td>
                        <td>${r.waktu}</td>
                    </tr>
                `;
            });
        }
    });
}

loadRiwayat();


// ========================== ABSENSI ==========================
document.getElementById("btn-absen").onclick = () => {
    document.getElementById("camera-section").classList.remove("hidden");

    navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        document.getElementById("camera-preview").srcObject = stream;
    });
};

document.getElementById("btn-take-photo").onclick = async () => {
    const video = document.getElementById("camera-preview");

    const canvas = document.createElement("canvas");
    canvas.width = 400;
    canvas.height = 300;
    canvas.getContext("2d").drawImage(video, 0, 0, 400, 300);

    const photo = canvas.toDataURL("image/jpeg");

    const send = await fetch("../api/pegawai/absen.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ photo })
    });

    const result = await send.json();
    document.getElementById("absen-msg").innerHTML = result.msg;

    if (result.status === "success") {
        loadRiwayat();
    }
};
</script>

</body>
</html>
