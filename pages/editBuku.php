<?php
//include headers, connection, and process script
include_once '../process/editBuku.php';

//cek session untuk menampilkan modal sukses
$showSuccessModal = isset($_SESSION['edit_success']) && $_SESSION['edit_success'] === true;
if ($showSuccessModal) {
    unset($_SESSION['edit_success']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h1>Edit Buku</h1>
                <form action="../process/editBuku.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id_buku']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul"
                            value="<?php echo htmlspecialchars($row['judul']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pengarang</label>
                        <input type="text" class="form-control" name="pengarang"
                            value="<?php echo htmlspecialchars($row['pengarang']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" class="form-control" name="penerbit"
                            value="<?php echo htmlspecialchars($row['penerbit']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" name="tahun_terbit"
                            value="<?php echo htmlspecialchars($row['tahun_terbit']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" class="form-control" name="stok"
                            value="<?php echo htmlspecialchars($row['stok']); ?>" required>
                    </div>
                    <button type="submit" name="edit" class="btn btn-warning">Simpan Perubahan</button>
                    <a href="../index.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Data buku berhasil diperbarui!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        onclick="window.location.href='../index.php'">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if ($showSuccessModal): ?>
        <script src="../assets/js/editBuku.js"></script>
    <?php endif; ?>

</body>

</html>