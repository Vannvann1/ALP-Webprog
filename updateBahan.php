<?php
include __DIR__ . '/koneksi.php';
$conn = connect_db();

$id = $_POST['id'];
$nama = $_POST['nama_bahan'];
$stok = $_POST['stok'];
$satuan = $_POST['satuan'];

$query = "UPDATE Data_Bahan 
          SET Nama_Bahan='$nama',
              Stock='$stok',
              Satuan='$satuan'
          WHERE Data_Bahan_ID=$id";

mysqli_query($conn, $query);

header("Location: index.php#bahan-baku");
exit;
?>