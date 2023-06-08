<?php
$title = "Admin Login - Penyewaan Ruangan Gereja";
include "header.php";

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

// Fungsi untuk mengatur session admin
function setAdminSession($username)
{
    $_SESSION["admin"] = $username;
}

// Cek apakah session admin sudah ada, jika ya, redirect ke halaman admin
if (isset($_SESSION["admin"])) {
    header("Location: admin.php");
    exit();
}

// Cek apakah form login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectDatabase();

    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    // Melakukan sanitasi pada input username untuk menghindari serangan SQL injection
    $input_username = mysqli_real_escape_string($conn, $input_username);

    // Menyiapkan pernyataan SQL dengan prepared statement
    $query = "SELECT * FROM user WHERE username = ?";
    $statement = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($statement, "s", $input_username);
    mysqli_stmt_execute($statement);

    // Mengambil hasil query
    $result = mysqli_stmt_get_result($statement);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Membandingkan password yang diberikan dengan password di database (dalam bentuk hash md5)
        if (md5($input_password) == $user['password']) {
            // Jika username dan password benar, set session admin dan redirect ke halaman admin
            setAdminSession($input_username);
            header("Location: admin.php");
            exit();
        }
    }

    // Jika username atau password salah, tampilkan pesan error
    echo '<div class="container"><div class="alert alert-danger" role="alert">Username atau password salah.</div></div>';

    // Menutup koneksi database
    mysqli_close($conn);
}
?>

<div class="container">
    <h1>Admin Login - Penyewaan Ruangan Gereja</h1>

    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php include "footer.php" ?>
