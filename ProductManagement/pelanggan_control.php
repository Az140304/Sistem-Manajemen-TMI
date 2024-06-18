<html>
    <head>
        <title>Proses ADD</title>
        <meta http-equiv="refresh" content="0; homeCustomer.php"/>
    </head>
<body>
<?php
    session_start();
    include "config.php";


    if (isset($_POST['edit_pelanggan'])) {
        $id = $_POST["id_pelanggan"];
        $nama = $_POST["nama_pelanggan"];
        $no_telepon = $_POST["no_telepon"];
        $alamat = $_POST["alamat"];
        $status = $_POST["status_prioritas"];

        $query = mysqli_query($conn,"UPDATE pelanggan
                                     SET nama='$nama',
                                         no_telepon='$no_telepon',
                                         alamat='$alamat',
                                         status_prioritas='$status' where id_pelanggan = '$id'") 
                                         
                              or die (mysqli_error($conn));
    }

    if (isset($_POST['hapus_pelanggan'])) {
        $id = $_GET['id_pelanggan'];

        $query = mysqli_query($conn,"DELETE FROM pelanggan
                                     WHERE id_pelanggan='$id';") 
                                         
                              or die (mysqli_error($conn));
    }
?>

</body>
</html>