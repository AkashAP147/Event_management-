<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Event</title>
</head>
<body>

<h1>Add Event</h1>

<form method="POST">
    <input type="text" name="event_name" placeholder="Event Name" required><br><br>
    <input type="date" name="event_date" required><br><br>
    
    <input type="text" name="event_venue" placeholder="Venue" required><br><br>
    <textarea name="event_description" placeholder="Description" required></textarea><br><br>
    <input type="time" id="event_time" name="event_time" required><br><br>
    <input type="submit" name="submit" value="Add Event">
</form>

<?php
if(isset($_POST['submit'])){
    $name = $_POST['event_name'];
    $date = $_POST['event_date'];
    $venue = $_POST['event_venue'];
    $desc = $_POST['event_description'];
    $time =$_POST['event_time'];


    $sql = "INSERT INTO events (event_name, event_date, event_description, event_time, event_venue)
        VALUES ('$name', '$date', '$desc', '$time', '$venue')";


    if ($conn->query($sql) === TRUE) {
        echo "New event created successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

</body>
</html>
