<?php
include 'config.php';
session_start();

if (empty($_SESSION['username'])) {
    header("location:loginAdmin.php?message=belum_login");
}

$id_checkout = $_GET['id_checkout'];
$checkout = mysqli_query($conn, "SELECT * FROM checkout WHERE id_checkout = '$id_checkout'");
$runner = mysqli_query($conn, "SELECT * FROM tim_operasional");

$checkout_rs = mysqli_fetch_array($checkout);


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
            border: 0px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 18%;
        }

        button {
            padding: 10px;
            border: none;
            background-color: #333;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            width: 10%;
        }

        .edit {
            background-color: #FFEB3B;
            color: black;
        }

        .selesai {
            background-color: rgb(0, 200, 100);
        }

        button:hover,
        td button:hover {
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
                <a href="homeCustomer.php">Customer</a>
                <a href="InventoryAdmin.php">Inventory</a>
                <a href="DeliveryDashboard.php" class="active">Pesanan</a>
                <a href="tambah_order.php">">Buat Pesanan</a>
                <a href="loginAdmin.php?message=logout">Exit</a>
        </nav>
    </div>
    <div class="main-content">
        <h2>Edit Data Produk</h2>
        <form method="POST" action="delivery_control.php">
            <table>
                <tr>
                    <td>ID Checkout</td>
                    <td><input type="text" name="id_checkout" placeholder="ID Produk" style="background-color: grey" value="<?php echo $id_checkout ?>" readonly></td>
                </tr>
                <tr>
                    <td>Pengantar</td>
                    <td>
                        <select name="id_operasional">
                        <?php while ($runner_rs = mysqli_fetch_array($runner)) {
                            ?><option value="<?php echo $runner_rs['id_operasional'] ?>"> <?php echo $runner_rs['nama'] ?> </option><?php
                        }?>
                        </select>
                    </td>
                </tr>
            </table>
            <button type="submit" name="edit_delivery">Edit</button>
        </form>
    </div>
</body>

</html>