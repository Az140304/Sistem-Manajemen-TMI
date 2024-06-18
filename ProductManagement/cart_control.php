<?php
    session_start();

    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'reset_cart') {
            unset($_SESSION['id_item']);
            unset($_SESSION['nama_item']);
            unset($_SESSION['qty']);
            unset($_SESSION['harga']);
        }
    }
         header("Location:./tambah_order.php");
?>