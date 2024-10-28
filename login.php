<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ACACI</title>
    <link rel="icon" href="assets/images/newpng.png" type="image/png" />
    <style>
         :root {
        --primary-color: #8B0000; /* Rouge bordeaux */
        --secondary-color: #FFD700; /* Jaune */
        --text-color: #333333;
        --background-light: #FFF8DC; /* Cornsilk, un fond légèrement jaune */
        --white: #FFFFFF;
        --transition: all 0.3s ease-in-out;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: var(--background-light);
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-form {
        max-width: 300px;
        width: 100%;
        padding: 20px;
        background-color: var(--white);
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .login-form h2 {
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 20px;
    }

    .login-form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .login-form button {
        width: 100%;
        padding: 10px;
        background-color: var(--primary-color);
        color: var(--white);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: var(--transition);
    }

    .login-form button:hover {
        background-color: var(--secondary-color);
        color: var(--text-color);
    }
    </style>
</head>
<body>
    <main>
        <div class="container" >
            <form class="login-form" method="post" action="login_process.php">
                <h2>Connexion Administrateur</h2>
                <input type="text" name="username" placeholder="Nom d'utilisateur" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit" >Se Connecter</button>
            </form>
        </div>
    </main>
</body>
</html>