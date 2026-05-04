<?php
session_start();
include('config/db.php');

if(isset($_POST['send_btn'])) {
    $p_id = mysqli_real_escape_string($conn, $_POST['property_id']);
    $s_id = mysqli_real_escape_string($conn, $_POST['seller_id']);
    $msg  = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Manual Details from Form
    $b_name  = mysqli_real_escape_string($conn, $_POST['buyer_name']);
    $b_phone = mysqli_real_escape_string($conn, $_POST['buyer_phone']);
    
    // Logged in user ki ID (optional)
    $b_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    $query = "INSERT INTO enquiries (property_id, seller_id, buyer_id, buyer_name_manual, buyer_phone_manual, message) 
              VALUES ('$p_id', '$s_id', '$b_id', '$b_name', '$b_phone', '$msg')";

    if(mysqli_query($conn, $query)) {
        // FIXED REDIRECT: 'property_details' se 'property_detail' kar diya
        echo "<script>
            alert('Your interest has been sent! Seller will contact you soon.'); 
            window.location.href='property_detail.php?id=$p_id'; 
          </script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>