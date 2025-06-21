<?php
//include koneksi database
include 'includes/koneksi.php';
//ambil data buku
$query = "SELECT * FROM buku ORDER BY judul ASC";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

// Hitung total buku
$total_buku = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/landingPage.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="bi bi-book-half me-3"></i>
                        Perpustakaan Digital
                    </h1>
                    <p class="lead mb-0">Jelajahi koleksi buku terlengkap untuk menambah wawasan Anda</p>
                </div>
                <div class="col-lg-4 text-end">
                    <div class="d-inline-block bg-white bg-opacity-20 rounded-pill px-4 py-2 text-dark">
                        <i class="bi bi-collection me-2"></i>
                        <strong><?php echo $total_buku; ?></strong> Buku Tersedia
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <div class="card stats-card bg-primary text-white h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <i class="bi bi-books display-4 mb-3"></i>
                        <h3 class="card-title"><?php echo $total_buku; ?></h3>
                        <p class="card-text">Total Buku</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stats-card bg-success text-white h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <i class="bi bi-check-circle display-4 mb-3"></i>
                        <h3 class="card-title">
                            <?php
                            // Hitung buku yang tersedia (stok > 0)
                            mysqli_data_seek($result, 0);
                            $available = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['stok'] > 0)
                                    $available++;
                            }
                            echo $available;
                            ?>
                        </h3>
                        <p class="card-text">Buku Tersedia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stats-card bg-warning text-white h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <i class="bi bi-exclamation-triangle display-4 mb-3"></i>
                        <h3 class="card-title"><?php echo $total_buku - $available; ?></h3>
                        <p class="card-text">Stok Habis</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control search-box border-start-0"
                        placeholder="Cari judul buku, pengarang, atau tahun...">
                </div>
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-custom flex-fill" onclick="filterBooks('all')">
                        <i class="bi bi-list-ul me-1"></i> Semua
                    </button>
                    <button class="btn btn-outline-success btn-custom flex-fill" onclick="filterBooks('available')">
                        <i class="bi bi-check-circle me-1"></i> Tersedia
                    </button>
                    <button class="btn btn-outline-warning btn-custom flex-fill" onclick="filterBooks('unavailable')">
                        <i class="bi bi-x-circle me-1"></i> Habis
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div id="buku" class="card book-table border-0">
            <div class="card-header bg-white border-bottom py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0 text-dark">
                            <i class="bi bi-table text-primary me-2"></i>
                            Daftar Buku
                        </h5>
                    </div>
                    <div class="col-auto">
                        <a href="pages/tambahBuku.php" class="btn btn-primary btn-custom">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Buku
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <?php
                mysqli_data_seek($result, 0); // Reset pointer
                if ($total_buku > 0):
                    ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="bookTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="px-4">
                                        <i class="bi bi-hash me-1"></i> ID
                                    </th>
                                    <th scope="col">
                                        <i class="bi bi-book me-1"></i> Judul Buku
                                    </th>
                                    <th scope="col">
                                        <i class="bi bi-person me-1"></i> Pengarang
                                    </th>
                                    <th scope="col">
                                        <i class="bi bi-calendar me-1"></i> Tahun
                                    </th>
                                    <th scope="col" class="text-center">
                                        <i class="bi bi-box me-1"></i> Stok
                                    </th>
                                    <th scope="col" class="text-center">
                                        <i class="bi bi-gear me-1"></i> Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr class="book-row" data-stock="<?php echo $row['stok']; ?>">
                                        <td class="px-4">
                                            <span class="badge bg-light text-dark border">
                                                #<?php echo htmlspecialchars($row['id_buku']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">
                                                <?php echo htmlspecialchars($row['judul']); ?>
                                            </div>
                                        </td>
                                        <td class="text-muted">
                                            <?php echo htmlspecialchars($row['pengarang']); ?>
                                        </td>
                                        <td class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            <?php echo htmlspecialchars($row['tahun_terbit']); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['stok'] > 0): ?>
                                                <span class="badge badge-stock bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    <?php echo htmlspecialchars($row['stok']); ?> tersedia
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-stock bg-danger">
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Habis
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="pages/editBuku.php?id=<?php echo $row['id_buku']; ?>"
                                                    class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button class="btn btn-outline-danger" title="Hapus"
                                                    onclick="confirmDelete(<?php echo $row['id_buku']; ?>, '<?php echo htmlspecialchars($row['judul']); ?>')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h4 class="mt-3">Belum Ada Buku</h4>
                        <p class="mb-4">Koleksi buku masih kosong. Mulai tambahkan buku pertama Anda.</p>
                        <a href="pages/tambahBuku.php" class="btn btn-primary btn-custom">
                            <i class="bi bi-plus-lg me-2"></i>
                            Tambah Buku Pertama
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- tentang section -->
    <section id="tentang" class="bg-light py-5 mt-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h2 class="display-5 fw-bold text-primary mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            About Perpustakaan Digital
                        </h2>
                        <div class="border-bottom border-primary mx-auto" style="width: 100px; height: 3px;"></div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <p class="lead text-muted text-center mb-4">
                                Perpustakaan Digital adalah platform yang memudahkan Anda mengelola koleksi buku secara
                                efisien.
                                Dengan fitur pencarian dan filter yang canggih, Anda dapat dengan mudah menemukan buku
                                yang Anda butuhkan.
                            </p>

                            <div class="row g-4 mt-4">
                                <div class="col-md-4 text-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 80px; height: 80px;">
                                        <i class="bi bi-search text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="fw-semibold">Pencarian Mudah</h5>
                                    <p class="text-muted small">Cari buku berdasarkan judul, pengarang, atau tahun
                                        terbit dengan mudah</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 80px; height: 80px;">
                                        <i class="bi bi-funnel text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="fw-semibold">Filter Canggih</h5>
                                    <p class="text-muted small">Filter buku berdasarkan ketersediaan stok untuk
                                        kemudahan akses</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 80px; height: 80px;">
                                        <i class="bi bi-gear text-warning" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="fw-semibold">Kelola Efisien</h5>
                                    <p class="text-muted small">Tambah, edit, dan hapus buku dengan antarmuka yang
                                        user-friendly</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus buku:</p>
                    <div class="alert alert-warning">
                        <strong id="bookTitle"></strong>
                    </div>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="bi bi-trash me-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php
    require_once 'includes/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/landingPage.js"></script>
    <script src="assets/js/deleteBuku.js"></script>
</body>

</html>