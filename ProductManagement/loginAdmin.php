<?php
//include 'config.php';
session_start();

if (isset($_GET['message'])) {
    if ($_GET['message'] == "belum_login") {
        ?> 
            <script>
                alert("Maaf, mohon login terlebih dahulu");
            </script>
        <?php
    } else if ($_GET['message'] == "logout") {
            unset($_SESSION['username']);
        ?> 
            <script>
                alert("Berhasil Logout");
            </script>
        <?php
    }
}
 
 
if (isset($_POST['username']) && isset($_POST['password'])) {
    if($_POST['username'] == "admin" && $_POST['password'] == "123"){
        $_SESSION['username'] = $_POST['username'];

        header("Location: HomeCustomer.php");
        exit();
    } else {
        ?> 
            <script>
                alert("Username atau password yang dimasukkan salah");
            </script>
        <?php
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Mandiri Indonesia Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 100%;
        }

        .left {
            flex: 1;
        }

        .left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            text-align: center;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            font-size: 16px;
            color: white;
            background-color: #e74c3c;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <img src="foto/image.jpg" alt="Store Image">
        </div>
        <div class="right">
            <div class="login-box">
                <img src="foto/logo.png" alt="TMI Logo" class="logo">
                <form action="loginAdmin.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>