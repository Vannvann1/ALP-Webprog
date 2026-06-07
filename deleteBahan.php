<?php
include __DIR__ . '/koneksi.php';
$conn = connect_db();

$id = $_GET['id'];

$query = "DELETE FROM Data_Bahan WHERE Data_Bahan_ID=$id";
mysqli_query($conn, $query);

header("Location: index.php#bahan-baku");
exit;
?>