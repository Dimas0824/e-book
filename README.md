# 📘 Buku Tamu Digital - PHP Native (Procedural)

Ini adalah proyek latihan **Buku Tamu Digital** berbasis **PHP Native** (tanpa framework), disusun sebagai persiapan untuk **sertifikasi Junior Web Developer (JWD)** dalam program **Digitalent VSGA**.

---

## 🎯 Tujuan Proyek

Membangun aplikasi web sederhana untuk mencatat informasi tamu yang berkunjung ke sebuah instansi (seperti kantor kelurahan), menyimpan data ke database, dan menampilkannya kembali dalam bentuk tabel.

---

## 🗂️ Struktur Folder

```bash
buku-tamu/
├── assets/
│   ├── css/
│   │   └── style.css              # File styling halaman
│   └── js/
│       └── validation.js          # Validasi form (opsional)
│
├── includes/
│   ├── header.php                 # Template bagian atas HTML
│   ├── footer.php                 # Template bagian bawah HTML
│   └── koneksi.php                # Koneksi ke database MySQL
│
├── pages/
│   ├── form_tamu.php              # Halaman form pengisian buku tamu
│   └── daftar_tamu.php            # Tabel daftar semua data tamu
│
├── proses/
│   ├── simpan_tamu.php            # Menyimpan data dari form ke database
│   └── hapus_tamu.php             # Menghapus data berdasarkan ID
│
├── index.php                      # Routing halaman utama
└── README.md                      # Dokumentasi proyek (file ini)
