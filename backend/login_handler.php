<?php
//  Give the user a VIP wristband
session_start();

//  Open the database connection
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //  Get what they typed in the login form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    //  Look for this username in the database
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();

    // Grab the result of the search
    $result = $stmt->get_result();

    // 5. Did we find exactly 1 matching user?
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc(); // Open the user's file drawer

        // 6. Check if the typed password matches the hashed password
        if (password_verify($pass, $row['password'])) {

            // Success! Write their details on the VIP wristband
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $user;

            // Teleport to the dashboard
            header("Location: ../templates/dashboard.html");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Username not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
