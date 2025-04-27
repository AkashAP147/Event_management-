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

    $sql = "DELETE FROM events WHERE event_id=$event_id";

    if ($conn->query($sql) === TRUE) {
        echo "Event deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

header("Location: index.php"); // redirect back to index
?>
