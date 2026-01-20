-- ===================================
-- SQL Dummy Data Kategori Produk Sembako
-- Project: Aplikasi Kasir Sembako
-- Total Data: 10 Kategori
-- ===================================

INSERT INTO kategori_produk (kode_kategori, nama_kategori, deskripsi, status, created_at, updated_at) VALUES
('KTG001', 'Beras & Tepung', 'Berbagai jenis beras, tepung terigu, tepung tapioka, dan produk serupa lainnya', 'Aktif', NOW(), NOW()),
('KTG002', 'Minyak & Lemak', 'Minyak goreng, mentega, margarin, dan lemak masak lainnya', 'Aktif', NOW(), NOW()),
('KTG003', 'Gula & Pemanis', 'Gula pasir, gula merah, gula kristal, dan pemanis buatan', 'Aktif', NOW(), NOW()),
('KTG004', 'Garam & Bumbu', 'Garam meja, bumbu dapur, rempah-rempah, dan penyedap masakan', 'Aktif', NOW(), NOW()),
('KTG005', 'Kopi & Teh', 'Kopi bubuk, kopi instant, teh celup, teh loose leaf, dan minuman serupa', 'Aktif', NOW(), NOW()),
('KTG006', 'Susu & Dairy', 'Susu segar, susu kental manis, susu bubuk, yogurt, dan produk dairy lainnya', 'Aktif', NOW(), NOW()),
('KTG007', 'Makanan Kaleng', 'Ikan kaleng, daging kaleng, sayuran kaleng, dan makanan kaleng lainnya', 'Aktif', NOW(), NOW()),
('KTG008', 'Mie & Pasta', 'Mie instan, mie telur, pasta, bihun, dan produk serupa lainnya', 'Aktif', NOW(), NOW()),
('KTG009', 'Snack & Gorengan', 'Kerupuk, kacang goreng, keripik, snack ringan, dan camilan lainnya', 'Aktif', NOW(), NOW()),
('KTG010', 'Minuman Kemasan', 'Air mineral, minuman bersoda, minuman jus, minuman olahraga, dan minuman kemasan lainnya', 'Aktif', NOW(), NOW());

-- Query untuk verifikasi data yang telah diinsert
-- SELECT * FROM kategori_produk;
