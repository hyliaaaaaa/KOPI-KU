-- =============================================
-- 1. Buat database baru bernama "db_kopi"
--    (kalau belum ada) lalu pilih jadi aktif
-- =============================================
CREATE DATABASE IF NOT EXISTS db_kopi;
USE db_kopi;

-- =============================================
-- 2. Buat tabel produk untuk menyimpan menu kafe
-- =============================================
CREATE TABLE IF NOT EXISTS produk (
    id          INT AUTO_INCREMENT PRIMARY KEY,  -- nomor unik tiap menu
    nama        VARCHAR(100) NOT NULL,           -- nama menu
    kategori    VARCHAR(50)  NOT NULL,           -- kategori (minuman / makanan)
    deskripsi   TEXT,                            -- keterangan menu
    harga       INT NOT NULL,                    -- harga (Rupiah)
    stok        INT NOT NULL DEFAULT 0,          -- jumlah stok tersisa
    gambar      VARCHAR(255) DEFAULT 'https://picsum.photos/seed/kopi/400/300', -- url gambar dari internet
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- tanggal menu ditambahkan
);

-- =============================================
-- 3. Isi data contoh (seed) biar halaman tidak kosong
--    Gambar memakai picsum.photos (gambar dari internet)
-- =============================================
INSERT INTO produk (nama, kategori, deskripsi, harga, stok, gambar) VALUES
('Kopi Hitam',        'Minuman', 'Kopi hitam robusta dengan rasa pekat dan aroma khas.',     15000, 50, 'https://picsum.photos/seed/black/400/300'),
('Kopi Susu Gula Aren','Minuman', 'Perpaduan espresso, susu segar, dan gula aren asli.',      25000, 40, 'https://picsum.photos/seed/sugar/400/300'),
('Cappuccino',        'Minuman', 'Espresso dengan busa susu lembut di atasnya.',              28000, 35, 'https://picsum.photos/seed/cap/400/300'),
('Caffe Latte',       'Minuman', 'Kopi susu creamy dengan latte art cantik.',                 27000, 30, 'https://picsum.photos/seed/latte/400/300'),
('Matcha Latte',      'Minuman', 'Teh matcha premium dipadukan susu segar.',                  30000, 25, 'https://picsum.photos/seed/matcha/400/300'),
('Roti Bakar Keju',   'Makanan', 'Roti bakar gurih dengan keju mozzarella meleleh.',         22000, 20, 'https://picsum.photos/seed/bread/400/300'),
('Croissant Coklat',  'Makanan', 'Croissant lembut berisi isian coklat lumer.',               20000, 18, 'https://picsum.photos/seed/croissant/400/300'),
('Nasi Goreng Kampung','Makanan','Nasi goreng dengan bumbu khas cafe, dilengkapi telur.',    35000, 15, 'https://picsum.photos/seed/rice/400/300');