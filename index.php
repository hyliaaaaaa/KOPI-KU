<?php
// =============================================
// 1. Sambungkan ke database
// =============================================
include 'config.php';

// =============================================
// 2. Ambil semua data menu, diurutkan yang terbaru
// =============================================
$result = $conn->query("SELECT * FROM produk ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi-Ku - Kafe</title>
    <!-- Panggil file CSS tema kopi -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- ============================================
        HEADER (bagian penanda toko)
    ============================================= -->
    <header>
        <div class="logo">Kopi-Ku</div>

        <!-- Kotak pencarian menu -->
        <input type="text" id="searchBox" class="search-box" placeholder="Cari menu...">

        <!-- Tombol buka keranjang -->
        <button id="cartBtn" class="cart-btn">Keranjang <span id="cartCount" class="cart-count">0</span></button>
    </header>

    <!-- ============================================
        HERO BANNER (gambar promosi di bagian atas)
    ============================================= -->
    <section class="hero" style="background-image:url('https://picsum.photos/seed/hero-kopi/1600/700');">
        <!-- Layer gelap supaya teks tetap terbaca -->
        <div class="hero-overlay"></div>

        <!-- Isi teks hero -->
        <div class="hero-content">
            <!-- Judul besar -->
            <h1>Selamat Datang di <span>Kopi-Ku</span></h1>
            <!-- Slogan kafe -->
            <p>Setiap cangkir kami diseduh dengan hati. Temukan menu favoritmu sekarang!</p>
            <!-- Tombol langsung menuju daftar menu -->
            <a href="#menu" class="btn hero-btn">Lihat Menu</a>
        </div>
    </section>

    <!-- ============================================
        BAGIAN FITUR KAFE (3 kotak kepercayaan)
    ============================================= -->
    <section class="features">
        <!-- 1. Fitur: biji kopi pilihan -->
        <div class="feature">
            <div class="feature-icon">&#9749;</div>
            <h3>Biji Kopi Pilihan</h3>
            <p>Hanya biji robusta &amp; arabika kualitas terbaik.</p>
        </div>

        <!-- 2. Fitur: racikan manual -->
        <div class="feature">
            <div class="feature-icon">&#128250;</div>
            <h3>Diseduh Fresh</h3>
            <p>Setiap pesanan diseduh langsung saat dipesan.</p>
        </div>

        <!-- 3. Fitur: suasana nyaman -->
        <div class="feature">
            <div class="feature-icon">&#128588;</div>
            <h3>Nyaman &amp; Hangat</h3>
            <p>Tempat duduk cozy cocok untuk kerja dan ngobrol.</p>
        </div>
    </section>

    <!-- ============================================
        BAGIAN MENU (daftar produk)
    ============================================= -->
    <div class="menu-section" id="menu">
        <!-- Judul bagian menu -->
        <h2 class="page-title">Menu Kafe Kami</h2>

        <!-- Tombol tambah menu (masuk halaman admin) -->
        <a href="create.php" class="btn btn-add">+ Tambah Menu</a>

        <!-- Baris filter kategori -->
        <div class="filter-bar">
            <button class="filter-btn active" data-filter="semua">Semua</button>
            <button class="filter-btn" data-filter="Minuman">Minuman</button>
            <button class="filter-btn" data-filter="Makanan">Makanan</button>
        </div>

        <!-- Wadah grid kartu menu -->
        <div class="product-grid">
            <?php
            // Ambil data satu per satu dari database
            while ($row = $result->fetch_assoc()) :
            ?>
            <!-- Satu kartu menu -->
            <div class="card"
                 data-nama="<?= htmlspecialchars($row['nama']) ?>"
                 data-kategori="<?= htmlspecialchars($row['kategori']) ?>">

                <!-- Area gambar + badge kategori menumpuk di atasnya -->
                <div class="card-image">
                    <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>">
                    <span class="category"><?= htmlspecialchars($row['kategori']) ?></span>
                </div>

                <!-- Isi teks kartu -->
                <div class="card-body">
                    <h3><?= htmlspecialchars($row['nama']) ?></h3>
                    <p><?= htmlspecialchars($row['deskripsi']) ?></p>
                    <div class="price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></div>

                    <!-- Status stok -->
                    <?php if ($row['stok'] > 0): ?>
                        <span class="stock">Stok: <?= $row['stok'] ?></span>
                    <?php else: ?>
                        <span class="stock out">Habis</span>
                    <?php endif; ?>

                    <!-- Tombol aksi di dalam kartu -->
                    <div class="card-actions">
                        <?php if ($row['stok'] > 0): ?>
                            <!-- Tombol beli (ditangani JavaScript) -->
                            <button class="btn btn-buy"
                                    data-id="<?= $row['id'] ?>"
                                    data-nama="<?= htmlspecialchars($row['nama']) ?>"
                                    data-harga="<?= $row['harga'] ?>">Beli</button>
                        <?php endif; ?>

                        <!-- Tombol edit menu -->
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>

                        <!-- Tombol hapus menu -->
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-delete"
                           onclick="return confirm('Yakin hapus menu ini?')">Hapus</a>
                    </div>
                </div>
            </div>
            <?php
            // Tutup perulangan data
            endwhile;
            ?>
        </div>
    </div>

    <!-- ============================================
        FOOTER (bagian penutup halaman)
    ============================================= -->
    <footer>
        <!-- Nama toko -->
        <div class="footer-brand">Kopi-Ku</div>
        <!-- Info singkat -->
        <p>Kafe kecil dengan rasa besar. Buka setiap hari 08.00 - 22.00.</p>
        <!-- Tautan kembali ke atas -->
        <a href="#" class="back-top">&#11014; Kembali ke atas</a>
    </footer>

    <!-- ============================================
        LACI KERANJANG dan PERANGKAT PENDUKUNG
    ============================================= -->
    <div class="overlay" id="overlay"></div>

    <!-- Laci keranjang -->
    <aside class="cart-drawer" id="cartDrawer">
        <div class="cart-header">
            <span>Keranjang Pesanan</span>
            <button class="close-cart" id="closeCart">&times;</button>
        </div>
        <div class="cart-items" id="cartItems"></div>

        <div class="cart-footer">
            <div class="cart-total">
                <span>Total</span>
                <span id="cartTotal">Rp 0</span>
            </div>
            <button class="btn checkout-btn" id="checkoutBtn">Checkout</button>
        </div>
    </aside>

    <!-- Kotak pesan singkat -->
    <div class="toast" id="toast"></div>

    <!-- Panggil file JavaScript -->
    <script src="script.js"></script>
</body>
</html>