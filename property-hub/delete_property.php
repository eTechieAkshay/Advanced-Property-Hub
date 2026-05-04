<?php
include('config/db.php');
session_start();

$id = $_GET['id'];
// Security check: Sirf wahi seller delete kar sake jiski property hai
$seller_id = $_SESSION['user_id'];

$query = "DELETE FROM properties WHERE id = '$id' AND seller_id = '$seller_id'";
if(mysqli_query($conn, $query)) {
    header("Location: seller_dashboard.php?msg=Property Deleted");
}
?>