<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../includes/koneksi.php';
include_once '../includes/header.php';

if (!isset($_GET['id']) && !isset($_POST['id'])) {
    die("ID buku tidak ditemukan.");
}

// Ambil ID dari GET atau POST
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];

// Jika ini adalah request POST untuk update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $stok = mysqli_real_escape_string($conn, $_POST['stok']);

    $updateQuery = "UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun_terbit='$tahun_terbit', stok='$stok' WHERE id_buku=$id";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['edit_success'] = true;
        header("Location: ../views/editBuku.php?id=$id");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Query untuk mendapatkan data buku (untuk form)
$query = "SELECT * FROM buku WHERE id_buku = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Data buku tidak ditemukan.");
}

$row = mysqli_fetch_assoc($result);
?>