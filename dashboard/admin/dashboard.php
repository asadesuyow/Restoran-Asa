<?php  
$date = date('d-m-Y');

$total_bayar = mysqli_query($kon, "SELECT SUM(totbar_transaksi) AS totbar FROM tb_transaksi WHERE aTanggal_transaksi = '$date' ");
$total = mysqli_fetch_assoc($total_bayar);
$sudahbayar = mysqli_query($kon, "SELECT COUNT(*) AS sudah_bayar FROM tb_order WHERE status_order = '1' AND aTanggal_order = '$date' ");
$sudah = mysqli_fetch_assoc($sudahbayar);
$belumbayar = mysqli_query($kon, "SELECT COUNT(*) AS belum_bayar FROM tb_order WHERE status_order = '0' AND aTanggal_order = '$date' ");
$belum = mysqli_fetch_assoc($belumbayar);
$jumlahmakanan = mysqli_query($kon, "SELECT COUNT(*) AS makanan FROM tb_masakan ");
$makanan = mysqli_fetch_assoc($jumlahmakanan);
$jumlahpembayaran = mysqli_query($kon, "SELECT COUNT(*) AS pembayaran FROM tb_user WHERE id_level='5' ");
$pembayaran = mysqli_fetch_assoc($jumlahpembayaran);
$jumlahwaiter = mysqli_query($kon, "SELECT COUNT(*) AS waiter FROM tb_user WHERE id_level='2' ");
$waiter = mysqli_fetch_assoc($jumlahwaiter);
$jumlahkasir = mysqli_query($kon, "SELECT COUNT(*) AS kasir FROM tb_user WHERE id_level='3' ");
$kasir = mysqli_fetch_assoc($jumlahkasir);
?>

<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid mt-4">
    <!-- Welcome Card -->
    <div class="card bg-gradient-primary text-white shadow-lg mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="avatar avatar-xl rounded-circle bg-white p-2">
                        <i class="fas fa-user-circle fa-3x text-primary"></i>
                    </div>
                </div>
                <div class="col">
                    <h4 class="mb-1">Selamat Datang, <?= $_SESSION['nama_user'] ?></h4>
                    <p class="mb-0"><?= $_SESSION['level'] ?> Dashboard</p>
                </div>
                <div class="col-auto">
                    <span class="badge bg-white text-primary"><?= $date ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Total Sales Today -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-muted mb-2">Total Penjualan Hari Ini</h6>
                            <h4 class="mb-0">Rp. <?= rupiah($total['totbar']) ?></h4>
                        </div>
                        <div class="col-auto">
                            <div class="bg-success text-white rounded-circle p-3">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between">
                            <span class="badge bg-success"><?= $sudah['sudah_bayar'] ?> Sudah Bayar</span>
                            <span class="badge bg-danger"><?= $belum['belum_bayar'] ?> Belum Bayar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-muted mb-2">Total Menu</h6>
                            <h4 class="mb-0"><?= $makanan['makanan'] ?> Items</h4>
                        </div>
                        <div class="col-auto">
                            <div class="bg-warning text-white rounded-circle p-3">
                                <i class="fas fa-utensils fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Count -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-muted mb-2">Total Staff</h6>
                            <h4 class="mb-0"><?= $waiter['waiter'] + $kasir['kasir'] ?> Staff</h4>
                        </div>
                        <div class="col-auto">
                            <div class="bg-info text-white rounded-circle p-3">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small">
                            <span>Waiter: <?= $waiter['waiter'] ?></span>
                            <span>Kasir: <?= $kasir['kasir'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="index.php?order" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>New Order
                        </a>
                        <a href="index.php?laporan" class="btn btn-sm btn-info">
                            <i class="fas fa-chart-bar me-2"></i>View Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Sales',
            data: [12, 19, 3, 5, 2, 3],
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Order Status Chart
const orderCtx = document.getElementById('orderChart').getContext('2d');
new Chart(orderCtx, {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'Pending'],
        datasets: [{
            data: [<?= $sudah['sudah_bayar'] ?>, <?= $belum['belum_bayar'] ?>],
            backgroundColor: ['#198754', '#ffc107']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
}
.card {
    border: none;
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.progress {
    border-radius: 10px;
}
.rounded-circle {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>