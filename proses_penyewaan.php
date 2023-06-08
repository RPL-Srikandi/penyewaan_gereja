<?php
$title = "Penyewaan Ruangan Gereja";
include "header.php";

// Koneksi ke database
$connection = mysqli_connect("localhost", "id20884196_user_penyewaan", "Db_User_Penyewaan_Gereja_12345", "id20884196_penyewaan_gereja");

// Memeriksa koneksi
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
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

// Mendefinisikan fungsi untuk membersihkan input
function clean_input($connection, $data)
{
    return mysqli_real_escape_string($connection, htmlspecialchars($data));
}

$today = date("Y-m-d");
$current_time = date("H:i");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_date = $_POST['tanggal'];
    $selected_time = $_POST['jam_mulai'];

    $current_datetime = date("Y-m-d H:i");
    $selected_datetime = $selected_date . ' ' . $selected_time;

    if ($selected_datetime <= $current_datetime) {
        $message = "Jam pemesanan tidak valid. Harap pilih waktu yang valid.";
    }
}


$message = "";

if (isset($_GET["s"])) {
    if ($_GET["s"] == "1")
        $message = "Data berhasil disimpan. Silahkan hubungi admin (0853 2514 2255) untuk melakukan pembayaran!";
    else if ($_GET["s"] == "2")
        $message = "Jadwal yang Anda pilih sudah terpesan. Silahkan pilih jadwal yang lain.";
    else
        $message = "Mohon lengkapi semua field.";
}

if (isset($_POST['submit'])) {
    $success = 0;
    // Memeriksa apakah semua input terisi
    if (!empty($_POST['nama']) && !empty($_POST['tanggal']) && !empty($_POST['jam_mulai']) && !empty($_POST['jam_selesai']) && !empty($_POST['ruangan'])) {
        // Mengambil data dari form
        $nama = clean_input($connection, $_POST['nama']);
        $tanggal = clean_input($connection, $_POST['tanggal']);
        $jam_mulai = clean_input($connection, $_POST['jam_mulai']);
        $jam_selesai = clean_input($connection, $_POST['jam_selesai']);
        $ruangan = clean_input($connection, $_POST['ruangan']);

        // Mengecek apakah jadwal yang dipilih sudah terpesan
        $query = "SELECT * FROM penyewaan WHERE tanggal = '$tanggal' AND ruangan = '$ruangan'";
        $result = mysqli_query($connection, $query);

        // Memeriksa apakah tanggal yang dipilih adalah hari ini (memastikan tanggal sebelumnya tidak bisa sewa)
        $tanggal_sekarang = date("Y-m-d");
        if ($tanggal < $tanggal_sekarang or ($tanggal == $tanggal_sekarang and $jam_mulai <= date("H:i"))) {
            $success = 0; // Tanggal dan jam tidak valid
            $message = "Jam yang anda pilih tidak valid";
        }

        if (mysqli_num_rows($result) > 0) {
            // Jadwal sudah terpesan
            $success = 2; // = "Jadwal yang Anda pilih sudah terpesan. Silahkan pilih jadwal yang lain.";
        } else {
            // Membuat prepared statement
            $stmt = mysqli_prepare($connection, "INSERT INTO penyewaan (nama, tanggal, jam_mulai, jam_selesai, ruangan) VALUES (?, ?, ?, ?, ?)");

            // Memasukkan data ke prepared statement
            mysqli_stmt_bind_param($stmt, "sssss", $nama, $tanggal, $jam_mulai, $jam_selesai, $ruangan);

            // Menjalankan prepared statement
            mysqli_stmt_execute($stmt);

            // Menutup prepared statement
            mysqli_stmt_close($stmt);

            $success = 1; // = "Data berhasil disimpan. Silahkan hubungi admin (0853 2514 2255) untuk melakukan pembayaran!";
        }
    } else {
        $success = 0; // = "Mohon lengkapi semua field.";
    }

    header("Location: proses_penyewaan.php?s=$success");
}

// Menutup koneksi
mysqli_close($connection);
?>


<div class="container">
    <h1>Penyewaan</h1>
    <?php if($message != ""): ?>
        <div class='alert alert-success' role='alert'><?php echo $message; ?></div>
    <?php endif;?>
    <div id="terms-and-conditions">
        <h3>Syarat dan Ketentuan</h3>
        <p>Silakan membaca dan menyetujui syarat dan ketentuan di bawah sebelum mengisi form penyewaan:</p>

        <ul>
            <li>Penyewaan ruangan gereja tidak hanya tersedia untuk kegiatan non-komersial yang bersifat keagamaan.</li>
            <li>Penyewaan ruangan harus dilakukan minimal 2 bulan sebelum tanggal acara.</li>
            <li>Waktu penyewaan ruangan terbatas mulai dari pukul 06.00 hingga pukul 23.00.</li>
            <li>Pastikan ruangan yang Anda pilih tersedia pada tanggal dan jam yang diinginkan.</li>
            <li>Penyewa bertanggung jawab untuk menjaga kebersihan dan kerapihan ruangan selama acara berlangsung.</li>
            <li>Penggunaan peralatan audio dan visual harus sesuai dengan peraturan gereja.</li>
            <li>Penyewa wajib mengikuti protokol kesehatan yang berlaku.</li>
            <li>Biaya penyewaan ruangan akan ditentukan berdasarkan durasi dan jenis paket yang dipilih.</li>
            <li>Penyewaan ruangan dapat dibatalkan oleh pihak gereja dalam hal terjadi keadaan darurat atau kegiatan gereja yang mendesak.</li>
            <li>Penyewaan ruangan tidak dapat dibatalkan oleh pihak pemesan. Jika terpaksa dibatalkan akan ada denda yang diberikan.</li>
        </ul>

        <h3>Fasilitas</h3>
        <p>Fasilitas penyewaan dilengkapi dengan:</p>

        <ul>
            <li>Kapasitas hingga 500 orang</li>
            <li>Gedung dilengkapi lift</li>
            <li>Dekorasi</li>
            <li>Catering</li>
            <li>Multimedia (Live Streaming dan Dokumentasi)</li>
            <li>Sound System</li>
            <li>Entertainment</li>
            <li>Choirs</li>
        </ul>

        <h3>Paket Lengkap</h3>
        <h5>Pernikahan Gerejawi</h5>
            <ul>
                <li>Pemberkatan</li>
                <li>Pencatatan Sipil</li>
                <li>Resepsi Pernikahan</li>
            </ul>
        <h5>Pertemuan (Rapat/Reuni)</h5>
            <ul>
                <li>Sarana Komplit</li>
            </ul>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="agree-checkbox">
            <label class="form-check-label" for="agree-checkbox">
                Saya telah membaca dan menyetujui syarat dan ketentuan di atas.
            </label>
        </div>
        <div class="row">
            <div class="md-4">
                <button class="btn btn-success" id="lanjut" disabled>Lanjut</button>
            </div>
        </div>
    </div>

    <div id="form-section" style="display: none;">
        <h3>Form Penyewaan Ruangan Gereja</h3>

        <form method="POST" action="proses_penyewaan.php">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" min="<?php echo date("Y-m-d"); ?>" required>
            </div>
            <div class="form-group">
                <label for="jam_mulai">Jam Mulai:</label>
                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
            </div>
            <div class="form-group">
                <label for="jam_selesai">Jam Selesai:</label>
                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
            </div>
            <div class="form-group">
                <label for="ruangan">Pilih Ruangan:</label>
                <select id="ruangan" name="ruangan" class="form-control" required>
                    <?php echo $ruanganOptions; ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-success">Tambah</button>
        </form>
    </div>
</div>

<script>
    document.getElementById("agree-checkbox").addEventListener("change", (e) => {
        var lanjut = document.getElementById("lanjut")
        if(e.target.checked) lanjut.removeAttribute("disabled")
        else lanjut.setAttribute("disabled", "true")
    })
    document.getElementById("lanjut").addEventListener("click", function () {
        if (document.getElementById("tanggal").value === "<?php echo $today; ?>" && document.getElementById("jam_mulai").value <= "<?php echo $current_time; ?>") {
            alert("Jam pemesanan tidak valid. Harap pilih waktu yang valid.");
        } else {
            document.getElementById("terms-and-conditions").style.display = "none";
            document.getElementById("form-section").style.display = "block";
            document.getElementById("form-section").style.opacity = "0";
            document.getElementById("form-section").classList.add("login-area");
            var st = setTimeout(() => {
                document.getElementById("form-section").style.opacity = "1"
                clearTimeout(st)
            }, 500)
        }
    });

</script>

<?php include "footer.php"?>