<?php  

if (isset($_GET['meja'])) {
    $query_order = mysqli_query($kon, "SELECT * FROM tb_order WHERE meja_order = '$_GET[meja]' ORDER BY id_order DESC");
    $order = mysqli_fetch_assoc($query_order);
    $detail_order = mysqli_query($kon, "SELECT * FROM tb_detail_order WHERE id_order = '$order[id_order]'");
}

$member = mysqli_query($kon, "SELECT * FROM tb_user WHERE id_level = 5");

?>
<div class="container mt-3">
    <?php if (isset($_SESSION['pesan'])) : ?>
        <?= $_SESSION['pesan'] ?>
    <?php unset($_SESSION['pesan']); endif; ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Entri Transaksi</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php?dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Transaksi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Order Details -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <!-- Order Info Card -->
            <?php if (isset($_GET['meja'])): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <div class="icon-circle bg-primary text-white">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">No Order</h6>
                                    <div class="fw-bold fs-5">#<?= $order['id_order'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <div class="icon-circle bg-info text-white">
                                        <i class="fas fa-chair"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">No Meja</h6>
                                    <div class="fw-bold fs-5"><?= $order['meja_order'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <div class="icon-circle bg-success text-white">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Tanggal Pesan</h6>
                                    <div class="fw-bold"><?= date('d-m-Y', $order['tanggal_order']) ?></div>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($order['keterangan_order'])): ?>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="icon-circle bg-warning text-white">
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Keterangan</h6>
                                    <div class="text-truncate"><?= $order['keterangan_order'] ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Order Items Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex align-items-center py-3">
                    <i class="fas fa-utensils me-2 text-primary"></i>
                    <h5 class="card-title mb-0">Detail Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabel">
                            <thead>
                                <tr> 
                                    <th>No</th>
                                    <th>Nama Pesanan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <?php if (isset($_GET['meja'])): ?>
                                <tbody>
                                <?php 
                                $i = 1;
                                $grand_total = 0;
                                foreach ($detail_order as $row) :
                                    $query_mas = mysqli_query($kon, "SELECT * FROM tb_masakan WHERE id_masakan = '$row[id_masakan]'");
                                    $masakan = mysqli_fetch_assoc($query_mas);
                                    $item_total = $masakan['harga_masakan'] * $row['jumlah_dorder'];
                                    $grand_total += $item_total;
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="menu-thumb me-2">
                                                    <img src="assets/image/makanan/<?= $masakan['foto'] ?>" alt="<?= $masakan['nama_masakan'] ?>" class="rounded">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= $masakan['nama_masakan'] ?></h6>
                                                    <?php if (!empty($row['keterangan_dorder'])): ?>
                                                    <small class="text-muted"><?= $row['keterangan_dorder'] ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info"><?= $row['jumlah_dorder'] ?></span>
                                        </td>
                                        <td>Rp <?= number_format($masakan['harga_masakan']) ?></td>
                                        <td><span class="fw-bold">Rp <?= number_format($item_total) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-group-divider">
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Grand Total:</td>
                                        <td class="fw-bold fs-5 text-primary">Rp <?= number_format($grand_total) ?></td>
                                    </tr>
                                </tfoot>
                            <?php else : ?>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                                                <h6 class="mb-1">Silahkan pilih meja terlebih dahulu</h6>
                                                <p class="text-muted small">Pilih meja pada form di sebelah kanan</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Payment Form -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex align-items-center py-3">
                    <i class="fas fa-money-bill-wave me-2 text-success"></i>
                    <h5 class="card-title mb-0">Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="fungsi/prosesTransaksi.php" method="POST">
                        <?php $kursi = mysqli_query($kon, "SELECT * FROM tb_meja WHERE status != 0"); ?>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">No Meja</label>
                            <select class="form-select" onchange='location=this.value' required>
                                <option selected disabled>-- Pilih Meja --</option>
                                <?php if (isset($_GET['meja'])) : ?>
                                    <?php foreach ($kursi as $kurs) : ?>
                                        <option value="index.php?meja=<?= $kurs['meja_id'] ?>" <?= $kurs['meja_id'] == $_GET['meja'] ? 'selected' : '' ?>><?= $kurs['meja_id'] ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?php foreach ($kursi as $kurs) : ?>
                                        <option value="index.php?meja=<?= $kurs['meja_id'] ?>"><?= $kurs['meja_id'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <?php
                        if (isset($_GET['meja'])) {
                            $q_hartot = mysqli_query($kon, "SELECT sum(hartot_dorder) as hartot FROM tb_detail_order WHERE id_order = '$order[id_order]'");
                            $hartot = mysqli_fetch_assoc($q_hartot);
                            $toto = $hartot['hartot'];
                            $id_order = $order['id_order'];
                            $meja_url = $_GET['meja'];
                        } else {
                            $meja_url = '';
                            $toto = '';
                            $id_order = '';
                        }
                        ?>
                        <input type="hidden" name="meja" value="<?= $meja_url ?>">
                        <input type="hidden" name="id_order" value="<?= $id_order ?>">

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Total Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" name="total_harga" readonly required value="<?= $toto ?>" class="form-control hartot" placeholder="Total Harga">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Diskon (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control diskon" min="0" max="100" name="diskon" value="0" placeholder="Diskon">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Total Bayar</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" readonly class="form-control totbayar" required value="<?= $toto ?>" name="total_bayar" placeholder="Total Bayar">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-bold">Uang Diterima</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" min="1" class="form-control uang" required name="uang" placeholder="Uang">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Kembalian</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" readonly class="form-control kembalian" required name="kembalian" placeholder="Kembalian">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-cash-register me-2"></i>
                            Proses Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
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

.card-header {
    border-bottom-width: 1px;
}

.badge {
    padding: 0.5em 0.75em;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.form-label {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.input-group-text {
    background-color: #f8f9fa;
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

.d-flex.align-items-center .flex-grow-1 {
    margin-left: 1rem !important;
}

.table-group-divider {
    border-top: 2px solid #dee2e6;
}
</style>

<script>
// Keep the existing JavaScript but with better formatting
document.addEventListener('DOMContentLoaded', function() {
    // Calculate the total after discount
    const diskon = document.querySelector('.diskon');
    const hartot = document.querySelector('.hartot');
    const totbayar = document.querySelector('.totbayar');
    
    if (diskon && hartot && totbayar) {
        diskon.addEventListener('input', function() {
            const diskonValue = parseInt(this.value) || 0;
            const hartotValue = parseInt(hartot.value) || 0;
            const discount = (hartotValue * diskonValue) / 100;
            const total = hartotValue - discount;
            totbayar.value = total;
        });
    }
    
    // Calculate the change
    const uang = document.querySelector('.uang');
    const kembalian = document.querySelector('.kembalian');
    
    if (uang && kembalian && totbayar) {
        uang.addEventListener('input', function() {
            const uangValue = parseInt(this.value) || 0;
            const totbayarValue = parseInt(totbayar.value) || 0;
            const change = uangValue - totbayarValue;
            kembalian.value = change;
        });
    }
});
</script>

