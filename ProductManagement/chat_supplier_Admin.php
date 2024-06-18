<?php
include 'config.php';
session_start();

if (empty($_SESSION['username'])) {
    header("location:loginAdmin.php?message=belum_login");
}

$select = mysqli_query($conn, "select * from supplier");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 15%;
            background-color: #2c3e50;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .sidebar .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .sidebar nav {
            width: 100%;
        }

        .sidebar nav a {
            text-decoration: none;
            color: white;
            padding: 10px 0;
            width: 100%;
            text-align: center;
            display: block;
            margin: 5px 0;
        }

        .sidebar nav a.active,
        .sidebar nav a:hover {
            background-color: #e74c3c;
            border-radius: 5px;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }

        .chat-container {
            display: flex;
            height: calc(100vh - 40px);
        }

        .contacts {
            width: 25%;
            padding: 20px;
            box-sizing: border-box;
        }

        .contact-group {
            margin-bottom: 20px;
        }

        .contact-group h3 {
            margin-top: 0;
        }

        .contact {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            background-color: #b2fab4;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: left;
        }

        .contact:hover {
            background-color: #a1e9a3;
        }

        .chat {
            width: 75%;
            padding: 20px;
            background-color: #d1e0fc;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .messages {
            overflow-y: auto;
            display: flex;
            gap: 10px 10px;
            flex-direction: column;

            margin-bottom: 10px;
            border: 0px solid black;
        }

        .message {
            background-color: white;
            border-radius: 5px;
            padding: 10px;
            width: 50%;
            margin: 5px 0;
        }

        .message strong {
            display: block;
        }

        .current-receiver {
            display: flex;
            padding: 10px;
            flex-direction: row;
            align-items: center; 
            gap: 10px 10px;
        }

        .current-receiver img {
            width: 40px;
        }


        .input-container {
            display: flex;
            border: 0px solid black;
            gap: 20px 20px;
        }

        .input-container input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
        }


        .input-container button {
            padding: 10px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .input-container button:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
        }

        .chat h2 {
            align-self: center;

        }

        .datetime {
            text-align: right;
            font-size: 12px;
            align-self: flex-end;
            margin-top: 10px;
            opacity: 0.5;

        }
    </style>
</head>

<body>
    <div class="sidebar">
        <img src="foto/logo.png" alt="TMI Logo" class="logo">
        <nav>
            <a href="chat_customer_Admin.php">Chat Customer</a>
            <a href="chat_staff_Admin.php">Chat Staff</a>
            <a href="chat_supplier_Admin.php" class="active">Chat Suppliers</a>
            <a href="homeCustomer.php">Customer</a>
            <a href="InventoryAdmin.php">Inventory</a>
            <a href="DeliveryDashboard.php">Pesanan</a>
            <a href="tambah_order.php">Buat Pesanan</a>
            <a href="loginAdmin.php?message=logout">Exit</a>
        </nav>
    </div>
    <div class="main-content">
    <div class="chat-container">
            <div class="contacts">
            <div class="contact-group">
                    <h3>Supplier</h3>
                    <!-- ini nanti perulangan -->
                    <?php
                    while ($supplier = mysqli_fetch_array($select)) {
                    ?>
                        <a href="chat_supplier_Admin.php?id_supplier=<?php echo $supplier['id_supplier'] ?>">
                            <button class="contact" type="button"><?php echo $supplier['nama_supplier'] ?></button>
                        </a>
                    <?php
                    }
                    ?>
                </div>

            </div>
            <div class="chat">
                <?php
                if (isset($_GET['id_supplier'])) {
                    $id_supplier = $_GET['id_supplier'];
                    $name = mysqli_query($conn, "SELECT * FROM supplier WHERE id_supplier = $id_supplier");
                    $name_rs = mysqli_fetch_array($name);
                ?>
                    <div class="messages">
                    <div class="current-receiver">
                        <img src="./foto/profile.png" alt="" >
                        <h3><?php echo $name_rs['nama_supplier'] ?></h3>
                    </div>
                        <?php
                        
                        

                        $message = mysqli_query($conn, "SELECT * FROM message WHERE id_receiver = $id_supplier AND receiver_type = 'supplier'");
                        if ($message->num_rows > 0) {
                            while ($message_rs = mysqli_fetch_array($message)) {
                        ?>
                                <div class="message">
                                    <?php
                                    echo $message_rs['message'];
                                    ?>
                                    <br>
                                    <div class="datetime">
                                        <?php
                                        echo $message_rs['timestamp'];
                                        ?>
                                    </div>

                                </div>
                            <?php
                            }
                        } else { ?>
                            <h2>Mulai pesan baru</h2> <?php
                                                    }
                                                        ?>
                    </div>

                    <form method="POST" action="chat_control.php?id_receiver=<?php echo $id_supplier ?>&user=supplier">
                        <div class="input-container">
                            <input type="text" name="pesan" placeholder="masukkan pesan">
                            <button type="submit" name="add_message">Kirim</button>
                        </div>
                    </form>
                <?php
                } else {
                ?> <h2>Click pada user untuk membuka pesan</h2>
                <?php } ?>

            </div>
        </div>
    </div>
</body>

</html>
