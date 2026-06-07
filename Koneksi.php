<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    function connect_db()
    {
        $host = "localhost";
        $user = "root";
        $pwd = "";
        $db = "alp webprog";

        $conn = new mysqli($host, $user, $pwd, $db);

        if ($conn->connect_errno) {
            die("Connection Failed : " . $conn->connect_error);
        }

        return $conn;
    }

    function get_bahan()
    {
        $conn = connect_db();
        return mysqli_query($conn, "SELECT * FROM Data_Bahan");
    }

    function get_menu()
    {
        $conn = connect_db();
        return mysqli_query($conn, "SELECT * FROM Menu");
    }


    function get_pembelian()
    {
        $conn = connect_db();

        return mysqli_query($conn, "
        SELECT
            Pembelian.Pembelian_ID,
            Pembelian.Tanggal,
            Data_Bahan.Nama_Bahan,
            Detail_Pembelian.Jumlah,
            Detail_Pembelian.Harga
        FROM Detail_Pembelian
        JOIN Pembelian
            ON Detail_Pembelian.Pembelian_ID = Pembelian.Pembelian_ID
        JOIN Data_Bahan
            ON Detail_Pembelian.Data_Bahan_ID = Data_Bahan.Data_Bahan_ID
    ");
    }

    function get_penjualan()
    {
        $conn = connect_db();

        return mysqli_query($conn, "
        SELECT
            Transaction.Transaction_ID,
            Transaction.Waktu,
            Transaction.Metode_Pembayaran,
            Menu.Nama_Menu,
            Detail_Transaction.Jumlah_Menu_Dipilih,
            Detail_Transaction.Harga_Menu
        FROM Detail_Transaction
        JOIN Transaction
            ON Detail_Transaction.Transaction_ID = Transaction.Transaction_ID
        JOIN Menu
            ON Detail_Transaction.Menu_ID = Menu.Menu_ID
    ");
    }
    ?>

</body>

</html>