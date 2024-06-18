<?php
session_start();
include "config.php";

// Buat order baru
if (isset($_POST['add_delivery'])) {
    
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];

    // Masukkan data ke dalam query insert
    $query = "INSERT INTO pelanggan (alamat, nama, no_telepon, status_prioritas)
            VALUES ('$alamat', '$nama_pelanggan', '$no_telepon', 0)";

    $insert_pelanggan = mysqli_query($conn, $query) or die (mysqli_error($conn));

    // ambil id yang terakhir kali dimasukkan yaitu id_pelanggan
    // id_pelanggan diambil sendiri karena sudah di set auto-increment 
    $id_customer = $conn->insert_id;

    $sql = "INSERT INTO checkout 
            VALUES ('', '$id_customer', NULL , 'None')";

    // jika query yang dieksekusi berhasil
    if ($conn->query($sql) === TRUE) {

        // ambil id yang terakhir kali dimasukkan yaitu id_checkout
        // id_checkout diambil sendiri karena sudah di set auto-increment 
        $order_id = $conn->insert_id; 

        // ambil tabel produk kemudian hitung jumlah jenis produk yang ada
        $products = mysqli_query($conn, "SELECT * FROM produk");
        $products = mysqli_num_rows($products);

        // lakukan looping untuk memasukkan nilai variable ke dalam checkout_detail
        // sesuai id_produk
        for ($i = 0; $i < $products; $i++) {
            if (isset($_SESSION['qty'][$i])) {
                if ($_SESSION['qty'][$i] != 0) {
                    $id_produk_current = $_SESSION['id_item'][$i];
                    $nama_produk = $_SESSION['nama_item'][$i];
                    $quantity = $_SESSION['qty'][$i];
                    $price = $_SESSION['harga'][$i];
                    
                    $nproduk = mysqli_query($conn, "SELECT jumlah FROM produk WHERE id_produk = $id_produk_current");
                    $nproduk_rs = (mysqli_fetch_array($nproduk));
                    $jumlah_produk = (int)$nproduk_rs['jumlah'];
                    if ($jumlah_produk < $quantity) {
                        header("Location:./tambah_order.php?message=tidak_cukup");
                    } else {

                        $sql = "UPDATE produk
                                SET jumlah = jumlah - '$quantity'
                                WHERE id_produk = '$id_produk_current'";

                        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                        $sql = "INSERT INTO checkout_detail (id_order, id_produk, jumlah_beli, harga)
                        VALUES ('$order_id', '$id_produk_current', '$quantity', '$price')";

                        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                        // tutup koneksi
                        $conn->close();
                        
                        // redirect user admin untuk ke halaman dashboard delivery 
                        // untuk melihat hasil tambah order
                        header("Location:./DeliveryDashboard.php");
                    }

                    
                }
            }
        }

        
    }
}

// set pengantar untuk order yang tidak memiliki pengantar
    if (isset($_POST['edit_delivery'])) {
        $id_operasional = $_POST["id_operasional"];
        $id_checkout = $_POST["id_checkout"];

        $query = mysqli_query($conn, "UPDATE checkout 
                 SET id_operasional='$id_operasional',
                     status_pengiriman = 'On Delivery'
                 WHERE id_checkout = '$id_checkout'")

            or die(mysqli_error($conn));

        header("Location:./DeliveryDashboard.php");
    }

    if (isset($_POST['selesai_delivery'])) {
        $id_checkout = $_GET["id_checkout"];

        $query = mysqli_query($conn, "UPDATE checkout 
                 SET status_pengiriman = 'Selesai'
                 WHERE id_checkout = '$id_checkout'")

                 or die(mysqli_error($conn));
        header("Location:./DeliveryDashboard.php");
    }

    if (isset($_POST['hapus_delivery'])) {
        $id_checkout = $_GET["id_checkout"];

        $query = mysqli_query($conn, "DELETE FROM checkout 
                 WHERE id_checkout = '$id_checkout'")
                 or die(mysqli_error($conn));

        header("Location:./DeliveryDashboard.php");
    }
