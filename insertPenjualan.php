<?php
include 'koneksi.php';

$conn = connect_db();

$waktu = $_POST['waktu'];
$metode = $_POST['metode_pembayaran'];
$menu_id = $_POST['menu_id'];
$jumlah = $_POST['jumlah_menu_dipilih'];
$harga = $_POST['harga_menu'];

mysqli_query($conn,"
    INSERT INTO `Transaction`(
        Waktu,
        Metode_Pembayaran
    )
    VALUES(
        '$waktu',
        '$metode'
    )
");

$transaction_id = mysqli_insert_id($conn);

mysqli_query($conn,"
    INSERT INTO Detail_Transaction(
        Jumlah_Menu_Dipilih,
        Harga_Menu,
        Menu_ID,
        Transaction_ID
    )
    VALUES(
        '$jumlah',
        '$harga',
        '$menu_id',
        '$transaction_id'
    )
");

/* KURANGI STOK BAHAN SESUAI RESEP */
$resep = mysqli_query($conn,"
    SELECT Data_Bahan_ID, Jumlah_Pakai
    FROM Recipe
    WHERE Menu_ID = $menu_id
");

while($row = mysqli_fetch_assoc($resep))
{
    $bahan_id = $row['Data_Bahan_ID'];
    $pakai = $row['Jumlah_Pakai'] * $jumlah;

    mysqli_query($conn,"
        UPDATE Data_Bahan
        SET Stock = Stock - $pakai
        WHERE Data_Bahan_ID = $bahan_id
    ");
}

header("Location: index.php#penjualan");
exit;
?>