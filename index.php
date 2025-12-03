<?php
// index.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Karyawan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div id="app">

    <!-- ================= LOGIN PAGE ================= -->
    <div class="page active" id="page-login">
        <div class="login-card">
            <h2>Login Absensi</h2>

            <div class="form-group">
                <label>NIK</label>
                <input type="text" id="login-nik">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" id="login-password">
            </div>

            <button class="btn-primary" id="btn-login">Masuk</button>

            <p class="msg" id="login-msg"></p>
        </div>
    </div>

    <!-- ================= DASHBOARD PEGAWAI ================= -->
    <div class="page" id="page-employee">

        <header class="topbar">
            <h2>Dashboard Pegawai</h2>
            <button class="btn-logout" onclick="logout()">Keluar</button>
        </header>

        <div class="content">

            <!-- CARD ABSENSI -->
            <div class="card">
                <h3>Absensi Hari Ini</h3>
                <button class="btn-primary" id="btn-absen">Ambil Presensi</button>

                <div id="camera-section" class="hidden">
                    <video id="camera-preview" autoplay></video>
                    <button class="btn-success" id="btn-take-photo">Ambil Foto</button>
                </div>
            </div>

            <!-- RIWAYAT -->
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

    <!-- ================= DASHBOARD ADMIN ================= -->
    <div class="page" id="page-admin">

        <header class="topbar">
            <h2>Dashboard Admin</h2>
            <button class="btn-logout" onclick="logout()">Keluar</button>
        </header>

        <div class="content grid-2">

            <!-- DATA PEGAWAI -->
            <div class="card">
                <h3>Data Pegawai</h3>
                <button class="btn-primary small">Tambah Pegawai</button>
                <table id="tabel-pegawai">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- DATA LOKASI -->
            <div class="card">
                <h3>Data Lokasi Presensi</h3>
                <button class="btn-primary small">Tambah Lokasi</button>
                <table id="tabel-lokasi">
                    <thead>
                        <tr>
                            <th>Nama Lokasi</th>
                            <th>Lat</th>
                            <th>Lon</th>
                            <th>Radius</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- REKAP -->
            <div class="card wide">
                <h3>Rekap Presensi</h3>
                <table id="tabel-rekap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pegawai</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button class="btn-success small">Export CSV</button>
            </div>

        </div>
    </div>

</div>

<script src="assets/app.js"></script>


</body>
</html>
