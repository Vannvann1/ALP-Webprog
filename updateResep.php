<?php
include 'koneksi.php';

$conn = connect_db();

$id = $_POST['id'];
$jumlah_pakai = $_POST['jumlah_pakai'];
$data_bahan_id = $_POST['data_bahan_id'];
$menu_id = $_POST['menu_id'];

mysqli_query($conn, "
    UPDATE Recipe
    SET
        Jumlah_Pakai = '$jumlah_pakai',
        Data_Bahan_ID = '$data_bahan_id',
        Menu_ID = '$menu_id'
    WHERE Recipe_ID = $id
");

header("Location: index.php#produk");
exit;
?>