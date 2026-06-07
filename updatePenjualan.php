<?php
include 'koneksi.php';

$conn = connect_db();

$id = $_POST['id'];
$jumlah_baru = $_POST['jumlah'];
$harga = $_POST['harga'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT *
    FROM Detail_Transaction
    WHERE Transaction_ID = $id
"));

$jumlah_lama = $data['Jumlah_Menu_Dipilih'];
$menu_id = $data['Menu_ID'];

$selisih = $jumlah_baru - $jumlah_lama;

$resep = mysqli_query($conn,"
    SELECT *
    FROM Recipe
    WHERE Menu_ID = $menu_id
");

while($row = mysqli_fetch_assoc($resep))
{
    $pakai = $row['Jumlah_Pakai'] * $selisih;

    mysqli_query($conn,"
        UPDATE Data_Bahan
        SET Stock = Stock - $pakai
        WHERE Data_Bahan_ID = {$row['Data_Bahan_ID']}
    ");
}

mysqli_query($conn,"
    UPDATE Detail_Transaction
    SET
        Jumlah_Menu_Dipilih = '$jumlah_baru',
        Harga_Menu = '$harga'
    WHERE Transaction_ID = $id
");

header("Location: index.php#penjualan");
exit;
?>