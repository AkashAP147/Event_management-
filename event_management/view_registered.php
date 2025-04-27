<?php include('db_connect.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>View Registrations</title>
</head>
<body>

<h1>Registered Users</h1>

<?php
$sql = "SELECT r.*, e.event_name FROM registrations r
        JOIN events e ON r.event_id = e.event_id
        ORDER BY r.registration_id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Event</th><th>Name</th><th>Email</th><th>Phone</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['event_name'] . "</td>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['user_email'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No registrations yet.";
}

$conn->close();
?>

</body>
</html>
