<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Md-Finance Tracker | Tugas Koding</title>
    <!-- CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(45deg, #0d6efd, #0dcaf0); }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .btn-custom { border-radius: 10px; transition: 0.3s; }
        .btn-custom:hover { transform: translateY(-2px); }
    </style>
</head>
<body>

<nav class="navbar navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="fas fa-wallet me-2"></i> MD-FINANCE</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <!-- FORM INPUT -->
        <div class="col-md-4 mb-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Catat Transaksi</h5>
                <form action="proses.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small">Nama Transaksi</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Beli Kopi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Nominal (Rp)</label>
                        <input type="number" name="nominal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Jenis</label>
                        <select name="jenis" class="form-select">
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary w-100 btn-custom fw-bold">SIMPAN DATA</button>
                </form>
            </div>
        </div>

        <!-- TABEL DATA -->
        <div class="col-md-8">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Riwayat Keuangan</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Nominal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id DESC");
                            while($d = mysqli_fetch_array($query)){
                                $warna = ($d['jenis'] == 'Pemasukan') ? 'text-success' : 'text-danger';
                                $icon = ($d['jenis'] == 'Pemasukan') ? 'fa-arrow-up' : 'fa-arrow-down';
                            ?>
                            <tr>
                                <td class="fw-bold"><?= $d['nama_transaksi']; ?></td>
                                <td class="<?= $warna; ?>"><i class="fas <?= $icon; ?> me-1"></i> <?= $d['jenis']; ?></td>
                                <td>Rp <?= number_format($d['nominal'], 0, ',', '.'); ?></td>
                                <td>
                                    <a href="hapus.php?id=<?= $d['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin mau hapus Mang?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>