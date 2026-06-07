<?php
include 'koneksi.php';

$conn = connect_db();

$id = $_GET['id'];

$result = mysqli_query($conn,"
    SELECT *
    FROM Detail_Pembelian
    WHERE Pembelian_ID = $id
");

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">

    <form action="updatePembelian.php" method="POST"
        class="bg-white p-6 rounded shadow w-[500px]">

        <input type="hidden"
            name="id"
            value="<?= $data['Pembelian_ID'] ?>">

        <input type="number"
            name="jumlah"
            value="<?= $data['Jumlah'] ?>"
            class="border p-2 w-full mb-3">

        <input type="number"
            name="harga"
            value="<?= $data['Harga'] ?>"
            class="border p-2 w-full mb-3">

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Update
        </button>

    </form>

</div>

</body>
</html>