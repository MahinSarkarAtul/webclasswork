<?php
session_start();

// DB credentials
$host = "localhost";
$db = "aqi";
$user = "root"; // or your DB username
$pass = "";     // or your DB password

// Connect to the database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM usertable WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);  // Note: For production, use hashed passwords
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows === 1) {
    // User authenticated successfully
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;

    // Redirect to protected page
    header("Location: request.php");
    exit();
} else {
    // Invalid credentials, redirect back with error
    echo "<script>alert('Invalid username or password'); window.location.href='index.php';</script>";
}

$stmt->close();
$conn->close();
?>
