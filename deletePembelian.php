<?php
include 'koneksi.php';

$conn = connect_db();

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT *
    FROM Detail_Pembelian
    WHERE Pembelian_ID = $id
"));

$jumlah = $data['Jumlah'];
$data_bahan_id = $data['Data_Bahan_ID'];

mysqli_query($conn,"
    UPDATE Data_Bahan
    SET Stock = Stock - $jumlah
    WHERE Data_Bahan_ID = $data_bahan_id
");

mysqli_query($conn,"
    DELETE FROM Detail_Pembelian
    WHERE Pembelian_ID = $id
");

mysqli_query($conn,"
    DELETE FROM Pembelian
    WHERE Pembelian_ID = $id
");

header("Location: index.php#pembelian");
exit;
?>