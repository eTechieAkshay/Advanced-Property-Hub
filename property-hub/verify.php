<?php
include('config/db.php');

if(isset($_GET['email']) && isset($_GET['v_code'])) {
    $email = $_GET['email'];
    $v_code = $_GET['v_code'];

    // Check karo ki code sahi hai ya nahi
    $query = "SELECT * FROM users WHERE email='$email' AND verification_code='$v_code'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        // User ko verify kar do
        $update = "UPDATE users SET is_verified = 1 WHERE email = '$email'";
        if(mysqli_query($conn, $update)) {
            echo "<h1>Email Verified!</h1><p>Ab aap login kar sakte hain. <a href='login.php'>Login Here</a></p>";
        }
    } else {
        echo "Invalid or expired verification link!";
    }
}
?>