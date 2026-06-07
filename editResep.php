<?php
include __DIR__ . '/koneksi.php';
$conn = connect_db();

$id = $_GET['id'];

$result = mysqli_query($conn, "
    SELECT *
    FROM Recipe
    WHERE Recipe_ID = $id
");

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Resep</title>

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

  <div class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg overflow-hidden">

      <div class="bg-blue-600 p-6">
        <h1 class="text-white text-xl font-bold">Edit Resep</h1>
        <p class="text-blue-100 text-sm">Update komposisi bahan produk</p>
      </div>

      <form action="updateResep.php" method="POST" class="p-6 space-y-5">

        <input type="hidden"
               name="id"
               value="<?= $data['Recipe_ID'] ?>">

        <div>
          <label class="text-sm font-medium text-gray-700">
            Jumlah Pakai
          </label>

          <input
            type="number"
            name="jumlah_pakai"
            value="<?= $data['Jumlah_Pakai'] ?>"
            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div>
          <label class="text-sm font-medium text-gray-700">
            Bahan
          </label>

          <select
            name="data_bahan_id"
            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">

            <?php
            $bahan = mysqli_query($conn, "SELECT * FROM Data_Bahan");

            while ($row = mysqli_fetch_assoc($bahan)) {
            ?>
              <option
                value="<?= $row['Data_Bahan_ID'] ?>"
                <?= $row['Data_Bahan_ID'] == $data['Data_Bahan_ID'] ? 'selected' : '' ?>>
                <?= $row['Nama_Bahan'] ?>
              </option>
            <?php } ?>

          </select>
        </div>

        <div>
          <label class="text-sm font-medium text-gray-700">
            Menu
          </label>

          <select
            name="menu_id"
            class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">

            <?php
            $menu = mysqli_query($conn, "SELECT * FROM Menu");

            while ($row = mysqli_fetch_assoc($menu)) {
            ?>
              <option
                value="<?= $row['Menu_ID'] ?>"
                <?= $row['Menu_ID'] == $data['Menu_ID'] ? 'selected' : '' ?>>
                <?= $row['Nama_Menu'] ?>
              </option>
            <?php } ?>

          </select>
        </div>

        <div class="flex gap-3 pt-2">

          <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
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