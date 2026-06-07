<?php
include 'koneksi.php';

$conn = connect_db();

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT *
    FROM Detail_Transaction
    WHERE Transaction_ID = $id
"));

$menu_id = $data['Menu_ID'];
$jumlah = $data['Jumlah_Menu_Dipilih'];

$resep = mysqli_query($conn,"
    SELECT *
    FROM Recipe
    WHERE Menu_ID = $menu_id
");

while($row = mysqli_fetch_assoc($resep))
{
    $kembali = $row['Jumlah_Pakai'] * $jumlah;

    mysqli_query($conn,"
        UPDATE Data_Bahan
        SET Stock = Stock + $kembali
        WHERE Data_Bahan_ID = {$row['Data_Bahan_ID']}
    ");
}

mysqli_query($conn,"
    DELETE FROM Detail_Transaction
    WHERE Transaction_ID = $id
");

mysqli_query($conn,"
    DELETE FROM `Transaction`
    WHERE Transaction_ID = $id
");

header("Location: index.php#penjualan");
exit;
?>