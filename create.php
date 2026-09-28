<?php
// =============================================
// 1. Sambungkan ke database
// =============================================
include 'config.php';

// =============================================
// 2. Cek apakah form sudah dikirim (tombol Simpan ditekan)
// =============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // =============================================
    // 3. Ambil data dari form lalu bersihkan
    // =============================================
    $nama      = $conn->real_escape_string($_POST['nama']);      // nama menu
    $kategori  = $conn->real_escape_string($_POST['kategori']);  // kategori menu
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']); // keterangan
    $harga     = (int) $_POST['harga'];                          // harga jadi angka
    $stok      = (int) $_POST['stok'];                           // stok jadi angka
    $gambar    = $conn->real_escape_string($_POST['gambar']);    // url gambar

    // =============================================
    // 4. Kalau gambar kosong, pakai gambar default
    // =============================================
    if ($gambar === '') {
        $gambar = 'https://picsum.photos/seed/kopi/400/300';
    }

    // =============================================
    // 5. Simpan menu baru ke tabel produk
    // =============================================
    $conn->query("INSERT INTO produk (nama, kategori, deskripsi, harga, stok, gambar)
                  VALUES ('$nama', '$kategori', '$deskripsi', $harga, $stok, '$gambar')");

    // =============================================
    // 6. Kembali ke halaman utama setelah tersimpan
    // =============================================
    header('Location: index.php');
    exit;
}
?>
<!-- 7. Deklarasi HTML5 -->
<!DOCTYPE html>
<!-- 8. Bahasa halaman -->
<html lang="id">
<head>
    <!-- 9. Encoding karakter -->
    <meta charset="UTF-8">
    <!-- 10. Responsif untuk layar kecil -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 11. Judul tab -->
    <title>Tambah Menu - Kopi-Ku</title>
    <!-- 12. Panggil CSS tema kopi -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- 13. Header halaman -->
    <header>
        <div class="logo">Kopi-Ku</div>
        <a href="index.php" class="btn">Kembali</a>
    </header>

    <!-- 14. Wadah isi halaman -->
    <div class="container">
        <!-- 15. Judul halaman -->
        <h2 class="page-title">Tambah Menu Baru</h2>

        <!-- 16. Formulir tambah menu -->
        <div class="form-box">
            <form method="POST" action="">
                <!-- 17. Input nama menu -->
                <label>Nama Menu</label>
                <input type="text" name="nama" required>

                <!-- 18. Pilihan kategori -->
                <label>Kategori</label>
                <select name="kategori" required>
                    <!-- 19. Opsi pilihan kategori -->
                    <option value="Minuman">Minuman</option>
                    <option value="Makanan">Makanan</option>
                </select>

                <!-- 20. Input deskripsi -->
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" required></textarea>

                <!-- 21. Input harga -->
                <label>Harga (Rp)</label>
                <input type="number" name="harga" min="0" required>

                <!-- 22. Input stok -->
                <label>Stok</label>
                <input type="number" name="stok" min="0" required>

                <!-- 23. Input gambar (URL dari internet) -->
                <label>URL Gambar</label>
                <input type="text" name="gambar" placeholder="https://...">

                <!-- 24. Tombol simpan -->
                <button type="submit" class="btn">Simpan Menu</button>
            </form>
        </div>
    </div>

</body>
</html>