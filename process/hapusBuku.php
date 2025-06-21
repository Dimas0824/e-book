<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../includes/koneksi.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['delete_error'] = "ID buku tidak ditemukan!";
    header("Location: ../index.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Check if book exists
$checkQuery = "SELECT judul FROM buku WHERE id_buku = '$id'";
$checkResult = mysqli_query($conn, $checkQuery);

if (!$checkResult || mysqli_num_rows($checkResult) == 0) {
    $_SESSION['delete_error'] = "Buku tidak ditemukan!";
    header("Location: ../index.php");
    exit();
}

$book = mysqli_fetch_assoc($checkResult);

// Delete the book
$deleteQuery = "DELETE FROM buku WHERE id_buku = '$id'";

if (mysqli_query($conn, $deleteQuery)) {
    $_SESSION['delete_success'] = "Buku '" . $book['judul'] . "' berhasil dihapus!";
} else {
    $_SESSION['delete_error'] = "Gagal menghapus buku: " . mysqli_error($conn);
}

// Redirect back to index
header("Location: ../index.php");
exit();
?>