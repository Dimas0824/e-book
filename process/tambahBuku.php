<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../includes/koneksi.php';
include_once '../includes/header.php';

// Jika ini adalah request POST untuk menambah buku
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    // Validasi input
    if (
        empty($_POST['judul']) || empty($_POST['pengarang']) || empty($_POST['penerbit']) ||
        empty($_POST['tahun_terbit']) || empty($_POST['stok'])
    ) {
        $_SESSION['tambah_error'] = "Semua field harus diisi!";
        header("Location: ../pages/tambahBuku.php");
        exit();
    }

    // Sanitasi input
    $judul = mysqli_real_escape_string($conn, trim($_POST['judul']));
    $pengarang = mysqli_real_escape_string($conn, trim($_POST['pengarang']));
    $penerbit = mysqli_real_escape_string($conn, trim($_POST['penerbit']));
    $tahun_terbit = mysqli_real_escape_string($conn, trim($_POST['tahun_terbit']));
    $stok = mysqli_real_escape_string($conn, trim($_POST['stok']));

    // Validasi tahun terbit (tidak boleh lebih dari tahun sekarang)
    $current_year = date('Y');
    if ($tahun_terbit > $current_year) {
        $_SESSION['tambah_error'] = "Tahun terbit tidak boleh lebih dari tahun sekarang!";
        header("Location: ../pages/tambahBuku.php");
        exit();
    }

    // Validasi stok (harus angka positif)
    if ($stok < 0) {
        $_SESSION['tambah_error'] = "Stok tidak boleh bernilai negatif!";
        header("Location: ../pages/tambahBuku.php");
        exit();
    }

    // Cek apakah buku dengan judul dan pengarang yang sama sudah ada
    $checkQuery = "SELECT id_buku FROM buku WHERE judul = '$judul' AND pengarang = '$pengarang'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['tambah_error'] = "Buku dengan judul dan pengarang yang sama sudah ada!";
        header("Location: ../pages/tambahBuku.php");
        exit();
    }

    // Query untuk menambah data buku
    $insertQuery = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok, created_at) 
                    VALUES ('$judul', '$pengarang', '$penerbit', '$tahun_terbit', '$stok', NOW())";

    if (mysqli_query($conn, $insertQuery)) {
        $_SESSION['tambah_success'] = true;
        $_SESSION['new_book_id'] = mysqli_insert_id($conn);
        header("Location: ../pages/tambahBuku.php");
        exit();
    } else {
        $_SESSION['tambah_error'] = "Error: " . mysqli_error($conn);
        header("Location: ../pages/tambahBuku.php");
        exit();
    }
}

// Jika mengakses file ini secara langsung tanpa POST, redirect ke form
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Location: ../pages/tambahBuku.php");
    exit();
}
?>