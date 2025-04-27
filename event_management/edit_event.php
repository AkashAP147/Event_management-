<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include('db_connect.php');

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $sql = "SELECT * FROM events WHERE event_id = $event_id";
    $result = $conn->query($sql);
    $event = $result->fetch_assoc();
}

if (isset($_POST['update'])) {
    $name = $_POST['event_name'];
    $date = $_POST['event_date'];
    $venue = $_POST['event_venue'];
    $desc = $_POST['event_description'];

    $sql = "UPDATE events 
            SET event_name='$name', event_date='$date', event_venue='$venue', event_description='$desc' 
            WHERE event_id=$event_id";

    if ($conn->query($sql) === TRUE) {
        echo "Event updated successfully!";
        header("Location: index.php"); // redirect back
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>
<body>

<h1>Edit Event</h1>

<form method="POST">
    <input type="text" name="event_name" value="<?php echo $event['event_name']; ?>" required><br><br>
    <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" required><br><br>
    <input type="text" name="event_venue" value="<?php echo $event['event_venue']; ?>" required><br><br>
    <textarea name="event_description" required><?php echo $event['event_description']; ?></textarea><br><br>
    <input type="submit" name="update" value="Update Event">
</form>

</body>
</html>
