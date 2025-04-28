<div class="container mt-3">
    <?php if (isset($_SESSION['pesan'])) : ?>
        <?= $_SESSION['pesan'] ?>
    <?php unset($_SESSION['pesan']); endif; ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Laporan Transaksi</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php?dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="admin/semua_laporan.php" target="_blank" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>
                Print Semua Laporan
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-receipt fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $total_transaksi = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_transaksi"))['count'];
                            ?>
                            <h6 class="mb-0">Total Transaksi</h6>
                            <div class="fs-4 fw-bold"><?= $total_transaksi ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $total_pendapatan = mysqli_fetch_assoc(mysqli_query($kon, "SELECT SUM(totbar_transaksi) as total FROM tb_transaksi"))['total'] ?? 0;
                            ?>
                            <h6 class="mb-0">Total Pendapatan</h6>
                            <div class="fs-6 fw-bold">Rp <?= number_format($total_pendapatan) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $today = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_transaksi 
                            JOIN tb_order ON tb_transaksi.id_order = tb_order.id_order 
                            WHERE DATE(FROM_UNIXTIME(tb_order.tanggal_order)) = CURDATE()"))['count'];
                            ?>
                            <h6 class="mb-0">Transaksi Hari Ini</h6>
                            <div class="fs-4 fw-bold"><?= $today ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex align-items-center py-3">
            <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>
            <h5 class="card-title mb-0">Riwayat Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order ID</th>
                            <th>Tanggal</th>
                            <th>Meja</th>
                            <th>Subtotal</th>
                            <th>Diskon</th>
                            <th>Total</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i = 1;
                    $transaksi = mysqli_query($kon, "SELECT * FROM tb_transaksi ORDER BY id_transaksi DESC");
                    foreach ($transaksi as $row) :
                        $order_query = mysqli_query($kon, "SELECT * FROM tb_order WHERE id_order = '$row[id_order]'");
                        $oq = mysqli_fetch_assoc($order_query);
                    ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-circle-sm bg-primary text-white">
                                            <i class="fas fa-receipt"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">#<?= $row['id_order'] ?></h6>
                                    </div>
                                </div>
                            </td>
                            <td><?= date('d-m-Y H:i', $oq['tanggal_order']) ?></td>
                            <td><span class="badge bg-info"><?= $oq['meja_order'] ?></span></td>
                            <td>Rp <?= number_format($row['hartot_transaksi']) ?></td>
                            <td>
                                <?php if ($row['diskon_transaksi'] > 0): ?>
                                <span class="badge bg-warning text-dark"><?= $row['diskon_transaksi'] ?>%</span>
                                <?php else: ?>
                                <span class="badge bg-light text-dark">0%</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="fw-bold">Rp <?= number_format($row['totbar_transaksi']) ?></span></td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    <a href="admin/print_struk.php?id_order=<?= $row['id_order'] ?>" target="_blank" class="btn btn-primary btn-sm" title="Print Struk">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle-sm {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.avatar-sm {
    width: 32px;
    height: 32px;
    background-color: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-initials {
    font-size: 14px;
    font-weight: 600;
    color: #495057;
}

.badge {
    padding: 0.5em 0.75em;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

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

.card-header {
    border-bottom-width: 1px;
}

.d-flex.align-items-center .flex-grow-1 {
    margin-left: 1rem !important;
}
</style>
