<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<?php
// Memeriksa apakah sesi sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function active($currect_page){
    $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
    $url = end($url_array);  
    if($currect_page == $url){
        echo 'active';
    } 
}
?>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
<div class="container-fluid">
    <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="Avatar Logo" style="width:180px;" class="">
    </a>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= active('index.php')?>" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= active('about.php')?>" href="about.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= active('jadwal.php')?>" href="jadwal.php">Jadwal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= active('proses_penyewaan.php')?>" href="proses_penyewaan.php">Penyewaan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= active('kritiksaran.php')?>" href="kritiksaran.php">Kritik dan Saran</a>
            </li>
        </ul>
        <?php if (isset($_SESSION['admin'])) { ?>
<?php
    $conn = mysqli_connect("localhost", "root", "", "penyewaan_gereja");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $hasil = mysqli_query($conn, "select count(*) as jumlah from kritik_saran where dibaca = 0;");
    $hasil = mysqli_fetch_assoc($hasil);
?>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="notifikasi.php">Notifikasi(<?php echo $hasil["jumlah"]; ?>)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout_admin.php">Logout</a>
                </li>
            </ul>
        <?php } else { ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login_admin.php">Admin Login</a>
                </li>
            </ul>
        <?php } ?>
    </div>
</div>
</nav>

<div class="content-container"></div>
