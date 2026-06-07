<?php
include 'koneksi.php';

$conn = connect_db();

$id = $_POST['id'];
$menu = $_POST['menu'];
$harga = $_POST['harga'];

mysqli_query(
    $conn,
    "UPDATE Menu
     SET Nama_Menu = '$menu',
         Harga = '$harga'
     WHERE Menu_ID = $id"
);

header("Location: index.php");
exit;
?>