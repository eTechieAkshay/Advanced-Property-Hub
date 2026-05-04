<?php 
session_start();
include('config/db.php');

if(isset($_POST['add_property'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $loc = mysqli_real_escape_string($conn, $_POST['location']);
    $img = mysqli_real_escape_string($conn, $_POST['image']); 
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']); // Naya logic

    // Query Updated with Purpose
    $query = "INSERT INTO properties (title, price, location, image, description, purpose, status) 
              VALUES ('$title', '$price', '$loc', '$img', '$desc', '$purpose', 'approved')";
              
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Property Added Successfully!'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Listing | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #020617; padding: 50px; color: white; }
        .form-card { max-width: 600px; margin: auto; background: #0f172a; padding: 40px; border-radius: 30px; border: 1px solid rgba(124,58,237,0.2); }
        input, textarea, select { width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #1e293b; border-radius: 12px; background: #1e293b; color: white; font-family: inherit; box-sizing: border-box; }
        .btn-submit { background: #7C3AED; color: white; border: none; padding: 15px; width: 100%; border-radius: 12px; cursor: pointer; font-weight: 700; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="form-card">
        <h2 style="color:#7C3AED">Add New Masterpiece</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Property Title" required>
            
            <div style="display: flex; gap: 10px;">
                <input type="text" name="price" placeholder="Price (e.g. 4.5 Cr or 15k)" required style="flex: 2;">
                <select name="purpose" required style="flex: 1;">
                    <option value="Sale">For Sale</option>
                    <option value="Rent">For Rent</option>
                </select>
            </div>

            <input type="text" name="location" placeholder="Location" required>
            <input type="text" name="image" placeholder="Image URL (Pexels Link)" required>
            <textarea name="description" placeholder="Description" rows="4"></textarea>
            <button type="submit" name="add_property" class="btn-submit">Publish Listing</button>
        </form>
    </div>
</body>
</html>