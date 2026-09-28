<?php
// =============================================
// 1. Alamat server MySQL (biasanya localhost)
// =============================================
$host = 'localhost';

// =============================================
// 2. Username bawaan MySQL di Laragon
// =============================================
$user = 'root';

// =============================================
// 3. Password bawaan Laragon (kosong)
// =============================================
$pass = '';

// =============================================
// 4. Nama database sesuai file db_kopi.sql
// =============================================
$db = 'db_kopi';

// =============================================
// 5. Koneksi ke MySQL memakai object mysqli
// =============================================
$conn = new mysqli($host, $user, $pass, $db);

// =============================================
// 6. Cek apakah koneksi berhasil atau gagal
// =============================================
if ($conn->connect_error) {
    // Kalau gagal, tampilkan pesan lalu hentikan script
    die('Koneksi gagal: ' . $conn->connect_error);
}

// =============================================
// 7. Set karakter koneksi biar huruf/angka aman
// =============================================
$conn->set_charset('utf8mb4');