<div class="container mt-3">
	<?php if (isset($_SESSION['pesan'])) : ?>
        <?= $_SESSION['pesan'] ?>
    <?php unset($_SESSION['pesan']); endif; ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Data User</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php?dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data User</li>
                </ol>
            </nav>
        </div>
        <?php if ($_SESSION['level'] == "Admin"): ?>
        <a href="index.php?registrasi" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>
            Tambah User Baru
        </a>
        <?php endif ?>
    </div>

    <!-- User Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users-cog fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $admin_count = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_user WHERE id_level = 1"))['count'];
                            ?>
                            <h6 class="mb-0">Admin</h6>
                            <div class="fs-4 fw-bold"><?= $admin_count ?></div>
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
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $waiter_count = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_user WHERE id_level = 2"))['count'];
                            ?>
                            <h6 class="mb-0">Waiter</h6>
                            <div class="fs-4 fw-bold"><?= $waiter_count ?></div>
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
                            <i class="fas fa-cash-register fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $kasir_count = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_user WHERE id_level = 3"))['count'];
                            ?>
                            <h6 class="mb-0">Kasir</h6>
                            <div class="fs-4 fw-bold"><?= $kasir_count ?></div>
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
                            <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <?php
                            $owner_count = mysqli_fetch_assoc(mysqli_query($kon, "SELECT COUNT(*) as count FROM tb_user WHERE id_level = 4"))['count'];
                            ?>
                            <h6 class="mb-0">Owner</h6>
                            <div class="fs-4 fw-bold"><?= $owner_count ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Table Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Status</th>
                            <?php if ($_SESSION['level'] == "Admin"): ?>
                                <th class="text-end">Aksi</th>    
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql = mysqli_query($kon, "SELECT * FROM tb_user ORDER BY id_level ASC");
                        while ($data = mysqli_fetch_array($sql)) : 
                            $level_labels = [
                                1 => ['Admin', 'primary'],
                                2 => ['Waiter', 'success'],
                                3 => ['Kasir', 'info'],
                                4 => ['Owner', 'warning'],
                                5 => ['Pembelian', 'secondary']
                            ];
                            $level_info = $level_labels[$data['id_level']] ?? ['User', 'secondary'];
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-sm bg-light rounded-circle">
                                            <span class="avatar-initials"><?= strtoupper(substr($data['nama_user'], 0, 1)) ?></span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0"><?= $data['nama_user'] ?></h6>
                                    </div>
                                </div>
                            </td>
                            <td><?= $data['username'] ?></td>
                            <td><span class="badge bg-<?= $level_info[1] ?>"><?= $level_info[0] ?></span></td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <?php if ($_SESSION['level'] == "Admin"): ?>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="index.php?ubah_user=<?= $data['id_user'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="fungsi/hapusUser.php?id_user=<?= $data['id_user']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Apakah anda yakin ingin menghapus user ini?')"
                                       title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.avatar {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-initials {
    font-size: 14px;
    font-weight: 600;
    color: #666;
}

.badge {
    padding: 0.5em 0.75em;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

.gap-2 {
    gap: 0.5rem;
}
</style>