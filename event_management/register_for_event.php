<?php
session_start();
include('db_connect.php');

if (isset($_POST['register_event'])) {
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO registrations (event_id, user_name, user_email, phone)
            VALUES ('$event_id', '$name', '$email', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('You have successfully registered for the event!');
                window.location.href='events_list.php';
              </script>";
    } else {
        echo "<script>
                alert('Something went wrong. Please try again.');
                window.location.href='events_list.php';
              </script>";
    }
} else {
    header('Location: events_list.php');
    exit();
}
?>
