<?php $title="Kritik dan Saran - Penyewaan Ruangan Gereja"; ?>
<?php include "header.php"?>

<?php
// Koneksi ke database
$connection = mysqli_connect("localhost", "id20884196_user_penyewaan", "Db_User_Penyewaan_Gereja_12345", "id20884196_penyewaan_gereja");

// Memeriksa koneksi
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

$message = "";

if(isset($_GET["s"])){
    if($_GET["s"] == "1")
        $message = "Kritik dan saran terkirim.";
    else
        $message = "Mohon lengkapi semua field.";
}

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai dari form
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $pesan = $_POST["pesan"];

    // Menyiapkan pernyataan SQL INSERT
    $query = "INSERT INTO kritik_saran (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";
    $sucess = 0;
    // Menjalankan pernyataan SQL
    if (mysqli_query($connection, $query)) {
        $sucess = 1; // =  "Kritik dan saran berhasil dikirim.";
    } else {
        $sucess = 0; // = "Mohon lengkapi semua field.";
    }

    
    ob_end_clean();
    ob_end_flush();
    header("Location: kritiksaran.php?s=$sucess");
    exit();
}

// Menutup koneksi
mysqli_close($connection);
?>

    <div class="container">
        <h1>Kritik dan Saran</h1>
        <?php if($message != ""): ?>
            <div class='alert alert-success' role='alert'><?php echo $message; ?></div>
        <?php endif;?>

        <form action="kritiksaran.php" method="POST">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="pesan">Pesan</label>
                <textarea class="form-control" id="pesan" name="pesan" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
    </div>

    <?php include "footer.php"?>
