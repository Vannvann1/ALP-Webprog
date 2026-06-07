<!doctype html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://cdn.tailwindcss.com"></script>

  <title>UMKM Management</title>
</head>

<body class="overflow-x-hidden">
  <!-- Header -->
  <header class="p-6 border-b flex items-center gap-4">
    <button id="menuBtn" class="block md:hidden bg-gray-800 text-white px-3 py-2 rounded">
      ☰
    </button>
    <h1 class="text-[24px] md:text-[35px] font-bold">Sistem Inventory UMKM</h1>
    <h3 class="text-[15px] text-gray-500">Manajemen Stok dan Penjualan</h3>
  </header>

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <div id="overlay" class=" fixed inset-0 bg-black/50 hidden z-40 md:hidden "></div>
    <aside id="sidebar" class=" fixed md:sticky top-0 left-0 w-64 bg-gray-800 p-4 text-white h-screen z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
      <h2 class="mb-6 text-xl font-bold">UMKM</h2>
      <ul class="space-y-2">
        <li>
          <a href="#dashboard" class="block rounded p-4 hover:bg-gray-700">Dashboard</a>
        </li>

        <li>
          <a href="#bahan-baku" class="block rounded p-4 hover:bg-gray-700">Bahan Baku</a>
        </li>

        <li>
          <a href="#produk" class="block rounded p-4 hover:bg-gray-700">Produk & Resep</a>
        </li>

        <li>
          <a href="#pembelian" class="block rounded p-4 hover:bg-gray-700">Pembelian</a>
        </li>

        <li>
          <a href="#penjualan" class="block rounded p-4 hover:bg-gray-700">Penjualan</a>
        </li>
      </ul>
    </aside>


    <!-- Content -->
    <main class="flex-1 min-w-0 p-4 md:p-6 bg-gray-100">

      <?php
      include_once 'koneksi.php';
      $conn = connect_db();

      $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM Data_Bahan");
      $data = mysqli_fetch_assoc($result);

      $total_bahan = $data['total'];

      $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM Menu");
      $total_produk = mysqli_fetch_assoc($result)['total'];

      $result = mysqli_query($conn, "SELECT SUM(Harga) as total FROM Detail_Pembelian");
      $total_pembelian = mysqli_fetch_assoc($result)['total'] ?? 0;

      $result = mysqli_query($conn, "SELECT SUM(Jumlah_Menu_Dipilih * Harga_Menu) as total FROM Detail_Transaction");
      $total_penjualan = mysqli_fetch_assoc($result)['total'] ?? 0;

      $stok_menipis = mysqli_query($conn, "SELECT * FROM Data_Bahan WHERE Stock <= 10");

      $transaksi_terakhir = mysqli_query($conn, "SELECT t.Waktu, m.Nama_Menu, dt.Jumlah_Menu_Dipilih FROM Detail_Transaction dt JOIN `Transaction` t ON dt.Transaction_ID = t.Transaction_ID JOIN Menu m ON dt.Menu_ID = m.Menu_ID ORDER BY t.Waktu DESC LIMIT 5");
      ?>

      <section id="dashboard" class="mb-20">
        <h1 class="text-[25px] font-bold">Dashboard</h1>
        <h3 class="text-[15px] text-gray-500">
          Ringkasan Inventory dan transaksi
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 pt-8">
          <div class="w-full h-32 bg-gray-300 rounded flex items-center justify-center gap-4">
            <h1 class="text-[25px]">Total Bahan Baku</h1>
            <h1 class="text-[25px]"><b><?= $total_bahan ?></b></h1>
          </div>

          <div class="w-full h-32 bg-gray-300 rounded flex items-center justify-center gap-4">
            <h1 class="text-[25px]">Total Produk</h1>
            <h1 class="text-[25px]"><b><?= $total_produk ?></b></h1>
          </div>

          <div class="w-full h-32 bg-gray-300 rounded flex items-center justify-center gap-4">
            <h1 class="text-[25px]">Total Pembelian</h1>
            <b>Rp <?= number_format($total_pembelian,0,',','.') ?></b>
          </div>

          <div class="w-full h-32 bg-gray-300 rounded flex items-center justify-center gap-4">
            <h1 class="text-[25px]">Total Penjualan</h1>
            <b>Rp <?= number_format($total_penjualan,0,',','.') ?></b>
          </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-4 pt-8">
          <div class="w-full lg:flex-1 h-64 bg-gray-300 rounded">
            <h1 class="text-[25px] font-bold p-6">Stok yang menipis:</h1>
              <div class="px-6 h-40 overflow-y-auto">
              <?php while($row = mysqli_fetch_assoc($stok_menipis)){ ?>
                  <div class="bg-white rounded p-3 mb-2">
                      <?= $row['Nama_Bahan'] ?> (<?= $row['Stock'] ?> <?= $row['Satuan'] ?>)
                  </div>
              <?php } ?>
              </div>

            <!-- <div>
                <div class="w-[570px] h-16 bg-white rounded mx-auto "></div>
              </div> -->
          </div>

          <div class="w-full lg:flex-1 h-64 bg-gray-300 rounded">
            <h1 class="text-[25px] font-bold p-6">Transaksi Terakhir</h1>
              <div class="px-6 h-40 overflow-y-auto">
              <?php while($row = mysqli_fetch_assoc($transaksi_terakhir)){ ?>
                  <div class="bg-white rounded p-3 mb-2">
                      <?= $row['Nama_Menu'] ?> (<?= $row['Jumlah_Menu_Dipilih'] ?>x)
                      <br>
                      <small><?= $row['Waktu'] ?></small>
                  </div>
              <?php } ?>
              </div>
            <!-- <div>
                <div class="w-[570px] h-16 bg-white rounded mx-auto "></div>
              </div> -->
          </div>
        </div>
      </section>

      <section id="bahan-baku" class="mb-20">
        <div>
          <h1 class="text-[25px] font-bold">Bahan Baku</h1>
          <h3 class="text-[15px] text-gray-500">Kelola Stok Bahan Baku</h3>
        </div>

        <hr class="border-black" />
        <h1 class="text-gray-500 pt-6">Tambah Bahan:</h1>

        <form action="insertBahan.php" method="POST" class="gap-4">
          <input type="text" placeholder="Nama Bahan" class="border rounded p-2 w-full max-w-md" required name="nama_bahan" />
          <input type="number" placeholder="Stok" class="border rounded p-2 w-full max-w-md" required name="stok" />
          <select class="border rounded p-2 w-full max-w-md" required name="satuan">
            <option value="">Pilih Satuan</option>
            <option>Kg</option>
            <option>Gram</option>
            <option>Liter</option>
            <option>Ml</option>
            <option>Pcs</option>
          </select>

          <div class="w-full">
            <button class="mt-4 bg-blue-500 text-white p-2 rounded">
              Submit
            </button>
          </div>
        </form>

        <?php
        include_once 'koneksi.php';

        $result = get_bahan();
        ?>

        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-300 bg-white shadow-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-left">
              <tr>
                <th class="p-3 border-b">Nama Bahan</th>
                <th class="p-3 border-b">Stok</th>
                <th class="p-3 border-b">Satuan</th>
                <th class="p-3 border-b text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="hover:bg-gray-100 transition">
                  <td class="p-3 border-b"><?= $row['Nama_Bahan'] ?></td>
                  <td class="p-3 border-b"><?= $row['Stock'] ?></td>
                  <td class="p-3 border-b"><?= $row['Satuan'] ?></td>

                  <!-- Aksi -->
                  <td class="p-3 border-b text-center flex justify-center gap-2">

                    <a href="editBahan.php?id=<?= $row['Data_Bahan_ID'] ?>" class="bg-yellow-400 px-3 py-1 rounded">
                      Edit
                    </a>

                    <a href="deleteBahan.php?id=<?= $row['Data_Bahan_ID'] ?>" onclick="return confirm('Yakin mau hapus?')"
                      class="bg-red-500 px-3 py-1 rounded">
                      Delete
                    </a>

                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </section>

      <section id="produk" class="mb-20">
        <h1 class="text-[25px] font-bold">Produk & Resep</h1>
        <h3 class="text-[15px] text-gray-500">
          Kelola Produk dan Komposisi Bahan
        </h3>
        <hr class="border-black" />
        <h1 class="text-gray-500 pt-6">Tambah Produk:</h1>

        <form action="insertProduk.php" method="POST" enctype="multipart/form-data" class="gap-4">
          <input type="text" placeholder="Nama Menu" class="border rounded p-2 w-full max-w-md" required name="menu" />
          <input type="number" placeholder="Harga" class="border rounded p-2 w-full max-w-md" required name="harga" />
          <input type="file" accept="image/*" class="border rounded p-2 w-full max-w-md" required name="gambar" />
          <div class="w-full">
            <button class="mt-4 bg-blue-500 text-white p-2 rounded">
              Submit
            </button>
          </div>
        </form>

        <?php
        include_once 'koneksi.php';

        $result = get_menu();
        ?>

        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-300 bg-white shadow-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-left">
              <tr>
                <th class="p-3 border-b">Nama Menu</th>
                <th class="p-3 border-b">Harga</th>
                <th class="p-3 border-b">Gambar</th>
                <th class="p-3 border-b text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="hover:bg-gray-100 transition">

                  <td class="p-3 border-b">
                    <?= $row['Nama_Menu'] ?>
                  </td>

                  <td class="p-3 border-b">
                    Rp <?= number_format($row['Harga'], 0, ',', '.') ?>
                  </td>

                  <td class="p-3 border-b">
                    <img src="uploads/<?= $row['Gambar'] ?>" alt="<?= $row['Nama_Menu'] ?>"
                      class="w-20 h-20 object-cover rounded">
                  </td>

                  <td class="p-3 border-b text-center flex justify-center gap-2">

                    <a href="editProduk.php?id=<?= $row['Menu_ID'] ?>" class="bg-yellow-400 px-3 py-1 rounded">
                      Edit
                    </a>

                    <a href="deleteProduk.php?id=<?= $row['Menu_ID'] ?>" onclick="return confirm('Yakin mau hapus?')"
                      class="bg-red-500 px-3 py-1 rounded">
                      Delete
                    </a>

                  </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <form action="insertResep.php" method="POST" class="gap-4 pt-6">

          <input type="number" placeholder="Jumlah Pakai" class="border rounded p-2 w-full max-w-md" required
            name="jumlah_pakai" />

          <select name="data_bahan_id" class="border rounded p-2 w-full max-w-md" required>
            <option value="">Pilih Bahan</option>

            <?php
            $bahan = mysqli_query($conn, "SELECT * FROM Data_Bahan");

            while ($row = mysqli_fetch_assoc($bahan)) {
              ?>
              <option value="<?= $row['Data_Bahan_ID'] ?>">
                <?= $row['Nama_Bahan'] ?>
              </option>
            <?php } ?>
          </select>

          <select name="menu_id" class="border rounded p-2 w-full max-w-md" required>
            <option value="">Pilih Menu</option>

            <?php
            $menu = mysqli_query($conn, "SELECT * FROM Menu");

            while ($row = mysqli_fetch_assoc($menu)) {
              ?>
              <option value="<?= $row['Menu_ID'] ?>">
                <?= $row['Nama_Menu'] ?>
              </option>
            <?php } ?>
          </select>

          <div class="w-full">
            <button class="mt-4 bg-blue-500 text-white p-2 rounded">
              Submit
            </button>
          </div>

        </form>

        <?php
        $result = mysqli_query($conn, "
    SELECT
        Recipe.Recipe_ID,
        Recipe.Jumlah_Pakai,
        Data_Bahan.Nama_Bahan,
        Menu.Nama_Menu
    FROM Recipe
    JOIN Data_Bahan
        ON Recipe.Data_Bahan_ID = Data_Bahan.Data_Bahan_ID
    JOIN Menu
        ON Recipe.Menu_ID = Menu.Menu_ID
");
        ?>

        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-300 bg-white shadow-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-left">
              <tr>
                <th class="p-3 border-b">Menu</th>
                <th class="p-3 border-b">Bahan</th>
                <th class="p-3 border-b">Jumlah Pakai</th>
                <th class="p-3 border-b text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="hover:bg-gray-100 transition">

                  <td class="p-3 border-b">
                    <?= $row['Nama_Menu'] ?>
                  </td>

                  <td class="p-3 border-b">
                    <?= $row['Nama_Bahan'] ?>
                  </td>

                  <td class="p-3 border-b">
                    <?= $row['Jumlah_Pakai'] ?>
                  </td>

                  <td class="p-3 border-b text-center flex justify-center gap-2">

                    <a href="editResep.php?id=<?= $row['Recipe_ID'] ?>" class="bg-yellow-400 px-3 py-1 rounded">
                      Edit
                    </a>

                    <a href="deleteResep.php?id=<?= $row['Recipe_ID'] ?>" onclick="return confirm('Yakin mau hapus?')"
                      class="bg-red-500 px-3 py-1 rounded">
                      Delete
                    </a>

                  </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </section>

      <section id="pembelian" class="mb-20">
        <h1 class="text-[25px] font-bold">Pembelian</h1>
        <h3 class="text-[15px] text-gray-500">Catatan Pembelian</h3>

        <hr class="border-black" />
        <h1 class="text-gray-500 pt-6">Tambah Pembelian</h1>

        <form action="insertPembelian.php" method="POST" class="gap-4 pt-6">

          <input type="date" name="tanggal" class="border rounded p-2 w-full max-w-md" required />

          <select name="data_bahan_id" class="border rounded p-2 w-full max-w-md" required>
            <option value="">Pilih Bahan</option>

            <?php
            $bahan = mysqli_query($conn, "SELECT * FROM Data_Bahan");

            while ($row = mysqli_fetch_assoc($bahan)) {
              ?>
              <option value="<?= $row['Data_Bahan_ID'] ?>">
                <?= $row['Nama_Bahan'] ?>
              </option>
            <?php } ?>
          </select>

          <input type="number" name="jumlah" placeholder="Jumlah" class="border rounded p-2 w-full max-w-md" required />

          <input type="number" name="harga" placeholder="Harga" class="border rounded p-2 w-full max-w-md" required />

          <div class="w-full">
            <button type="submit" class="mt-4 bg-blue-500 text-white p-2 rounded">
              Submit
            </button>
          </div>

        </form>

        <?php
        $result = get_pembelian();
        ?>

        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-300 bg-white shadow-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-left">
              <tr>
                <th class="p-3 border-b">Tanggal</th>
                <th class="p-3 border-b">Bahan</th>
                <th class="p-3 border-b">Jumlah</th>
                <th class="p-3 border-b">Harga</th>
                <th class="p-3 border-b text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="hover:bg-gray-100 transition">

                  <td class="p-3 border-b">
                    <?= $row['Tanggal'] ?>
                  </td>

                  <td class="p-3 border-b">
                    <?= $row['Nama_Bahan'] ?>
                  </td>

                  <td class="p-3 border-b">
                    <?= $row['Jumlah'] ?>
                  </td>

                  <td class="p-3 border-b">
                    Rp <?= number_format($row['Harga'], 0, ',', '.') ?>
                  </td>

                  <td class="p-3 border-b text-center flex justify-center gap-2">

                    <a href="editPembelian.php?id=<?= $row['Pembelian_ID'] ?>" class="bg-yellow-400 px-3 py-1 rounded">
                      Edit
                    </a>

                    <a href="deletePembelian.php?id=<?= $row['Pembelian_ID'] ?>"
                      onclick="return confirm('Yakin mau hapus?')" class="bg-red-500 px-3 py-1 rounded">
                      Delete
                    </a>

                  </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </section>

      <section id="penjualan">
        <h1 class="text-[25px] font-bold">Penjualan</h1>
        <h3 class="text-[15px] text-gray-500">Catatan Penjualan</h3>
        <hr class="border-black" />
        <h1 class="text-gray-500 pt-6">Tambah Penjualan</h1>

        <form action="insertPenjualan.php" method="POST" class="gap-4 pt-6">
          <div>
            <input type="datetime-local" name="waktu" required class="border rounded p-2 w-full max-w-md" />

            <select name="metode_pembayaran" required class="border rounded p-2 w-full max-w-md">
              <option value="">Pilih Metode</option>
              <option>Cash</option>
              <option>QRIS</option>
              <option>Transfer</option>
            </select>
          </div>

          <div>
            <select id="menu_id" name="menu_id" required class="border rounded p-2 w-full max-w-md">
              <option value="">Pilih Menu</option>
              <?php
              $menu = mysqli_query($conn, "SELECT * FROM Menu");
              while ($row = mysqli_fetch_assoc($menu)) {
              ?>
                <option value="<?= $row['Menu_ID'] ?>" data-harga="<?= $row['Harga'] ?>">
                  <?= $row['Nama_Menu'] ?>
                </option>
              <?php } ?>
            </select>

            <input type="number" name="jumlah_menu_dipilih" placeholder="Jumlah" required
              class="border rounded p-2 w-full max-w-md" />

            <input type="number" id="harga_menu" name="harga_menu" placeholder="Harga" readonly required class="border rounded p-2 w-full max-w-md" />

          </div>

          <div class="w-full">
            <button class="mt-4 bg-blue-500 text-white p-2 rounded">
              Submit
            </button>
          </div>
        </form>

        <?php
        $result = get_penjualan();
        ?>

        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-300 bg-white shadow-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-left">
              <tr>
                <th class="p-3 border-b">Waktu</th>
                <th class="p-3 border-b">Menu</th>
                <th class="p-3 border-b">Jumlah</th>
                <th class="p-3 border-b">Harga</th>
                <th class="p-3 border-b">Metode</th>
                <th class="p-3 border-b text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="hover:bg-gray-100 transition">

                  <td class="p-3 border-b">
                    <?= $row['Waktu'] ?>
                  </td>

                  <td class="p-3 border-b">
                    <?= $row['Nama_Menu'] ?>
                  </td>

                  <td class="p-3 border-b">
                    <?= $row['Jumlah_Menu_Dipilih'] ?>
                  </td>

                  <td class="p-3 border-b">
                    Rp <?= number_format($row['Harga_Menu'], 0, ',', '.') ?>
                  </td>

                  <td class="p-3 border-b">
                    <?= $row['Metode_Pembayaran'] ?>
                  </td>

                  <td class="p-3 border-b text-center flex justify-center gap-2">

                    <a href="editPenjualan.php?id=<?= $row['Transaction_ID'] ?>" class="bg-yellow-400 px-3 py-1 rounded">
                      Edit
                    </a>

                    <a href="deletePenjualan.php?id=<?= $row['Transaction_ID'] ?>"
                      onclick="return confirm('Yakin mau hapus?')" class="bg-red-500 px-3 py-1 rounded">
                      Delete
                    </a>

                  </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
  <script>
    document.getElementById('menu_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('harga_menu').value =
            selected.dataset.harga || '';
    });
  </script>

  <script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    menuBtn.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });
    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
  </script>
</body>

</html>
