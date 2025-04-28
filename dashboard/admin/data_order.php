<div class="container mt-3">
    <?php if (isset($_SESSION['pesan'])) : ?>
        <?= $_SESSION['pesan'] ?>
    <?php unset($_SESSION['pesan']); endif; ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Data Order</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php?dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Order</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="index.php?home" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>
                Entri Order Baru
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
                            $total_order = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_order WHERE status_order = 0"))['count'];
                            ?>
                            <h6 class="mb-0">Total Order</h6>
                            <div class="fs-4 fw-bold"><?= $total_order ?></div>
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
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $total_bayar = mysqli_fetch_assoc(mysqli_query($kon, "SELECT SUM(hartot_dorder) as total FROM tb_detail_order JOIN tb_order ON tb_detail_order.id_order = tb_order.id_order WHERE tb_order.status_order = 0"))['total'] ?? 0;
                            ?>
                            <h6 class="mb-0">Total Pendapatan</h6>
                            <div class="fs-6 fw-bold">Rp <?= number_format($total_bayar) ?></div>
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
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $today_orders = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_order WHERE DATE(FROM_UNIXTIME(tanggal_order)) = CURDATE() AND status_order = 0"))['count'];
                            ?>
                            <h6 class="mb-0">Order Hari Ini</h6>
                            <div class="fs-4 fw-bold"><?= $today_orders ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $total_users = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(DISTINCT id_user) as count FROM tb_order WHERE status_order = 0"))['count'];
                            ?>
                            <h6 class="mb-0">Total Pelayan</h6>
                            <div class="fs-4 fw-bold"><?= $total_users ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Table Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Order</th>
                            <th>No Meja</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i = 1;
                    $order = mysqli_query($kon, "SELECT * FROM tb_order WHERE status_order = 0 ORDER BY id_order DESC");
                    foreach ($order as $orders) :
                        $user_query = mysqli_query($kon, "SELECT * FROM tb_user WHERE id_user = '$orders[id_user]'");
                        $user = mysqli_fetch_assoc($user_query);
                        $query_hartot = mysqli_query($kon, "SELECT SUM(hartot_dorder) as hartot FROM tb_detail_order WHERE id_order = '$orders[id_order]'");
                        $hartot = mysqli_fetch_assoc($query_hartot);
                    ?>  
                        <tr>
                            <td><?= $i++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="order-badge">
                                            <i class="fas fa-receipt"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">#<?= $orders['id_order'] ?></h6>
                                        <small class="text-muted"><?= $user['nama_user'] ?? 'Unknown' ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-info"><?= $orders['meja_order'] ?></span></td>
                            <td><?= date('d-m-Y H:i', $orders['tanggal_order']) ?></td>
                            <td><span class="fw-bold">Rp <?= number_format($hartot['hartot']) ?></span></td>
                            <td>
                                <?php if (!empty($orders['keterangan_order'])) : ?>
                                    <span class="badge bg-warning" title="<?= $orders['keterangan_order'] ?>">
                                        <i class="fas fa-comment-dots me-1"></i>
                                        Catatan
                                    </span>
                                <?php else : ?>
                                    <span class="badge bg-success">Standard</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" title="Detail Order" class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#detailOrder_<?= $orders['id_order'] ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php if ($orders['order_status'] == 1) : ?>
                                        <a href="print_struk.php?id_order=<?= $orders['id_order'] ?>" target="_blank" class="btn btn-warning text-white btn-sm" title="Print Struk">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="fungsi/hapusPesan.php?id=<?= $orders['id_order'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
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

<!-- Modal Detail Order -->
<?php 
$order = mysqli_query($kon, "SELECT * FROM tb_order WHERE status_order = 0 ORDER BY id_order DESC");
foreach ($order as $detRow) : 
?>
<div class="modal fade" id="detailOrder_<?= $detRow['id_order'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailOrderLabel_<?= $detRow['id_order'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="detailOrderLabel_<?= $detRow['id_order'] ?>">
            <i class="fas fa-receipt me-2"></i>
            Detail Order #<?= $detRow['id_order'] ?>
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
            $detail_order = mysqli_query($kon, "SELECT * FROM tb_detail_order WHERE id_order = '$detRow[id_order]'");
            $query_hartot = mysqli_query($kon, "SELECT sum(hartot_dorder) as hartot FROM tb_detail_order WHERE id_order = '$detRow[id_order]'");
            $hartot = mysqli_fetch_assoc($query_hartot);
            $user_query = mysqli_query($kon, "SELECT * FROM tb_user WHERE id_user = '$detRow[id_user]'");
            $user = mysqli_fetch_assoc($user_query);
        ?>
        
        <!-- Order info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="mb-2">
                    <strong>Tanggal Order:</strong>
                    <span class="ms-2"><?= date('d-m-Y H:i', $detRow['tanggal_order']) ?></span>
                </div>
                <div class="mb-2">
                    <strong>No Meja:</strong>
                    <span class="ms-2"><?= $detRow['meja_order'] ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-2">
                    <strong>Pelayan:</strong>
                    <span class="ms-2"><?= $user['nama_user'] ?? 'Unknown' ?></span>
                </div>
                <?php if (!empty($detRow['keterangan_order'])) : ?>
                <div class="mb-2">
                    <strong>Catatan:</strong>
                    <div class="alert alert-warning py-2 px-3 mt-1 mb-0">
                        <?= $detRow['keterangan_order'] ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Order items table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    foreach ($detail_order as $list_row) :
                        $masakan = mysqli_query($kon, "SELECT * FROM tb_masakan WHERE id_masakan = '$list_row[id_masakan]' ");
                        $query_masakan = mysqli_fetch_assoc($masakan);
                    ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="menu-thumb me-2">
                                    <img src="assets/image/makanan/<?= $query_masakan['foto'] ?>" alt="<?= $query_masakan['nama_masakan'] ?>" class="rounded">
                                </div>
                                <?= $query_masakan['nama_masakan'] ?>
                            </div>
                        </td>
                        <td><?= !empty($list_row['keterangan_dorder']) ? $list_row['keterangan_dorder'] : '-' ?></td>
                        <td>Rp <?= number_format($query_masakan['harga_masakan']) ?></td>
                        <td class="text-center"><?= $list_row['jumlah_dorder'] ?></td>
                        <td>Rp <?= number_format($query_masakan['harga_masakan'] * $list_row['jumlah_dorder']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="5" class="text-end"><strong>Total :</strong></td>
                        <td><strong>Rp <?= number_format($hartot['hartot']) ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <?php if ($detRow['order_status'] == 1) : ?>
            <a href="print_struk.php?id_order=<?= $detRow['id_order'] ?>" target="_blank" class="btn btn-warning text-white">
                <i class="fas fa-print me-2"></i>Print Struk
            </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<style>
.order-badge {
    width: 40px;
    height: 40px;
    background-color: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 1.2rem;
}

.menu-thumb {
    width: 40px;
    height: 40px;
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

/* Icon spacing */
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

/* Modal styles */
.modal-header {
    padding: 0.75rem 1.25rem;
}

.modal-header .close {
    background: transparent;
    border: none;
    opacity: 0.8;
    font-size: 1.5rem;
    padding: 0;
    margin: 0;
}

.modal-header .close:hover {
    opacity: 1;
}
</style>