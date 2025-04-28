<div class="container mt-3">
    <?php if (isset($_SESSION['pesan'])) : ?>
        <?= $_SESSION['pesan'] ?>
    <?php unset($_SESSION['pesan']); endif; ?>
    
    <!-- Hero Section -->
    <div class="card mb-4 rounded-lg shadow-sm overflow-hidden border-0">
        <div class="hero-container">
            <img src="assets/image/banner1.png" class="card-img-top hero-image" alt="Restaurant Banner">
            <div class="hero-overlay">
                <div class="hero-content text-white p-4">
                    <h2 class="display-4 fw-bold">Asa</h2>
                    <h3 class="mb-3">Restoran Asa</h3>
                    <p class="lead">Nikmati cita rasa berbagai macam hidangan olahan ayam</p>
                    <button class="btn btn-light btn-lg mt-2" data-toggle="modal" data-target="#aboutModal">
                        <i class="fas fa-info-circle me-2"></i>Tentang Kami
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Tabs -->
    <ul class="nav nav-tabs mb-4" id="menuTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="food-tab" data-toggle="tab" data-target="#food" data-bs-toggle="tab" data-bs-target="#food" type="button" role="tab" aria-controls="food" aria-selected="true">
                <i class="fas fa-utensils me-2"></i>Makanan
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="drink-tab" data-toggle="tab" data-target="#drink" data-bs-toggle="tab" data-bs-target="#drink" type="button" role="tab" aria-controls="drink" aria-selected="false">
                <i class="fas fa-glass-martini-alt me-2"></i>Minuman
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="menuTabsContent">
        <!-- Food Tab -->
        <div class="tab-pane fade show active" id="food" role="tabpanel" aria-labelledby="food-tab">
            <div class="row g-4">
                <!-- mengambil data dari database -->
                <?php
                    $query = "SELECT * FROM tb_masakan WHERE kategori_masakan='Makanan' ORDER BY id_masakan LIMIT 30";
                    $sql = mysqli_query($kon, $query);
                    while($data = mysqli_fetch_array($sql)) :
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="menu-card card h-100 shadow-sm border-0 rounded-lg">
                        <div class="menu-image-wrapper">
                            <img class="card-img-top menu-image" src="assets/image/makanan/<?= $data['foto'] ?>" alt="<?= $data['nama_masakan'] ?>">
                            <?php if ($data['status_masakan']==1): ?>
                                <span class="menu-badge badge bg-success">Tersedia</span>
                            <?php else: ?>
                                <span class="menu-badge badge bg-danger">Tidak Tersedia</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate"><?= $data['nama_masakan'] ?></h5>
                            <?php
                                $harga = $data['harga_masakan'];
                                if ($_SESSION['level']=="") {
                                    $harga = $data['harga_masakan']+5000;
                                }
                            ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fs-5 fw-bold text-primary">Rp <?= number_format($harga) ?></span>
                            </div>
                            <div class="mt-auto">
                                <?php if ($data['status_masakan']==1): ?>
                                    <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#masakan_<?= $data['id_masakan']; ?>">
                                        <i class="fas fa-shopping-cart me-2"></i>Pesan
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-ban me-2"></i>Tidak Tersedia
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="masakan_<?= $data['id_masakan']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="fungsi/orderMakanan.php" method="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4 mb-md-0">
                                            <div class="modal-image-container rounded overflow-hidden">
                                                <img src="assets/image/makanan/<?= $data['foto'] ?>" alt="<?= $data['nama_masakan'] ?>" class="img-fluid modal-menu-image">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" name="id_masakan" value="<?= $data['id_masakan'] ?>">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Menu</label>
                                                <input type="text" readonly class="form-control" value="<?= $data['nama_masakan'] ?>">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Harga</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" readonly class="form-control" value="<?= number_format($data['harga_masakan']) ?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jumlah Pesanan</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="decrease">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" class="form-control text-center quantity-input" name="jumlah" value="1" min="1" max="20">
                                                    <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="increase">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Keterangan</label>
                                                <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan khusus untuk pesanan Anda"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Drink Tab -->
        <div class="tab-pane fade" id="drink" role="tabpanel" aria-labelledby="drink-tab">
            <div class="row g-4">
                <?php
                    $query2 = "SELECT * FROM tb_masakan WHERE kategori_masakan='Minuman' ORDER BY id_masakan";
                    $sql2 = mysqli_query($kon, $query2);
                    while($data = mysqli_fetch_array($sql2)) :
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="menu-card card h-100 shadow-sm border-0 rounded-lg">
                        <div class="menu-image-wrapper">
                            <img class="card-img-top menu-image" src="assets/image/makanan/<?= $data['foto'] ?>" alt="<?= $data['nama_masakan'] ?>">
                            <?php if ($data['status_masakan']==1): ?>
                                <span class="menu-badge badge bg-success">Tersedia</span>
                            <?php else: ?>
                                <span class="menu-badge badge bg-danger">Tidak Tersedia</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate"><?= $data['nama_masakan'] ?></h5>
                            <?php 
                                $hargi = $data['harga_masakan'];
                                if ($_SESSION['level']=="") {
                                    $hargi = $data['harga_masakan']+3000;
                                }
                            ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fs-5 fw-bold text-primary">Rp <?= number_format($hargi) ?></span>
                            </div>
                            <div class="mt-auto">
                                <?php if ($data['status_masakan']==1): ?>
                                    <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#masakan_<?= $data['id_masakan']; ?>">
                                        <i class="fas fa-shopping-cart me-2"></i>Pesan
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-ban me-2"></i>Tidak Tersedia
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="masakan_<?= $data['id_masakan']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="fungsi/orderMakanan.php" method="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-4 mb-md-0">
                                            <div class="modal-image-container rounded overflow-hidden">
                                                <img src="assets/image/makanan/<?= $data['foto'] ?>" alt="<?= $data['nama_masakan'] ?>" class="img-fluid modal-menu-image">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" name="id_masakan" value="<?= $data['id_masakan'] ?>">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Menu</label>
                                                <input type="text" readonly class="form-control" value="<?= $data['nama_masakan'] ?>">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Harga</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" readonly class="form-control" value="<?= number_format($data['harga_masakan']) ?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jumlah Pesanan</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="decrease">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" class="form-control text-center quantity-input" name="jumlah" value="1" min="1" max="20">
                                                    <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="increase">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Keterangan</label>
                                                <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan khusus untuk pesanan Anda"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<!-- About Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel">Tentang Restoran Asa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="assets/image/banner1.png" alt="Restaurant" class="img-fluid rounded mb-3">
                    </div>
                    <div class="col-md-6">
                        <h4>Selamat Datang di Restoran Asa</h4>
                        <p>Kami menyajikan berbagai macam hidangan olahan ayam dengan cita rasa yang lezat. Dibangun pada tahun 2025, restoran kami telah melayani ribuan pelanggan dengan kualitas makanan yang terjamin.</p>
                        <p>Semua bahan yang kami gunakan adalah bahan segar dan berkualitas tinggi untuk menjamin kualitas dan rasa dari setiap hidangan kami.</p>
                        <h5>Jam Buka</h5>
                        <ul class="list-unstyled">
                            <li><strong>Senin - Jumat:</strong> 09:00 - 21:00</li>
                            <li><strong>Sabtu - Minggu:</strong> 10:00 - 22:00</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Hero Section */
.hero-container {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.7));
    display: flex;
    align-items: flex-end;
}

.hero-content {
    width: 100%;
}

/* Menu Cards */
.menu-card {
    transition: transform 0.3s, box-shadow 0.3s;
}

.menu-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.menu-image-wrapper {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.menu-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.menu-card:hover .menu-image {
    transform: scale(1.05);
}

.menu-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1;
}

/* Modal Styles */
.modal-image-container {
    height: 350px;
    overflow: hidden;
}

.modal-menu-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Nav Tabs */
.nav-tabs .nav-link {
    color: #495057;
    font-weight: 500;
    padding: 0.75rem 1.25rem;
    border-radius: 0;
    border: none;
    border-bottom: 3px solid transparent;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    background-color: transparent;
    border-bottom: 3px solid #0d6efd;
}

.nav-tabs .nav-link:hover {
    border-color: transparent;
    border-bottom: 3px solid #dee2e6;
}

/* Buttons */
.btn i {
    margin-right: 0.5rem;
}

.quantity-btn {
    min-width: 40px;
}

.quantity-input {
    max-width: 70px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're using Bootstrap 5
    if (typeof bootstrap !== 'undefined') {
        // Bootstrap 5 initialization
        var triggerTabList = [].slice.call(document.querySelectorAll('#menuTabs button'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
    } else {
        // Bootstrap 4 fallback
        $('#menuTabs button').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        
        // Also ensure the tab content is correctly linked for Bootstrap 4
        $('#food-tab').attr('data-toggle', 'tab').attr('data-target', '#food');
        $('#drink-tab').attr('data-toggle', 'tab').attr('data-target', '#drink');
    }
    
    // Quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.closest('.input-group').querySelector('.quantity-input');
            var currentValue = parseInt(input.value);
            
            if (this.dataset.action === 'decrease' && currentValue > 1) {
                input.value = currentValue - 1;
            } else if (this.dataset.action === 'increase' && currentValue < 20) {
                input.value = currentValue + 1;
            }
        });
    });
});
</script>