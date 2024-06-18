<?php 
    session_start();
    include "config.php";

    if (isset($_POST['add_message'])) {

        if ($_GET['user'] == "customer") {
            $id_receiver = $_GET["id_receiver"];
            $message = $_POST["pesan"];

            $query = "INSERT INTO message (id_receiver, message, receiver_type)
                      VALUES ('$id_receiver', '$message', 'customer')";

            $insert_pelanggan_message = mysqli_query($conn, $query) or die (mysqli_error($conn));

            header("Location:./chat_customer_Admin.php?id_pelanggan=$id_receiver"); 
        }

        if ($_GET['user'] == "staff") {
            $id_receiver = $_GET["id_receiver"];
            $message = $_POST["pesan"];

            $query = "INSERT INTO message (id_receiver, message, receiver_type)
                      VALUES ('$id_receiver', '$message', 'staff')";

            $insert_staff_message = mysqli_query($conn, $query) or die (mysqli_error($conn));

            header("Location:./chat_staff_Admin.php?id_operasional=$id_receiver"); 
        }

        if ($_GET['user'] == "supplier") {
            $id_receiver = $_GET["id_receiver"];
            $message = $_POST["pesan"];

            $query = "INSERT INTO message (id_receiver, message, receiver_type)
                      VALUES ('$id_receiver', '$message', 'supplier')";

            $insert_pelanggan = mysqli_query($conn, $query) or die (mysqli_error($conn));

            header("Location:./chat_supplier_Admin.php?id_supplier=$id_receiver"); 
        }
        
    }
?>