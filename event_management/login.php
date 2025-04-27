<?php
session_start();
include('db_connect.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple hardcoded admin credentials
    $admin_user = "Akash";
    $admin_pass = "Akash123"; // (You can change this later)

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>

<h1>Admin Login</h1>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <input type="submit" name="login" value="Login">
</form>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>

</body>
</html>
