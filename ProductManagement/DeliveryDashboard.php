<?php 

    include 'config.php';
    session_start();

    if (empty($_SESSION['username'])) {
        header("location:loginAdmin.php?message=belum_login");
    }
    
    $order = mysqli_query($conn, "SELECT c.*, p.nama AS nama_pelanggan, p.alamat AS alamat_pelanggan , o.nama AS nama_pengantar FROM checkout c 
                                  LEFT JOIN pelanggan p ON c.id_pelanggan = p.id_pelanggan 
                                  LEFT JOIN tim_operasional o ON c.id_operasional = o.id_operasional;");
    
    $order_details = mysqli_query($conn, "select * from checkout_detail");
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
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .chat-container {
            display: flex;
            height: 100%;
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
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: grey;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .messages {
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column-reverse;
            height: 100vh; 
        }

        .keranjang {
            width: 100%;
            height: 100%;
            background-color: white;
            flex-direction: column;
            display: flex;
            border-radius: 5px;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .header {
            display: flex;
            font-weight: 700;
            font-size: 17px;
            
        }

        .header .name-header,
        .header .qty-header, 
        .header .status-header,
        .header .action-header {
            flex: 1;
            text-align: center;
            gap: 0px 10px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item .name,
        .item .quantity,
        .item .status {
            flex: 1;
            margin: 0 10px;
        }

        .keranjang .actions {
            display: flex;
            padding-top: 10px;
            padding-bottom: 10px;
            align-self: flex-end;
        }

        .keranjang .actions button {
            margin-left: 5px;
            align-items: flex-end;
           
            padding: 5px 10px;
        }

        .extra-info {
            margin: 20px;
        }

        .extra-info .status,
        .extra-info .alamat,
        .extra-info .pengantar {
            margin-top: 20px;
            margin-bottom: 20px;

        }

        button {
            padding: 10px;
            border: none;
            background-color: #333;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            padding: 20px;
        }

        .edit {
            background-color: #FFEB3B;
            color: black;
        }

        .selesai {
            background-color: rgb(0, 200, 100);
        }

    </style>
</head>

<body>
    <div class="sidebar">
        <img src="foto/logo.png" alt="TMI Logo" class="logo">
        <nav>
                <a href="chat_customer_Admin.php">Chat Customer</a>
                <a href="chat_staff_Admin.php">Chat Staff</a>
                <a href="chat_supplier_Admin.php">Chat Suppliers</a>
                <a href="homeCustomer.php">Customer</a>
                <a href="InventoryAdmin.php">Inventory</a>
                <a href="DeliveryDashboard.php" class="active">Pesanan</a>
                <a href="tambah_order.php">Buat Pesanan</a>
                <a href="loginAdmin.php?message=logout">Exit</a>
        </nav>
    </div>
    <div class="main-content">
        <h1>Dashboard Delivery</h1>
        <div class="chat-container">
            <div class="chat">
                <div class="messages">
                    <?php
                    while ($order_rs = mysqli_fetch_array($order)) {
                        $id_checkout = $order_rs['id_checkout'];
                        $nama_pelanggan = $order_rs['nama_pelanggan'];


                        ?><div class="keranjang"> 
                            <h2>Order #<?php echo $id_checkout ?></h2>
                            <h3>Nama Pelanggan : <?php echo $nama_pelanggan ?></h3>
                            <div class="header">
                                <div class="name-header">KODE PRODUK</div>
                                <div class="qty-header">JUMLAH BELI</div>
                                <div class="action-header"> </div>
                            </div>
                          <?php 
                            $order_details = mysqli_query($conn, "SELECT * from checkout_detail WHERE id_order = '$id_checkout'");
                            while ($order_details_rs = mysqli_fetch_array($order_details)) {
                                ?> 
                                    <div class="item">
                                        <div class="name">Barang #<?php echo $order_details_rs['id_produk'] ?></div>
                                        <div class="quantity"><?php echo $order_details_rs['jumlah_beli'] ?></div>
                                    </div>
                                <?php
                            }
                            
                          ?>
                            <div class="extra-info">
                                <div class="status">Status Pengiriman : <?php echo $order_rs['status_pengiriman'] ?></div>
                                <div class="alamat">Alamat : <?php echo $order_rs['alamat_pelanggan'] ?></div>
                                <div class="Pengantar">Pengantar : <?php echo $order_rs['nama_pengantar'] ?></div>
                            </div>
                            <div class="actions">
                                
                                <a href="edit_delivery.php?id_checkout=<?php echo $id_checkout?>">
                                    <button type="button" class="button edit">Edit Delivery</button>
                                </a>
                                <form method="POST" action="delivery_control.php?id_checkout=<?php echo $id_checkout?>">
                                    <button type="submit" class="button hapus" name="hapus_delivery">Hapus</button>
                                    <button type="submit" class="button selesai" name="selesai_delivery">Selesai</button>
                                </form> 
                            </div>
                          </div>    
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
