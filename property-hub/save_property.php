<?php
session_start();
include('config/db.php');

// Check if user is seller
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

if(isset($_POST['save_btn'])) {
    // Data sanitize karna zaroori hai (SQL Injection se bachne ke liye)
    $seller_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $beds = mysqli_real_escape_string($conn, $_POST['beds']);
    $baths = mysqli_real_escape_string($conn, $_POST['baths']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // SQL Query to Insert Data
    $query = "INSERT INTO properties (seller_id, title, price, location, beds, baths, image_url, description) 
              VALUES ('$seller_id', '$title', '$price', '$location', '$beds', '$baths', '$image_url', '$description')";

    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        // Success: Wapas Dashboard par bhej do
        header("Location: seller_dashboard.php?msg=Property Added Successfully");
        exit();
    } else {
        // Error: Wapas form par bhej do
        header("Location: add-property.php?msg=Something went wrong!");
        exit();
    }
}
?>