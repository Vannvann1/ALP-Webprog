<?php
include 'koneksi.php';

$conn = connect_db();

$nama = $_POST['nama_bahan'];
$stok = $_POST['stok'];
$satuan = $_POST['satuan'];

mysqli_query($conn, "INSERT INTO Data_Bahan (Nama_Bahan, Stock, Satuan)
VALUES ('$nama', '$stok', '$satuan')");

header("Location: index.php");
exit;
?>