<?php
include __DIR__ . '/koneksi.php';
$conn = connect_db();

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM Menu WHERE Menu_ID=$id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

  <div class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg overflow-hidden">

      <div class="bg-blue-600 p-6">
        <h1 class="text-white text-xl font-bold">Edit Produk</h1>
        <p class="text-blue-100 text-sm">Update data produk UMKM</p>
      </div>

      <form action="updateProduk.php"
            method="POST"
            enctype="multipart/form-data"
            class="p-6 space-y-5">

        <input type="hidden"
               name="id"
               value="<?= $data['Menu_ID'] ?>">

        <div>
          <label class="text-sm font-medium text-gray-700">
            Nama Menu
          </label>

          <input type="text"
                 name="menu"
                 value="<?= $data['Nama_Menu'] ?>"
                 class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div>
          <label class="text-sm font-medium text-gray-700">
            Harga
          </label>

          <input type="number"
                 name="harga"
                 value="<?= $data['Harga'] ?>"
                 class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div>
          <label class="text-sm font-medium text-gray-700">
            Gambar Saat Ini
          </label>

          <img src="uploads/<?= $data['Gambar'] ?>"
               class="w-32 h-32 object-cover rounded mt-2">
        </div>

        <div>
          <label class="text-sm font-medium text-gray-700">
            Ganti Gambar (Opsional)
          </label>

          <input type="file"
                 name="gambar"
                 accept="image/*"
                 class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>

        <div class="flex gap-3 pt-2">

          <button
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
            Update
          </button>

          <a href="index.php#produk"
             class="w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg transition">
            Cancel
          </a>

        </div>

      </form>

    </div>

  </div>

</body>

</html>