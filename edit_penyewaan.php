<?php $title="Edit Penyewaan - Penyewaan Ruangan Gereja"; ?>
    <?php include "header.php"?>

    <div class="container">
        <h1>Edit Penyewaan</h1>

        <?php
        // Koneksi ke database
        $connection = mysqli_connect("localhost", "root", "", "penyewaan_gereja");

        // Memeriksa koneksi
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // Query untuk mendapatkan daftar ruangan dari tabel paket
        $query = "SELECT * FROM paket";
        $result = mysqli_query($connection, $query);

        // Mengecek apakah query berhasil dieksekusi
        if ($result) {
            $ruanganOptions = "";
            // Mengambil setiap baris hasil query
            while ($row = mysqli_fetch_assoc($result)) {
                $ruanganOptions .= '<option value="' . $row['id'] . '">' . $row['nama_paket'] . " Rp. " . $row['harga'] . " per " . $row["waktu"] . " jam" . '</option>';
            }
        } else {
            echo "Error: " . mysqli_error($connection);
        }

        // Memeriksa apakah ada parameter id yang dikirim melalui URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Memeriksa apakah tombol "Simpan" ditekan
            if (isset($_POST['submit'])) {
                $sudah_bayar = isset($_POST["sudah_bayar"]) ? 1 : 0;
                $nama = $_POST['nama'];
                $tanggal = $_POST['tanggal'];
                $jam_mulai = $_POST['jam_mulai'];
                $jam_selesai = $_POST['jam_selesai'];
                $ruangan = $_POST['ruangan'];

                // Melakukan proses update data penyewaan ke dalam database
                $query = "UPDATE penyewaan SET nama='$nama', tanggal='$tanggal', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai', ruangan='$ruangan', sudah_bayar=$sudah_bayar WHERE id='$id'";
                if (mysqli_query($connection, $query)) {
                    // Jika update berhasil, tampilkan pesan sukses
                    echo "<div class='alert alert-success' role='alert'>Penyewaan berhasil diupdate.</div>";
                } else {
                    // Jika update gagal, tampilkan pesan error
                    echo "<div class='alert alert-danger' role='alert'>Gagal mengupdate penyewaan: " . mysqli_error($connection) . "</div>";
                }
            }

            // Mengambil data penyewaan berdasarkan id
            $result = mysqli_query($connection, "SELECT * FROM penyewaan WHERE id='$id'");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            } else {
                // Jika data tidak ditemukan, arahkan kembali ke halaman admin.php
                header("Location: admin.php");
                exit();
            }
        } else {
            // Jika parameter id tidak ditemukan, arahkan kembali ke halaman admin.php
            header("Location: admin.php");
            exit();
        }
        ?>

        <!-- Formulir pengeditan penyewaan -->
        <form method="POST" action="edit_penyewaan.php?id=<?php echo $id; ?>">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="<?php echo $row['jam_mulai']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="<?php echo $row['jam_selesai']; ?>" required>
            </div>
            <div class="form-group">
                <label for="ruangan">Pilih Ruangan:</label>
                <select id="ruangan" name="ruangan" class="form-control" required>
                    <?php echo $ruanganOptions; ?>
                </select>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="sudah_bayar" name="sudah_bayar" <?php echo ($row["sudah_bayar"] == 0 ? "" : "checked" ); ?>/>
                    <label class="form-check-label" for="sudah_bayar">Sudah Bayar</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
                <div class="col-md-6">
                    <a href="admin.php" class="btn btn-secondary">Kembali ke Admin</a>
                </div>
            </div>
        </form>
    </div>

    <?php include "footer.php"?>
