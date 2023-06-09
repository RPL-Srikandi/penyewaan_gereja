<?php $title="Penyewaan Ruangan Gereja"; ?>
<?php include "header.php"?>
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Penyewaan Ruangan Gereja</h1>

                <a href="proses_penyewaan.php" class="btn btn-primary mb-2">Tambah Penyewaan</a>

                <table class="table table-bordered">
                    <tr class="custom-table-header">
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Paket</th>
                    </tr>
                    <?php
                    // Koneksi ke database
                    $connection = mysqli_connect("localhost", "id20884196_user_penyewaan", "Db_User_Penyewaan_Gereja_12345", "id20884196_penyewaan_gereja");

                    // Memeriksa koneksi
                    if (mysqli_connect_errno()) {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }

                    // Mengambil semua data penyewaan dari tabel
                    $result = mysqli_query($connection, "SELECT penyewaan.id as id, penyewaan.nama as nama, penyewaan.tanggal as tanggal, penyewaan.jam_mulai as jam_mulai, penyewaan.jam_selesai as jam_selesai, penyewaan.ruangan as paket_id, paket.nama_paket as nama_paket, paket.harga as harga, paket.waktu as waktu FROM penyewaan, paket WHERE penyewaan.ruangan = paket.id;");

                    // Menampilkan data penyewaan
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['nama']."</td>";
                        echo "<td>".$row['tanggal']."</td>";
                        echo "<td>".$row['jam_mulai']."</td>";
                        echo "<td>".$row['jam_selesai']."</td>";
                        echo "<td>".$row['nama_paket']."</td>";
                        echo "</tr>";
                    }

                    // Menutup koneksi
                    mysqli_close($connection);
                    ?>
                </table>
            </div>
        </div>
    </div>

    <?php include "footer.php"?>
