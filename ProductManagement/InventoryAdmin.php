<?php
include 'config.php';
session_start();

if (empty($_SESSION['username'])) {
    header("location:loginAdmin.php?message=belum_login");
}

$query = mysqli_query($conn, "select * from produk");

$count = mysqli_query($conn, "select COUNT(*) as total from produk");
$count = $count->fetch_assoc();

$low_count = mysqli_query($conn, "select COUNT(*) as total from produk where jumlah < 5 and jumlah > 0");
$low_count = $low_count->fetch_assoc();

$empty_count = mysqli_query($conn, "select COUNT(*) as total from produk where jumlah = 0");
if ($empty_count->num_rows > 0) {
    // Fetch result
    $empty_count = $empty_count->fetch_assoc();
} else {
    echo "0 results";
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
            justify-content: space-around;
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
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            cursor: pointer;
            width: 80px;
        }

        .edit {
            background-color: #FFEB3B;
            
            color: black;
        }

        .hapus {
            background-color: #F44336;
            text-align: center;
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
                <a href="homeCustomer.php">Customer</a>
                <a href="InventoryAdmin.php" class="active">Inventory</a>
                <a href="DeliveryDashboard.php">Pesanan</a>
                <a href="tambah_order.php">Buat Pesanan</a>
                <a href="loginAdmin.php?message=logout">Exit</a>
        </nav>
    </div>
    <div class="main-content">
        <div class="dashboard">
            <div class="card total-produk">
                <h3>Total jenis produk</h3>
                <p><?php echo $count['total'] ?></p>
            </div>
            <div class="card low-stock">
                <h3>Stok produk rendah</h3>
                <p><?php echo $low_count['total'] ?></p>
            </div>
            <div class="card empty-stock">
                <h3>Stok Produk Habis</h3>
                <p><?php echo $empty_count['total'] ?></p>
            </div>
        </div>
        <h2>Inventory Produk</h2>
        <table id="myTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Stocks</th>
                    <th>Category</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>

                <!-- perulangan -->
                <?php
                $query = mysqli_query($conn, "select * from produk");

                while ($produk = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $produk['nama_produk'] ?></td>
                        <td><?php echo $produk['jumlah'] ?></td>
                        <td><?php echo $produk['kategori'] ?></td>
                        <td><?php echo $produk['harga'] ?></td>
                        <td style="border: 0px; 
                                   display: flex;
                                   gap: 5px 5px;">
                        <a href="edit_produk.php?id_produk=<?php echo $produk['id_produk'] ?>">
                            <button type="button" class="button edit">Edit</button>
                        </a>
                        <form action="inv_control.php?id_produk=<?php echo $produk['id_produk'] ?>" method="post">
                            <button type="submit" class="button hapus" name="hapus_produk">Hapus</button>
                        </form>
                        </td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h2>Tambah Data Produk Baru</h2>
        <form method="POST" action="inv_control.php">
            <div class="add-section">
                <input type="text" name="nama_produk" placeholder="Product Name"  required>
                <input type="number" name="jumlah" placeholder="Stocks "  required>
                <input type="text" name="kategori" placeholder="Category"  required>
                <input type="number" name="harga" placeholder="Price"  required>
                <button type="submit" name="tambah_produk" style=" background-color: #4CAF50;width: 200px;">Tambahkan Produk</button>
            </div>
        </form>
    </div>
    <script>
    </script>
</body>

</html>