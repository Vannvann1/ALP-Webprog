<?php
include __DIR__ . '/koneksi.php';
$conn = connect_db();

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM Data_Bahan WHERE Data_Bahan_ID=$id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Bahan</title>

  <!-- Tailwind WAJIB -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

  <div class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg overflow-hidden">

      <div class="bg-blue-600 p-6">
        <h1 class="text-white text-xl font-bold">Edit Bahan Baku</h1>
        <p class="text-blue-100 text-sm">Update data inventory dengan mudah</p>
      </div>

      <form action="updateBahan.php" method="POST" class="p-6 space-y-5">

        <input type="hidden" name="id" value="<?= $data['Data_Bahan_ID'] ?>">

        <div>
          <label class="text-sm font-medium text-gray-700">Nama Bahan</label>
          <input type="text" name="nama_bahan"
            value="<?= $data['Nama_Bahan'] ?>"
            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
        </div>

        <div>
          <label class="text-sm font-medium text-gray-700">Stok</label>
          <input type="number" name="stok"
            value="<?= $data['Stock'] ?>"
            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
        </div>

        <div>
          <label class="text-sm font-medium text-gray-700">Satuan</label>
          <select name="satuan"
            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

            <option <?= $data['Satuan']=="Kg" ? "selected" : "" ?>>Kg</option>
            <option <?= $data['Satuan']=="Gram" ? "selected" : "" ?>>Gram</option>
            <option <?= $data['Satuan']=="Liter" ? "selected" : "" ?>>Liter</option>
            <option <?= $data['Satuan']=="Ml" ? "selected" : "" ?>>Ml</option>
            <option <?= $data['Satuan']=="Pcs" ? "selected" : "" ?>>Pcs</option>

          </select>
        </div>

        <div class="flex gap-3 pt-2">

          <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
            Update
          </button>

          <a href="index.php#bahan-baku"
            class="w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg transition">
            Cancel
          </a>

        </div>

      </form>

    </div>

  </div>

</body>

</html>