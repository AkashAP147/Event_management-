<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>


<?php
include('db_connect.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add jQuery -->

</head>
<body>
  <!-- Registration Modal -->
<div id="registerModal" style="display:none; position:fixed; top:20%; left:35%; width:30%; background:white; border:2px solid black; padding:20px; z-index:1000;">
    <h2>Register for Event</h2>
    <form id="registrationForm">
        <input type="hidden" name="event_id" id="modal_event_id">
        <input type="text" name="name" placeholder="Your Name" required><br><br>
        <input type="email" name="email" placeholder="Your Email" required><br><br>
        <input type="phone" name="phone" placeholder="Your Phone" required><br><br>
        <input type="submit" value="Register">
        
    </form>
    <button onclick="closeModal()">Close</button>
</div>


<h1>Upcoming Events</h1>
<input type="text" id="searchInput" placeholder="Search events..." onkeyup="searchEvents()" style="padding:8px; width:300px;">
<br><br>

<a href="logout.php">🔒 Logout</a><br><br>

<a href="add_event.php">➕ Add New Event</a><br><br>
<a href="view_registered.php" class="btn">👥 View Registered Users</a>
<?php
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

echo "<div id='eventsList'>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='event'>";
        echo "<h2>" . $row["event_name"] . "</h2>";
        echo "<p><strong>Date:</strong> " . $row["event_date"] . "</p>";
        echo "<p><strong>Venue:</strong> " . $row["event_venue"] . "</p>";
        echo "<p>" . $row["event_description"] . "</p>";
        echo "<a href='#' onclick='openModal(" . $row["event_id"] . ")'>Register</a>";

        echo " | <a href='edit_event.php?event_id=" . $row["event_id"] . "'>✏️ Edit</a> ";
        echo " | <a href='delete_event.php?event_id=" . $row["event_id"] . "' onclick=\"return confirm('Are you sure you want to delete this event?');\">🗑️ Delete</a>";
        echo "</div><hr>";
    }
    echo "</div>";
} else {
    echo "No events available.";
}

$conn->close();
?>
<script>
function openModal(eventId) {
    document.getElementById('modal_event_id').value = eventId;
    document.getElementById('registerModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('registerModal').style.display = 'none';
}

$(document).ready(function(){
    $("#registrationForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'register.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response){
                alert(response);
                closeModal();
            }
        });
    });
});
</script>
<script>
function searchEvents() {
    var input, filter, events, event, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    events = document.getElementById("eventsList").getElementsByClassName('event');

    for (i = 0; i < events.length; i++) {
        event = events[i];
        txtValue = event.textContent || event.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            event.style.display = "";
        } else {
            event.style.display = "none";
        }
    }
}
</script>


</body>
</html>
