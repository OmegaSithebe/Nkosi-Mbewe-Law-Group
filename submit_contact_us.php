<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nkosombewelawgroup"; // Corrected the database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Check for existing record
    $checkStmt = $conn->prepare("SELECT * FROM contact_us WHERE name = ? AND email = ? AND message = ?");
    if ($checkStmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $checkStmt->bind_param("sss", $name, $email, $message);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Redirect to the same page with an error message
        header("Location: contact.html?error=1");
        exit();
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the same page with a success message
            header("Location: contact.html?success=1");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }

    // Close check statement
    $checkStmt->close();
}

// Close connection
$conn->close();
?>