<div class="container mt-3">
	<?php if (isset($_SESSION['pesan'])) : ?>
        <?= $_SESSION['pesan'] ?>
    <?php unset($_SESSION['pesan']); endif; ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Data Masakan</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php?dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Minuman</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="index.php?makanan" class="btn btn-info text-white">
                <i class="fas fa-utensils me-2"></i>
                Data Makanan
            </a>
            <a href="index.php?minuman" class="btn btn-primary">
                <i class="fas fa-glass-martini-alt me-2"></i>
                Data Minuman
            </a>
            <a href="index.php?tambah_makanan" class="btn btn-success">
                <i class="fas fa-plus-circle me-2"></i>
                Tambah Data
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $total = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_masakan WHERE kategori_masakan='Minuman'"))['count'];
                            ?>
                            <h6 class="mb-0">Total Menu</h6>
                            <div class="fs-4 fw-bold"><?= $total ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $tersedia = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_masakan WHERE kategori_masakan='Minuman' AND status_masakan=1"))['count'];
                            ?>
                            <h6 class="mb-0">Tersedia</h6>
                            <div class="fs-4 fw-bold"><?= $tersedia ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $tidak_tersedia = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_masakan WHERE kategori_masakan='Minuman' AND status_masakan=0"))['count'];
                            ?>
                            <h6 class="mb-0">Tidak Tersedia</h6>
                            <div class="fs-4 fw-bold"><?= $tidak_tersedia ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $result = mysqli_fetch_assoc(mysqli_query($kon, "SELECT MIN(harga_masakan) as min, MAX(harga_masakan) as max FROM tb_masakan WHERE kategori_masakan='Minuman'"));
                            ?>
                            <h6 class="mb-0">Range Harga</h6>
                            <div class="fs-6 fw-bold">Rp <?= number_format($result['min']) ?> - <?= number_format($result['max']) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Table Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql = mysqli_query($kon, "SELECT * FROM tb_masakan WHERE kategori_masakan='Minuman' ORDER BY nama_masakan ASC");
                        while ($data = mysqli_fetch_array($sql)) : 
                            $status_class = $data['status_masakan'] == 1 ? 'success' : 'danger';
                            $status_text = $data['status_masakan'] == 1 ? 'Tersedia' : 'Tidak Tersedia';
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="menu-thumb">
                                            <img src="assets/image/makanan/<?= $data['foto'] ?>" alt="<?= $data['nama_masakan'] ?>" class="rounded">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0"><?= $data['nama_masakan'] ?></h6>
                                    </div>
                                </div>
                            </td>
                            <td>Rp <?= number_format($data['harga_masakan']) ?></td>
                            <td><span class="badge bg-<?= $status_class ?>"><?= $status_text ?></span></td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="index.php?ubah_makanan=<?= $data['id_masakan'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="fungsi/hapusMakanan.php?id_masakan=<?= $data['id_masakan']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Apakah anda yakin ingin menghapus menu ini?')"
                                       title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.menu-thumb {
    width: 48px;
    height: 48px;
    overflow: hidden;
    border-radius: 4px;
}

.menu-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.badge {
    padding: 0.5em 0.75em;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.gap-2 {
    gap: 0.5rem;
}

/* New styles for better icon spacing */
.btn i {
    margin-right: 0.75rem !important;
    font-size: 0.9em;
}

.card-body .fa-2x {
    font-size: 1.75em;
    width: 1.5em;
    text-align: center;
}

.card-body .flex-grow-1 {
    margin-left: 1rem !important;
}

.btn {
    padding-left: 1rem;
    padding-right: 1rem;
}

.btn-sm {
    padding: 0.4rem 0.75rem;
}

.btn-sm i {
    margin-right: 0 !important;
}

.d-flex.align-items-center .flex-grow-1 {
    margin-left: 1rem !important;
}
</style>