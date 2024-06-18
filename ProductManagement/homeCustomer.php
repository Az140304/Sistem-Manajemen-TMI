<?php
include 'config.php';
session_start();

if (empty($_SESSION['username'])) {
    header("location:loginAdmin.php?message=belum_login");
}

$query = mysqli_query($conn, "select * from pelanggan");

$total = mysqli_query($conn, "select COUNT(*) as total from pelanggan");
$total_rs = $total->fetch_assoc();

$prioritas = mysqli_query($conn, "select COUNT(*) as total from pelanggan where status_prioritas = 'prioritas'");
$prioritas_rs = $prioritas->fetch_assoc();

$pengunjung = mysqli_query($conn, "select COUNT(*) as total from pelanggan where status_prioritas = 'non-prioritas'");
$pengunjung_rs = $pengunjung->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard</title>
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

        .dashboard {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .card {
            padding: 20px;
            border-radius: 5px;
            color: white;
            text-align: center;
            width: 30%;
        }

        .total-produk {
            background-color: #4CAF50;
        }

        .low-stock {
            background-color: #FFEB3B;
            color: #000;
        }

        .empty-stock {
            background-color: #F44336;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .add-section {
            display: flex;
            justify-content: space-around;
        }

        .add-section input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 18%;
        }

        .add-section button, td button {
            padding: 10px;
            border: none;
            background-color: #333;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            width: 18%;
        }

        .edit {
            background-color: #FFEB3B;
            color: black;
        }

        .hapus {
            background-color: #F44336;
        }
        .add-section button:hover, td button:hover {
            filter: brightness(1.3);
        }

        tr.clicked {
            background-color: #d1e7dd !important;
            /* Change this color to your preferred clicked row color */
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
                <a href="homeCustomer.php" class="active">Customer</a>
                <a href="InventoryAdmin.php">Inventory</a>
                <a href="DeliveryDashboard.php">Pesanan</a>
                <a href="tambah_order.php">Buat Pesanan</a>
                <a href="loginAdmin.php?message=logout">Exit</a>
        </nav>
    </div>
    <div class="main-content">
        <div class="dashboard">
            <div class="card total-produk">
                <h3>Total Pelanggan</h3>
                <p><?php echo $total_rs['total'] ?></p>
            </div>
            <div class="card low-stock">
                <h3>Jumlah Prioritas Pelanggan</h3>
                <p><?php echo $prioritas_rs['total'] ?></p>
            </div>
            <div class="card empty-stock">
                <h3>Jumlah Non-Prioritas Pelanggan</h3>
                <p><?php echo $pengunjung_rs['total'] ?></p>
            </div>
        </div>
        <h2>Data Pelanggan</h2>
        <table id="myTable">
            <thead>
                <tr>
                    <th>ID Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Status Prioritas</th>
                </tr>
            </thead>
            <tbody>

                <!-- perulangan -->
                <?php

                while ($pelanggan = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $pelanggan['id_pelanggan'] ?></td>
                        <td><?php echo $pelanggan['nama'] ?></td>
                        <td><?php echo $pelanggan['no_telepon'] ?></td>
                        <td><?php echo $pelanggan['alamat'] ?></td>
                        <td><?php echo $pelanggan['status_prioritas'] ?></td>
                        <td style="border: 0px">
                        <a href="edit_pelanggan.php?id_pelanggan=<?php echo $pelanggan['id_pelanggan'] ?>">
                            <button type="button" class="button edit">Edit</button>
                        </a>
                        <a href="pelanggan_control.php?id_pelanggan=<?php echo $pelanggan['id_pelanggan'] ?>">
                            <button type="button" class="button hapus">Hapus</button>
                        </a>
                        </td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
    </script>
</body>

</html>