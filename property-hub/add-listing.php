<?php 
session_start();
include('config/db.php');

if(isset($_POST['publish'])) {
    // 1. Sabse pehle login user ki ID pakdo
    $seller_id = $_SESSION['user_id']; 
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $beds = mysqli_real_escape_string($conn, $_POST['beds']);
    $baths = mysqli_real_escape_string($conn, $_POST['baths']);
    $img = mysqli_real_escape_string($conn, $_POST['image_url']); 
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);

    // 2. INSERT query mein 'seller_id' column aur '$seller_id' value dono add karein
    $sql = "INSERT INTO properties (title, price, location, beds, baths, image, description, seller_id) 
            VALUES ('$title', '$price', '$location', '$beds', '$baths', '$img', '$desc', '$seller_id')";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Property Added with your ID!'); window.location='seller_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Studio | Add New Listing</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; padding: 40px; }
        .form-container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        input, textarea { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #e2e8f0; border-radius: 10px; box-sizing: border-box; }
        .btn-publish { background: #7C3AED; color: white; border: none; padding: 15px; width: 100%; border-radius: 10px; cursor: pointer; font-weight: 700; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>List Your Property</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Property Title" required>
            <input type="text" name="price" placeholder="Price (e.g. ₹8.5 Cr)" required>
            <input type="text" name="location" placeholder="Location" required>
            <div style="display: flex; gap: 10px;">
                <input type="number" name="beds" placeholder="Beds" value="2">
                <input type="number" name="baths" placeholder="Baths" value="2">
            </div>
            <input type="text" name="image_url" placeholder="Image URL" required>
            <textarea name="desc" rows="5" placeholder="Description..."></textarea>
            <button type="submit" name="publish" class="btn-publish">Publish Listing</button>
        </form>
    </div>
</body>
</html>