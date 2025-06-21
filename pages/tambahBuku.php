<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../includes/koneksi.php';
include_once '../includes/header.php';

// Check if add was successful
$showSuccessModal = isset($_SESSION['tambah_success']) && $_SESSION['tambah_success'] === true;
$showErrorModal = isset($_SESSION['tambah_error']);
$errorMessage = '';
$newBookId = '';

if ($showSuccessModal) {
    $newBookId = isset($_SESSION['new_book_id']) ? $_SESSION['new_book_id'] : '';
    unset($_SESSION['tambah_success']);
    unset($_SESSION['new_book_id']);
}

if ($showErrorModal) {
    $errorMessage = $_SESSION['tambah_error'];
    unset($_SESSION['tambah_error']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Buku Baru</h3>
                    </div>
                    <div class="card-body">
                        <form action="../process/tambahBuku.php" method="POST" id="tambahBukuForm">
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-book me-2"></i>Judul Buku</label>
                                <input type="text" class="form-control" name="judul" placeholder="Masukkan judul buku"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-user-edit me-2"></i>Pengarang</label>
                                <input type="text" class="form-control" name="pengarang"
                                    placeholder="Masukkan nama pengarang" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-building me-2"></i>Penerbit</label>
                                <input type="text" class="form-control" name="penerbit"
                                    placeholder="Masukkan nama penerbit" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-calendar me-2"></i>Tahun Terbit</label>
                                <input type="number" class="form-control" name="tahun_terbit" min="1900"
                                    max="<?php echo date('Y'); ?>" placeholder="Contoh: <?php echo date('Y'); ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-boxes me-2"></i>Stok</label>
                                <input type="number" class="form-control" name="stok" min="0"
                                    placeholder="Masukkan jumlah stok" required>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="../index.php" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" name="tambah" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Buku
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">
                        <i class="fas fa-check-circle me-2"></i>Berhasil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Buku berhasil ditambahkan!</h4>
                        <?php if ($newBookId): ?>
                            <p class="text-muted">ID Buku: <strong><?php echo $newBookId; ?></strong></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="window.location.href='../index.php'">
                        <i class="fas fa-home me-2"></i>Kembali ke Daftar Buku
                    </button>
                    <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                        <i class="fas fa-plus me-2"></i>Tambah Buku Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Error
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Gagal menambahkan buku!</h4>
                        <p class="text-muted"><?php echo htmlspecialchars($errorMessage); ?></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Show Success Modal -->
    <?php if ($showSuccessModal): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            });
        </script>
    <?php endif; ?>

    <!-- Show Error Modal -->
    <?php if ($showErrorModal): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    <?php endif; ?>

    <!-- Form Validation -->
    <script>
        document.getElementById('tambahBukuForm').addEventListener('submit', function (e) {
            var tahunTerbit = document.getElementsByName('tahun_terbit')[0].value;
            var currentYear = new Date().getFullYear();

            if (tahunTerbit > currentYear) {
                e.preventDefault();
                alert('Tahun terbit tidak boleh lebih dari tahun sekarang!');
                return false;
            }

            var stok = document.getElementsByName('stok')[0].value;
            if (stok < 0) {
                e.preventDefault();
                alert('Stok tidak boleh bernilai negatif!');
                return false;
            }
        });
    </script>

</body>

</html>