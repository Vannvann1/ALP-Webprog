<?php
include 'koneksi.php';

$conn = connect_db();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$waktu   = $_POST['waktu'];
$metode  = $_POST['metode_pembayaran'];
$menu_id = (int) $_POST['menu_id'];
$jumlah  = (int) $_POST['jumlah_menu_dipilih'];
$harga   = (int) $_POST['harga_menu'];

/* 1. INSERT TRANSACTION */
mysqli_query($conn, "
    INSERT INTO `Transaction` (Waktu, Metode_Pembayaran)
    VALUES ('$waktu', '$metode')
");

$transaction_id = mysqli_insert_id($conn);

/* 2. INSERT DETAIL TRANSACTION */
mysqli_query($conn, "
    INSERT INTO Detail_Transaction (
        Jumlah_Menu_Dipilih,
        Harga_Menu,
        Menu_ID,
        Transaction_ID
    ) VALUES (
        $jumlah,
        $harga,
        $menu_id,
        $transaction_id
    )
");

/* 3. AMBIL RESEP */
$resep = mysqli_query($conn, "
    SELECT Data_Bahan_ID, Jumlah_Pakai
    FROM Recipe
    WHERE Menu_ID = $menu_id
");

/* 4. KURANGI STOK (AMAN) */
while ($row = mysqli_fetch_assoc($resep)) {

    $bahan_id = (int) $row['Data_Bahan_ID'];
    $pakai    = (int) $row['Jumlah_Pakai'] * $jumlah;

    mysqli_query($conn, "
        UPDATE Data_Bahan
        SET Stock = Stock - $pakai
        WHERE Data_Bahan_ID = $bahan_id
    ");
}

header("Location: index.php#penjualan");
exit;
?>
