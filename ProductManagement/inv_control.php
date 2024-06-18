<html>
    <head>
        <title>Proses ADD</title>
        <meta http-equiv="refresh" content="0; InventoryAdmin.php"/>
    </head>
<body>
<?php
    include "config.php";
    if (isset($_POST['tambah_produk'])) {
        $nama = $_POST["nama_produk"];
        $jumlah = $_POST["jumlah"];
        $kategori = $_POST["kategori"];
        $harga = $_POST["harga"];

        $query = mysqli_query($conn,"INSERT INTO produk VALUES('','$nama','$jumlah','$kategori','$harga')")
        or die (mysqli_error($conn));
    }

    if (isset($_POST['edit_produk'])) {
        $id = $_POST["id_produk"];
        $nama = $_POST["nama_produk"];
        $jumlah = $_POST["jumlah"];
        $kategori = $_POST["kategori"];
        $harga = $_POST["harga"];

        $query = mysqli_query($conn,"UPDATE produk 
                                     SET nama_produk='$nama',
                                         jumlah='$jumlah',
                                         kategori='$kategori',
                                         harga='$harga' where id_produk = '$id'") 
                                         
                              or die (mysqli_error($conn));
    }

    if (isset($_POST['hapus_produk'])) {
        $id_produk = $_GET['id_produk'];

        $query = mysqli_query($conn,"DELETE FROM produk 
                                     WHERE id_produk='$id_produk';") 
                                         
                              or die (mysqli_error($conn));
    }
?>

</body>
</html>