<?php
include 'koneksi.php';

$conn = connect_db();

$id = $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM Recipe
     WHERE Recipe_ID = $id"
);

header("Location: index.php#produk");
exit;
?>