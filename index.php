<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Md-Finance Tracker | Ultra Edition</title>
    
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css untuk animasi -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        
        :root {
            --bg-body: #eef2f7;
            --glass: rgba(255, 255, 255, 0.7);
        }

        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }

        /* Efek Kaca (Glassmorphism) */
        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .navbar {
            background: rgba(0, 0, 0, 0.2) !important;
            backdrop-filter: blur(5px);
        }

        /* Animasi Hover Tabel */
        .table tbody tr {
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.01);
            cursor: default;
        }

        .btn-primary {
            background: linear-gradient(45deg, #0575E6, #021B79);
            border: none;
            border-radius: 12px;
        }

        /* Custom badge */
        .badge-income { background: #28a745; color: white; border-radius: 8px; }
        .badge-expense { background: #dc3545; color: white; border-radius: 8px; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold animate__animated animate__fadeInLeft" href="#">
            <i class="fas fa-wallet me-2"></i> MD-FINANCE PRO
        </a>
    </div>
</nav>

<div class="container">
    <div class="row">
        <!-- FORM INPUT -->
        <div class="col-md-4 mb-4 animate__animated animate__fadeInUp">
            <div class="card glass-card p-4">
                <h5 class="fw-bold mb-4 text-center text-primary"><i class="fas fa-plus-circle"></i> Tambah Data</h5>
                <form id="formTransaksi" action="proses.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Transaksi</label>
                        <input type="text" name="nama" class="form-control" placeholder="Misal: Makan Siang" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nominal (Rp)</label>
                        <input type="number" name="nominal" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Jenis</label>
                        <select name="jenis" class="form-select">
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary w-100 py-2 fw-bold shadow">
                        SIMPAN TRANSAKSI
                    </button>
                </form>
            </div>
        </div>

        <!-- TABEL DATA -->
        <div class="col-md-8 animate__animated animate__fadeInRight">
            <div class="card glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0"><i class="fas fa-history text-primary"></i> Riwayat Keuangan</h5>
                    <span class="badge bg-primary px-3 py-2" id="currentDate"></span>
                </div>
                
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-transparent">
                            <tr>
                                <th>Keterangan</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id DESC");
                            if(mysqli_num_rows($query) == 0) {
                                echo "<tr><td colspan='4' class='text-center opacity-50'>Belum ada transaksi</td></tr>";
                            }
                            while($d = mysqli_fetch_array($query)){
                                $isIncome = ($d['jenis'] == 'Pemasukan');
                                $color = $isIncome ? 'text-success' : 'text-danger';
                                $badge = $isIncome ? 'badge-income' : 'badge-expense';
                                $icon = $isIncome ? 'fa-plus' : 'fa-minus';
                            ?>
                            <tr class="animate__animated animate__fadeIn">
                                <td>
                                    <div class="fw-bold"><?= $d['nama_transaksi']; ?></div>
                                    <small class="text-muted"><?= $d['tanggal']; ?></small>
                                </td>
                                <td><span class="badge <?= $badge; ?> p-2 fw-normal"><?= $d['jenis']; ?></span></td>
                                <td class="<?= $color; ?> fw-bold">
                                    <?= $isIncome ? '+' : '-'; ?> Rp <?= number_format($d['nominal'], 0, ',', '.'); ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger btn-hapus" data-id="<?= $d['id']; ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
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

<!-- JS: jQuery & SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Tampilkan Tanggal Hari Ini
    document.getElementById('currentDate').innerText = new Date().toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });

    // Animasi Klik Tombol Hapus (SweetAlert2)
    $('.btn-hapus').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        
        Swal.fire({
            title: 'Hapus data ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `hapus.php?id=${id}`;
            }
        })
    });

    // Cek parameter sukses dari URL (jika ada)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status') && urlParams.get('status') === 'sukses') {
        Swal.fire({
            icon: 'success',
            title: 'Mantap King!',
            text: 'Data berhasil disimpan!',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>
</body>
</html>
