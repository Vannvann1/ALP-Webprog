<?php
include 'koneksi.php';

$conn = connect_db();

$menu = $_POST['menu'];
$harga = $_POST['harga'];

$namaFile = $_FILES['gambar']['name'];
$tmpFile = $_FILES['gambar']['tmp_name'];

move_uploaded_file($tmpFile, "uploads/" . $namaFile);

mysqli_query($conn, "
    INSERT INTO Menu (Nama_Menu, Harga, Gambar)
    VALUES ('$menu', '$harga', '$namaFile')
");

header("Location: index.php");
exit;
?>