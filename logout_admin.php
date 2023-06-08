<?php
// Memulai sesi
session_start();

// Menghapus session admin
unset($_SESSION["admin"]);

// Menghancurkan semua sesi
session_destroy();

// Mengarahkan pengguna ke halaman login_admin.php
header("Location: login_admin.php");
exit();
?>
