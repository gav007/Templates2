<?php
// Connect to database
require_once __DIR__ . "/db.php";

// Only allow POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Please submit the form.");
}

// Get and clean form values
$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";

// Basic validation
if ($username === "" || $email === "" || $password === "" || $confirm_password === "") {
    exit("Please fill in all fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Please enter a valid email.");
}

if ($password !== $confirm_password) {
    exit("Passwords do not match.");
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user safely (prepared statement)
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    exit("Server error (prepare failed): " . $conn->error);
}

$stmt->bind_param("sss", $username, $email, $hashed_password);

//  Show friendly result
if ($stmt->execute()) {
    header("Location: ../templates/login_page.html");
    exit();
} else {
    if ($stmt->errno == 1062) {
        echo "Username or email already exists.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
