<?php
session_start();
include('config/db.php');

if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Database se user nikalna
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Password check
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['auth'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role']; // 'buyer' or 'seller'
            
            // --- YE LINE ADD KI HAI DYNAMIC PHOTO KE LIYE ---
            $_SESSION['user_pic'] = $user['profile_pic']; 

            // Role wise redirection
            if ($_SESSION['role'] == 'seller') {
                header("Location: index.php");
            } else {
                header("Location: index.php");
            }
            exit();

        } else {
            $_SESSION['error'] = "Invalid Email or Password!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No account found with this email!";
        header("Location: login.php");
        exit();
    }
    // Check if user is verified
if($user['is_verified'] == 0) {
    $_SESSION['error'] = "Please verify your email address first!";
    header("Location: login.php");
} else {
    // Set sessions
    $_SESSION['user_pic'] = $user['profile_pic']; // Yeh Gravatar URL hai
    // ... rest of login
}
}
?>