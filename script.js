// =============================================
// 1. Tunggu seluruh isi halaman selesai dimuat dulu
// =============================================
document.addEventListener('DOMContentLoaded', () => {

    // =============================================
    // 2. Ambil elemen-elemen penting dari halaman
    // =============================================
    const searchBox   = document.getElementById('searchBox');   // kotak pencarian
    const filterBtns  = document.querySelectorAll('.filter-btn'); // tombol filter kategori
    const cards       = document.querySelectorAll('.card');      // semua kartu menu
    const cartBtn     = document.getElementById('cartBtn');      // tombol buka keranjang
    const cartDrawer  = document.getElementById('cartDrawer');   // laci keranjang
    const closeCart   = document.getElementById('closeCart');    // tombol tutup laci
    const overlay     = document.getElementById('overlay');      // layer gelap
    const cartItems   = document.getElementById('cartItems');    // daftar item
    const cartCount   = document.getElementById('cartCount');    // angka jumlah item
    const cartTotal   = document.getElementById('cartTotal');    // teks total harga
    const checkoutBtn = document.getElementById('checkoutBtn');  // tombol bayar
    const toast       = document.getElementById('toast');        // kotak pemberitahuan

    // =============================================
    // 3. Ambil isi keranjang dari localStorage
    // =============================================
    let cart = JSON.parse(localStorage.getItem('cartKopi')) || [];

    // =============================================
    // 4. Fungsi untuk memunculkan pesan singkat (toast)
    // =============================================
    function showToast(message) {
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2000);
    }

    // =============================================
    // 5. Fungsi menyimpan keranjang ke localStorage
    // =============================================
    function saveCart() {
        localStorage.setItem('cartKopi', JSON.stringify(cart));
        renderCart();
    }

    // =============================================
    // 6. Fungsi menampilkan isi keranjang di laci
    // =============================================
    function renderCart() {
        cartItems.innerHTML = '';

        // Kalau keranjang kosong, tampilkan teks peringatan
        if (cart.length === 0) {
            cartItems.innerHTML = '<p style="text-align:center;color:#999;">Keranjang masih kosong</p>';
        }

        // Hitung total belanja dari awal
        let total = 0;
        let qty   = 0;

        // Ulangi tiap item di keranjang
        cart.forEach((item, index) => {
            // Tambahkan HTML baru untuk item ini
            cartItems.innerHTML += `
                <div class="cart-item">
                    <div>
                        <strong>${item.nama}</strong><br>
                        ${item.qty} x Rp ${item.harga.toLocaleString('id-ID')}
                    </div>
                    <button class="remove" data-index="${index}">Hapus</button>
                </div>`;
            // Akumulasikan total dan jumlah barang
            total += item.harga * item.qty;
            qty   += item.qty;
        });

        // Perbarui angka total dan badge jumlah item
        cartTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        cartCount.textContent = qty;
    }

    // =============================================
    // 7. FITUR PENCARIAN: filter kartu sesuai tulisan user
    // =============================================
    searchBox.addEventListener('input', () => {
        // Ambil kata kunci lalu ubah jadi huruf kecil
        const keyword = searchBox.value.toLowerCase();

        // Ulangi semua kartu menu
        cards.forEach(card => {
            const nama = card.dataset.nama.toLowerCase();
            // Tampilkan/hide sesuai kata kunci
            card.style.display = nama.includes(keyword) ? 'block' : 'none';
        });
    });

    // =============================================
    // 8. FILTER KATEGORI: tombol Semua / Minuman / Makanan
    // =============================================
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Pindahkan class 'active' ke tombol yang diklik
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Ambil kategori tujuan dari attribute data-filter
            const target = btn.dataset.filter;

            // Ulangi semua kartu
            cards.forEach(card => {
                // Kalau dipilih "Semua", tampilkan semua kartu
                if (target === 'semua') {
                    card.style.display = 'block';
                } else {
                    // Tampilkan hanya kartu yang kategorinya cocok
                    card.style.display = (card.dataset.kategori === target) ? 'block' : 'none';
                }
            });
        });
    });

    // =============================================
    // 9. Tombol BELI: tambahkan menu ke keranjang
    // =============================================
    document.querySelectorAll('.btn-buy').forEach(btn => {
        btn.addEventListener('click', () => {
            // Baca data menu dari attribute tombol
            const id    = parseInt(btn.dataset.id);
            const nama  = btn.dataset.nama;
            const harga = parseInt(btn.dataset.harga);

            // Cari apakah menu sudah ada di keranjang
            const found = cart.find(item => item.id === id);

            if (found) {
                // Kalau sudah ada, tambah jumlahnya saja
                found.qty += 1;
            } else {
                // Kalau belum ada, masukkan sebagai item baru
                cart.push({ id, nama, harga, qty: 1 });
            }

            // Simpan dan render ulang keranjang
            saveCart();

            // Tampilkan pesan singkat
            showToast(nama + ' masuk keranjang!');
        });
    });

    // =============================================
    // 10. Tombol HAPUS per item di dalam keranjang
    // =============================================
    cartItems.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove')) {
            // Ambil posisi item lalu hapus 1 data
            cart.splice(parseInt(e.target.dataset.index), 1);
            saveCart();
        }
    });

    // =============================================
    // 11. Tombol CHECKOUT: hapus semua isi keranjang
    // =============================================
    checkoutBtn.addEventListener('click', () => {
        if (cart.length === 0) {
            showToast('Keranjang masih kosong!');
            return;
        }
        cart = [];
        saveCart();
        showToast('Pesanan berhasil! Selamat menikmati.');
    });

    // =============================================
    // 12. BUKA laci keranjang + layer gelap
    // =============================================
    cartBtn.addEventListener('click', () => {
        cartDrawer.classList.add('active');
        overlay.classList.add('active');
    });

    // =============================================
    // 13. TUTUP laci keranjang (tombol X atau layer gelap)
    // =============================================
    [closeCart, overlay].forEach(el => {
        el.addEventListener('click', () => {
            cartDrawer.classList.remove('active');
            overlay.classList.remove('active');
        });
    });

    // =============================================
    // 14. Jalankan render pertama kali saat halaman dibuka
    // =============================================
    renderCart();
});