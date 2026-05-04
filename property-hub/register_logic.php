<?php
session_start();
include('config/db.php');

if (isset($_POST['register_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure encryption

    // Check if email already exists
    $check_email = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Email already registered!";
        header("Location: register.php");
        exit();
    } else {
        // Insert new user
        $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Account created! Please login.";
            header("Location: login.php");
        } else {
            $_SESSION['error'] = "Registration failed. Try again.";
            header("Location: register.php");
        }
    }
}
?>