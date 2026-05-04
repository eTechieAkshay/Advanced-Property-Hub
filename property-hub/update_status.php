<?php
include('config/db.php');
session_start();

if(isset($_POST['mark_done'])) {
    $id = $_POST['prop_id'];
    $status = $_POST['new_status'];
    
    $query = "UPDATE properties SET availability = '$status' WHERE id = '$id'";
    if(mysqli_query($conn, $query)) {
        header("Location: seller_dashboard.php?msg=Status Updated");
    }
}
?>