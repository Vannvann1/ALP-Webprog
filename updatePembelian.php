<?php
include 'koneksi.php';

$conn = connect_db();

$id = $_POST['id'];
$jumlah_baru = $_POST['jumlah'];
$harga = $_POST['harga'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT *
    FROM Detail_Pembelian
    WHERE Pembelian_ID = $id
"));

$jumlah_lama = $data['Jumlah'];
$data_bahan_id = $data['Data_Bahan_ID'];

$selisih = $jumlah_baru - $jumlah_lama;

mysqli_query($conn,"
    UPDATE Detail_Pembelian
    SET
        Jumlah = '$jumlah_baru',
        Harga = '$harga'
    WHERE Pembelian_ID = $id
");

mysqli_query($conn,"
    UPDATE Data_Bahan
    SET Stock = Stock + $selisih
    WHERE Data_Bahan_ID = $data_bahan_id
");

header("Location: index.php#pembelian");
exit;
?>