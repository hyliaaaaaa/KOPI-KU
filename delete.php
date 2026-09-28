<?php
// =============================================
// 1. Sambungkan ke database
// =============================================
include 'config.php';

// =============================================
// 2. Ambil ID menu dari URL, paksa jadi angka biar aman
// =============================================
$id = (int) $_GET['id'];

// =============================================
// 3. Hapus menu sesuai ID dari tabel
// =============================================
$conn->query("DELETE FROM produk WHERE id = $id");

// =============================================
// 4. Kembali ke halaman utama setelah selesai
// =============================================
header('Location: index.php');
exit;