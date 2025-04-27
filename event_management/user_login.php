<?php
session_start();
include('db_connect.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check user in database
    $sql = "SELECT * FROM register WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id']; // Store user id in session
        $_SESSION['username'] = $row['username'];
        header('Location: events_list.php'); // Redirect to events list
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Participant Login</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; }
        .login-box { width: 300px; margin: 100px auto; padding: 20px; background: white; box-shadow: 0px 0px 10px gray; border-radius: 8px; }
        .login-box input { width: 100%; padding: 10px; margin: 10px 0; }
        .login-box button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 5px; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Participant Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
