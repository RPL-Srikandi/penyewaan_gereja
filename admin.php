<?php $title = "Admin - Penyewaan Ruangan Gereja"; ?>
<?php include "header.php"?>
<?php
// session_start();

// Fungsi untuk melakukan koneksi ke database
function connectDatabase()
{
    $host = 'localhost';
    $user = 'id20884196_user_penyewaan';
    $password = 'Db_User_Penyewaan_Gereja_12345';
    $database = 'id20884196_penyewaan_gereja';

    $conn = mysqli_connect($host, $user, $password, $database);
    if (!$conn) {
        die('Koneksi database gagal: ' . mysqli_connect_error());
    }

    return $conn;
}

// Memeriksa apakah pengguna telah login
if (!isset($_SESSION["admin"])) {
    header("Location: login_admin.php");
    exit();
}

function total_harga($tanggal, $waktu_mulai, $waktu_selesai, $harga, $waktu) {
    $tanggal_waktu_mulai = DateTime::createFromFormat('Y-m-d H:i:s', $tanggal . ' ' . $waktu_mulai);
    $tanggal_waktu_selesai = DateTime::createFromFormat('Y-m-d H:i:s', $tanggal . ' ' . $waktu_selesai);

    $selisih_menit = ($tanggal_waktu_selesai->diff($tanggal_waktu_mulai)->format('%h') * 60) + $tanggal_waktu_selesai->diff($tanggal_waktu_mulai)->format('%i');
    $selisih_jam = $selisih_menit / 60;
    $total_harga = $selisih_jam * $harga;

    return $total_harga;
}

?>

<div class="container">
    <h1>Admin - Penyewaan Ruangan Gereja</h1>

    <a href="jadwal.php" class="btn btn-primary mb-2">Kembali ke Daftar Penyewaan</a>

    <table class="table table-bordered">
        <tr class="custom-table-header">
            <th>ID</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Paket</th>
            <th>Harga</th>
            <th>Per Jam</th>
            <th>Biaya</th>
            <th>Sudah Bayar</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Koneksi ke database
        $connection = connectDatabase();

        // Mengambil semua data penyewaan dari tabel
        $result = mysqli_query($connection, "SELECT penyewaan.id as id, penyewaan.nama as nama, penyewaan.tanggal as tanggal, penyewaan.jam_mulai as jam_mulai, penyewaan.jam_selesai as jam_selesai, penyewaan.sudah_bayar as sudah_bayar, penyewaan.ruangan as paket_id, paket.nama_paket as nama_paket, paket.harga as harga, paket.waktu as waktu FROM penyewaan, paket WHERE penyewaan.ruangan = paket.id;");

        // Menampilkan data penyewaan
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['nama']."</td>";
            echo "<td>".$row['tanggal']."</td>";
            echo "<td>".$row['jam_mulai']."</td>";
            echo "<td>".$row['jam_selesai']."</td>";
            echo "<td>".$row['nama_paket']."</td>";
            echo "<td>".$row['harga']."</td>";
            echo "<td>".$row['waktu']."</td>";
            echo "<td>".total_harga($row['tanggal'], $row['jam_mulai'], $row['jam_selesai'], $row['harga'], $row['waktu'])."</td>";
            echo "<td><div class=\"form-check\"><input class=\"form-check-input\" type=\"checkbox\" value=\"\" id=\"flexCheckCheckedDisabled\" " . ($row["sudah_bayar"] == 0 ? "" : "checked") . " disabled/></div></td>";
            echo "<td><a href='edit_penyewaan.php?id=".$row['id']."' class='btn btn-primary'>Edit</a> <a href='hapus_penyewaan.php?id=".$row['id']."' class='btn btn-danger'>Hapus</a></td>";
            echo "</tr>";
        }

        // Menutup koneksi
        mysqli_close($connection);
        ?>
    </table>
</div>

<?php include "footer.php"?>
