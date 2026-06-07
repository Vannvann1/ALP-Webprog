<?php
include 'koneksi.php';

$conn = connect_db();

$id = $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM Recipe
     WHERE Menu_ID = $id"
);

mysqli_query(
    $conn,
    "DELETE FROM Menu
     WHERE Menu_ID = $id"
);

header("Location: index.php#produk");
exit;
?>