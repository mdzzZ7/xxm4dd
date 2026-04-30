<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    $nama    = $_POST['nama'];
    $nominal = $_POST['nominal'];
    $jenis   = $_POST['jenis'];
    $tanggal = date('Y-m-d');

   
$simpan = mysqli_query($conn, "INSERT INTO transaksi (nama_transaksi, nominal, jenis, tanggal, kategori) 
                               VALUES ('$nama', '$nominal', '$jenis', '$tanggal', 'Umum')");

    if($simpan){
        header("location:index.php?status=sukses");
    } else {
        echo "Gagal Mang: " . mysqli_error($conn);
    }
}
?>