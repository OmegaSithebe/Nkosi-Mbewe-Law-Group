<?php
// book_call.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nkosombewelawgroup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO book_a_call (name, email, date, time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $date, $time);

    if ($stmt->execute()) {
        echo "Call booked successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
