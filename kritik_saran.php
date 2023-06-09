<?php $title = "Kritik & Saran"; ?>
<?php include "header.php"; ?>
<?php
// Memeriksa apakah pengguna telah login
if (!isset($_SESSION["admin"])) {
    ob_end_clean();
    ob_end_flush();
    header("Location: login_admin.php");
    exit();
}
?>

<?php
    $row = null;
    if(isset($_GET["id"])){
        $prepare = mysqli_prepare($conn, "select * from kritik_saran where id = ?;");
        mysqli_stmt_bind_param($prepare, "i", $_GET["id"]);
        mysqli_stmt_execute($prepare);
        $sql = mysqli_stmt_get_result($prepare);
        $row = mysqli_fetch_assoc($sql);

        if($row != null){
            if($row["dibaca"] == 0){
                $prepare = mysqli_prepare($conn, "update kritik_saran set dibaca=1 where id=?;");
                mysqli_stmt_bind_param($prepare, "i", $_GET["id"]);
                mysqli_stmt_execute($prepare);
            }
        }
    }
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Kritik & Saran</h1>
            <?php if($row == null): ?>
                Tidak ada!
            <?php else: ?>
                Nama : <?php echo $row["nama"]; ?><br/>
                Email : <?php echo $row["email"]; ?><br/>
                Kritik & Saran :<br/>
                <?php echo $row["pesan"]; ?>
            <?php endif ?>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
