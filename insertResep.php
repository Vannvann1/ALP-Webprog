<?php

include "koneksi.php";
$conn = connect_db();

$jumlah_pakai = $_POST['jumlah_pakai'];
$data_bahan_id = $_POST['data_bahan_id'];
$menu_id = $_POST['menu_id'];

$query = "
    INSERT INTO Recipe
    (Jumlah_Pakai, Data_Bahan_ID, Menu_ID)
    VALUES
    ('$jumlah_pakai', '$data_bahan_id', '$menu_id')
";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

?>