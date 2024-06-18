<?php
include 'config.php';
session_start();

if (empty($_SESSION['username'])) {
    header("location:loginAdmin.php?message=belum_login");
}


$products = mysqli_query($conn, "SELECT * FROM produk");
$products = mysqli_num_rows($products);

if(isset($_GET['message'])){
    if ($_GET['message'] == "tidak_cukup") {
        ?><script> alert('Jumlah produk tidak cukup untuk memenuhi pesanan') </script><?php
    }
}

if (!isset($_SESSION['qty'])) {
    for ($i = 0; $i < $products; $i++) {
        $_SESSION['qty'][$i] = 0;
    }
}

if (isset($_POST['add_cart'])) {
    if (isset($_GET['id_produk'])) {
        $id_produk = $_GET["id_produk"];

        $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk=$id_produk");

        $data = mysqli_fetch_array($query);
        $_SESSION['id_item'][$id_produk] =  $id_produk;
        $_SESSION['nama_item'][$id_produk] = $data['nama_produk'];
        $_SESSION['qty'][$id_produk] = $_SESSION['qty'][$id_produk] + $_POST['jumlah'];
        $_SESSION['kategori'][$id_produk] = $data['kategori'];
        $_SESSION['harga'][$id_produk] = $data['harga'];

        $_SESSION['subtotal'][$id_produk] = $_SESSION['qty'][$id_produk] * $_SESSION['harga'][$id_produk];
    }
}

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
            gap: 10px 10px;
        }

        .add-section input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 18%;
        }

         button {
            padding: 10px;
            border: none;
            display: inline-block;
            background-color: #333;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit {
            background-color: #FFEB3B;
            color: black;
        }

        .tambah, .tambah-order {
            background-color: rgb(0, 200, 100);
        }

        .hapus {
            background-color: rgb(255, 0, 0);
            color: white;
            
        }

        .tambah-order {
            display: block;
            margin-left: auto;
            margin-right: 0;

        }

        .add-section button:hover,
        td button:hover {
            filter: brightness(1.3);
        }

        tr.clicked {
            background-color: #d1e7dd !important;
            /* Change this color to your preferred clicked row color */
        }

        input[type=number] {
            border: 1px solid grey;
            height: 30px;
            width: 200px;
            border-radius: 5px;
            background-color: white;
            color: black;
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
                <a href="DeliveryDashboard.php">Pesanan</a>
                <a href="tambah_order.php" class="active">Buat Pesanan</a>
                <a href="loginAdmin.php?message=logout">Exit</a>
        </nav>
    </div>
    <div class="main-content">
        <h1>Buat Pesanan Baru</h1>
        <h2>Inventory Produk</h2>
        <table id="myTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Stocks</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th style="border: none;"></th>
                </tr>
            </thead>
            <tbody>

                <!-- perulangan -->
                <?php
                $query = mysqli_query($conn, "select * from produk");

                while ($produk = mysqli_fetch_array($query)) {
                    $id_produk = $produk['id_produk'];
                ?>
                    <tr>
                        <td><?php echo $produk['nama_produk'] ?></td>
                        <td><?php echo $produk['jumlah'] ?></td>
                        <td><?php echo $produk['kategori'] ?></td>
                        <td><?php echo $produk['harga'] ?></td>
                        <td style="border: none;">
                            <form action="tambah_order.php?id_produk=<?php echo $id_produk ?>" method="post">
                                <input type="number" name="jumlah" placeholder="Jumlah barang yang dibeli">
                                <button type="submit" name="add_cart" class="tambah">Tambah</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <form action="delivery_control.php" method="post">
            <h2>Masukkan data pelanggan</h2>
            <div class="add-section">
                
                <input type="text" name="nama_pelanggan" placeholder="Nama Pelanggan">
                <input type="number" name="no_telepon" placeholder="No HP">
                <input type="text" name="alamat" placeholder="Alamat">
            </div>
            <h2>CART 
            
            
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Beli</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th style="border: none;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < $products; $i++) {
                        if (isset($_SESSION['qty'][$i])) {
                            if ($_SESSION['qty'][$i] != 0) {
                    ?>
                                <tr>
                                    <td><?php echo $_SESSION['id_item'][$i] ?></td>
                                    <td><?php echo $_SESSION['nama_item'][$i] ?></td>
                                    <td><?php echo $_SESSION['qty'][$i] ?></td>
                                    <td><?php echo $_SESSION['harga'][$i] ?></td>
                                    <td><?php echo $_SESSION['subtotal'][$i] ?></td>

                                </tr>
                    <?php
                            }
                        }
                    }
                    ?>
                    <tr>
                            <td style="border: none;">
                                <a href="cart_control.php?action=reset_cart">Reset Cart</a>
                            </td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;">
                                <button type="submit" name="add_delivery" class="tambah-order">Tambah order</button>
                            </td>
                        </tr>
                </tbody>
            </table>
            
        </form>
    </div>
    <script>
    </script>
</body>

</html>