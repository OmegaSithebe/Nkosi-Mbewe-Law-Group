<?php
// Database configuration
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

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];

// Check for existing record
$checkStmt = $conn->prepare("SELECT * FROM registrations WHERE name = ? AND email = ?");
$checkStmt->bind_param("ss", $name, $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    // Redirect to the same page with an error message
    header("Location: index.html?error=1");
    exit();
} else {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO registrations (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the same page with a success message
        header("Location: index.html?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connections
$checkStmt->close();
$conn->close();
?>
