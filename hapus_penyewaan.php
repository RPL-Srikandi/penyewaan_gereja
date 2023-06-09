<?php $title="Hapus Penyewaan - Penyewaan Ruangan Gereja"; ?>
<?php include "header.php"?>

      <?php 
      // Memeriksa apakah pengguna telah login
        if (!isset($_SESSION["admin"])) {
            ob_end_clean();
            ob_end_flush();
            header("Location: login_admin.php");
            exit();
        }
        ?>

    <h1>Hapus Penyewaan - Penyewaan Ruangan Gereja</h1>

    <?php
    // Koneksi ke database
    $connection = mysqli_connect("localhost", "id20884196_user_penyewaan", "Db_User_Penyewaan_Gereja_12345", "id20884196_penyewaan_gereja");
    
    // Memeriksa koneksi
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        // Menghapus data penyewaan berdasarkan ID
        mysqli_query($connection, "DELETE FROM penyewaan WHERE id = $id");
        
        // Kembali ke halaman admin setelah menghapus penyewaan
        header("Location: admin.php");
        exit;
    }
    
    // Menutup koneksi
    mysqli_close($connection);
    ?>

    <?php include "footer.php"?>