<?php
include 'koneksi.php';

$conn = connect_db();

$tanggal = $_POST['tanggal'];
$data_bahan_id = $_POST['data_bahan_id'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];

mysqli_query($conn,"
    INSERT INTO Pembelian(Tanggal)
    VALUES('$tanggal')
");

$pembelian_id = mysqli_insert_id($conn);

mysqli_query($conn,"
    INSERT INTO Detail_Pembelian(
        Jumlah,
        Harga,
        Data_Bahan_ID,
        Pembelian_ID
    )
    VALUES(
        '$jumlah',
        '$harga',
        '$data_bahan_id',
        '$pembelian_id'
    )
");

mysqli_query($conn,"
    UPDATE Data_Bahan
    SET Stock = Stock + $jumlah
    WHERE Data_Bahan_ID = $data_bahan_id
");

header("Location: index.php#pembelian");
exit;
?>