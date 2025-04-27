<?php
session_start();
include('db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit();
}

// Fetch upcoming events
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upcoming Events</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; margin: 0; padding: 0; }
        .header { background: #007bff; color: white; padding: 15px; text-align: center; }
        .events-container { display: flex; flex-wrap: wrap; justify-content: center; margin: 20px; }
        .event-card { background: white; width: 250px; margin: 10px; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px gray; cursor: pointer; }
        .event-card:hover { background: #e0f0ff; }
        .popup-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); justify-content: center; align-items: center; }
        .popup-content { background: white; padding: 20px; border-radius: 10px; width: 300px; position: relative; }
        .close-btn { position: absolute; top: 10px; right: 10px; cursor: pointer; font-size: 18px; }
        .popup-content input { width: 100%; padding: 8px; margin: 10px 0; }
        .popup-content button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 5px; }
    </style>
</head>
<body>

<div class="header">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <a href="logout.php" style="color: white; text-decoration: underline;">Logout</a>
</div>

<div class="events-container">
    <?php
    if ($result->num_rows > 0) {
        while ($event = $result->fetch_assoc()) {
            ?>
            <div class="event-card" onclick="openPopup('<?php echo $event['event_id']; ?>', '<?php echo htmlspecialchars($event['event_name']); ?>')">
                <h3><?php echo $event['event_name']; ?></h3>
                <p><?php echo date('d M Y', strtotime($event['event_date'])); ?></p>
                <p><?php echo $event['event_venue']; ?></p>
            </div>
            <?php
        }
    } else {
        echo "<p>No upcoming events.</p>";
    }
    ?>
</div>

<!-- Popup Registration Form -->
<div class="popup-overlay" id="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">❌</span>
        <h3 id="eventTitle">Register for Event</h3>
        <form method="POST" action="register_for_event.php">
            <input type="hidden" name="event_id" id="eventId">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="phone" placeholder="Your Phone" required>
            <button type="submit" name="register_event">Register</button>
        </form>
    </div>
</div>

<script>
    function openPopup(eventId, eventName) {
        document.getElementById('popup').style.display = 'flex';
        document.getElementById('eventId').value = eventId;
        document.getElementById('eventTitle').innerText = "Register for " + eventName;
    }
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }
</script>

</body>
</html>
