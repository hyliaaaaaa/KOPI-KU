<?php
// =============================================
// 1. Sambungkan ke database
// =============================================
include 'config.php';

// =============================================
// 2. Ambil ID menu dari URL, paksa jadi angka
// =============================================
$id = (int) $_GET['id'];

// =============================================
// 3. Cari data menu sesuai ID
// =============================================
$data = $conn->query("SELECT * FROM produk WHERE id = $id")->fetch_assoc();

// =============================================
// 4. Kalau data tidak ada, hentikan program
// =============================================
if (!$data) {
    die('Menu tidak ditemukan');
}

// =============================================
// 5. Cek apakah form edit sudah dikirim
// =============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // =============================================
    // 6. Ambil nilai terbaru dari form lalu bersihkan
    // =============================================
    $nama      = $conn->real_escape_string($_POST['nama']);
    $kategori  = $conn->real_escape_string($_POST['kategori']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $harga     = (int) $_POST['harga'];
    $stok      = (int) $_POST['stok'];
    $gambar    = $conn->real_escape_string($_POST['gambar']);

    // =============================================
    // 7. Kalau gambar kosong, pakai gambar default
    // =============================================
    if ($gambar === '') {
        $gambar = 'https://picsum.photos/seed/kopi/400/300';
    }

    // =============================================
    // 8. Perbarui data menu di database
    // =============================================
    $conn->query("UPDATE produk
                  SET nama = '$nama', kategori = '$kategori', deskripsi = '$deskripsi',
                      harga = $harga, stok = $stok, gambar = '$gambar'
                  WHERE id = $id");

    // =============================================
    // 9. Kembali ke halaman utama
    // =============================================
    header('Location: index.php');
    exit;
}
?>
<!-- 10. Deklarasi HTML5 -->
<!DOCTYPE html>
<!-- 11. Bahasa halaman -->
<html lang="id">
<head>
    <!-- 12. Encoding karakter -->
    <meta charset="UTF-8">
    <!-- 13. Responsif untuk layar kecil -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 14. Judul tab -->
    <title>Edit Menu - Kopi-Ku</title>
    <!-- 15. Panggil CSS tema kopi -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- 16. Header halaman -->
    <header>
        <div class="logo">Kopi-Ku</div>
        <a href="index.php" class="btn">Kembali</a>
    </header>

    <!-- 17. Wadah isi halaman -->
    <div class="container">
        <!-- 18. Judul halaman -->
        <h2 class="page-title">Edit Menu</h2>

        <!-- 19. Formulir edit menu -->
        <div class="form-box">
            <form method="POST" action="">
                <!-- 20. Input nama (terisi data lama) -->
                <label>Nama Menu</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

                <!-- 21. Pilihan kategori (terisi data lama) -->
                <label>Kategori</label>
                <select name="kategori" required>
                    <!-- 22. Opsi minuman, terpilih kalau sesuai -->
                    <option value="Minuman" <?= $data['kategori'] === 'Minuman' ? 'selected' : '' ?>>Minuman</option>
                    <!-- 23. Opsi makanan, terpilih kalau sesuai -->
                    <option value="Makanan" <?= $data['kategori'] === 'Makanan' ? 'selected' : '' ?>>Makanan</option>
                </select>

                <!-- 24. Input deskripsi (terisi data lama) -->
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>

                <!-- 25. Input harga (terisi data lama) -->
                <label>Harga (Rp)</label>
                <input type="number" name="harga" min="0" value="<?= $data['harga'] ?>" required>

                <!-- 26. Input stok (terisi data lama) -->
                <label>Stok</label>
                <input type="number" name="stok" min="0" value="<?= $data['stok'] ?>" required>

                <!-- 27. Input gambar (terisi data lama) -->
                <label>URL Gambar</label>
                <input type="text" name="gambar" value="<?= htmlspecialchars($data['gambar']) ?>">

                <!-- 28. Tombol simpan perubahan -->
                <button type="submit" class="btn">Simpan Perubahan</button>
            </form>
        </div>
    </div>

</body>
</html>