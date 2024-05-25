<?php
session_start();
require 'config.php'; // This should contain your PDO connection setup

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Please fill in both fields.";
        exit;
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Fetch the user
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, start a session and redirect to index.html
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.html");
            exit;
        } else {
            // Invalid email or password
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>