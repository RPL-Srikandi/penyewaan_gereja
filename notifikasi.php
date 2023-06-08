<?php $title = "Notifikasi Kritik & Saran"; ?>
<?php include "header.php"; ?>

<?php

    $sql = mysqli_query($conn, "select * from kritik_saran;");
    $rows = mysqli_fetch_all($sql, MYSQLI_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Notifikasi Kritik & Saran</h1>

            <div class="list-group">
                <?php foreach($rows as $row): ?>
                <a href="kritik_saran.php?id=<?php echo $row["id"]; ?>" class="list-group-item list-group-item-action <?php echo ($row["dibaca"] == 0 ? "list-group-item-primary" : ""); ?>"><?php echo $row["nama"]; ?> &lt;<?php echo $row["email"]; ?>&gt;</a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
