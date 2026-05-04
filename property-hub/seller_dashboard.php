<?php 
session_start();
include('config/db.php');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// --- DELETE LOGIC ---
if(isset($_GET['delete_id'])) {
    $del_id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM properties WHERE id = '$del_id' AND seller_id = '$seller_id'");
    header("Location: seller_dashboard.php?msg=Deleted");
}

// --- STATUS UPDATE LOGIC (Toggle Available/Sold/Rented) ---
if(isset($_GET['mark_id'])) {
    $mark_id = (int)$_GET['mark_id'];
    $status = mysqli_real_escape_string($conn, $_GET['type']); 
    mysqli_query($conn, "UPDATE properties SET availability = '$status' WHERE id = '$mark_id' AND seller_id = '$seller_id'");
    header("Location: seller_dashboard.php?msg=StatusUpdated");
}

// --- ADD PROPERTY LOGIC ---
if(isset($_POST['add_property'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $loc = mysqli_real_escape_string($conn, $_POST['location']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $beds = (int)$_POST['beds'];
    $baths = (int)$_POST['baths'];
    $amen = mysqli_real_escape_string($conn, $_POST['amenities'] ?? '');
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    
    // Facilities JSON Logic
    $fac_json = isset($_POST['facilities']) ? json_encode($_POST['facilities']) : json_encode([]);

    $main_img = "";
    if(!empty($_FILES['main_image']['name'])) {
        $main_img = 'uploads/' . time() . '_' . $_FILES['main_image']['name'];
        if(!is_dir('uploads')) { mkdir('uploads', 0777, true); }
        move_uploaded_file($_FILES['main_image']['tmp_name'], $main_img);
    }

    // Updated Query with Facilities Column
    $query = "INSERT INTO properties (title, price, location, image, description, beds, baths, amenities, facilities, seller_id, purpose, status, availability) 
              VALUES ('$title', '$price', '$loc', '$main_img', '$desc', '$beds', '$baths', '$amen', '$fac_json', '$seller_id', '$purpose', 'pending', 'available')";
    
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Property Sent for Admin Approval!'); window.location='seller_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$my_properties = mysqli_query($conn, "SELECT * FROM properties WHERE seller_id = '$seller_id' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Panel | PropertyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; margin:0; color: #1e293b; }
        .dashboard-container { display: grid; grid-template-columns: 280px 1fr; min-height: 100vh; }
        .sidebar { background: white; padding: 40px 20px; border-right: 1px solid #eee; position: sticky; top: 0; height: 100vh; }
        .main-content { padding: 40px 60px; }
        .table-container { background: white; border-radius: 24px; padding: 30px; border: 1px solid #eee; margin-bottom: 40px; overflow-x: auto; }
        input, textarea, select { width: 100%; padding: 15px; margin: 10px 0; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit; box-sizing: border-box; }
        .btn-submit { background: #7C3AED; color: white; border: none; padding: 15px; width: 100%; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 1rem; margin-top: 10px; }
        .grid-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 15px; border-bottom: 1px solid #f8fafc; }
        .prop-img { width: 60px; height: 45px; object-fit: cover; border-radius: 8px; }
        .badge-rent { background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 800; }
        .badge-sale { background: #ede9fe; color: #7C3AED; padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 800; }
        .btn-action { padding: 8px 12px; border-radius: 8px; text-decoration: none; font-size: 11px; font-weight: 700; display: inline-block; margin-right: 5px; transition: 0.2s; }
        .btn-action:hover { opacity: 0.8; }
        .fac-checklist { margin: 20px 0; background: #f1f5f9; padding: 20px; border-radius: 15px; }
        .fac-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; }
        .fac-grid label { font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 5px; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <aside class="sidebar">
        <h2 style="color:#7C3AED; font-weight:800;">PropertyHub</h2>
        <nav style="margin-top:50px;">
            <a href="index.php" style="display:block; text-decoration:none; color:#64748b; margin-bottom:25px; font-weight:600;">🏠 View Site</a>
            <a href="seller_dashboard.php" style="display:block; text-decoration:none; color:#7C3AED; font-weight:700; margin-bottom:25px;">📊 Dashboard</a>
            <a href="logout.php" style="display:block; text-decoration:none; color:#ef4444; margin-top:100px; font-weight:700;">🚪 Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <header style="margin-bottom: 40px;">
            <h1 style="font-size: 2.2rem; font-weight: 800;">Hi, <?php echo $_SESSION['user_name']; ?>!</h1>
        </header>

        <div class="table-container">
            <h3 style="margin-bottom:20px;">🏠 Your Listings</h3>
            <table>
                <thead>
                    <tr><th>Preview</th><th>Title</th><th>Availability Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php while($p = mysqli_fetch_assoc($my_properties)): ?>
                    <tr>
                        <td><img src="<?php echo $p['image']; ?>" class="prop-img"></td>
                        <td>
                            <strong><?php echo $p['title']; ?></strong><br>
                            <span class="<?php echo ($p['purpose']=='Rent') ? 'badge-rent' : 'badge-sale'; ?>">FOR <?php echo $p['purpose']; ?></span>
                        </td>
                        <td>
                            <?php if($p['availability'] == 'available'): ?>
                                <span style="color:#10B981; font-weight:800;"><i class="fa-solid fa-circle-check"></i> Live & Active</span>
                            <?php else: ?>
                                <span style="color:#ef4444; font-weight:800;"><i class="fa-solid fa-circle-xmark"></i> <?php echo strtoupper($p['availability']); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($p['availability'] == 'available'): ?>
                                <a href="?mark_id=<?php echo $p['id']; ?>&type=<?php echo ($p['purpose']=='Rent') ? 'rented' : 'sold'; ?>" 
                                   class="btn-action" style="background:#10B981; color:white;">
                                   <i class="fa-solid fa-check"></i> Mark <?php echo ($p['purpose']=='Rent') ? 'Rented' : 'Sold'; ?>
                                </a>
                            <?php else: ?>
                                <a href="?mark_id=<?php echo $p['id']; ?>&type=available" 
                                   class="btn-action" style="background:#3f4ffd; color:white;">
                                   <i class="fa-solid fa-rotate-left"></i> Make Available
                                </a>
                            <?php endif; ?>
                            
                            <a href="?delete_id=<?php echo $p['id']; ?>" class="btn-action" style="background:#fee2e2; color:#ef4444;" onclick="return confirm('Pakka delete karna hai?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h3>✨ Add New Listing</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="grid-inputs">
                    <input type="text" name="title" placeholder="Property Title" required>
                    <select name="purpose" required>
                        <option value="Sale">For Sale</option>
                        <option value="Rent">For Rent</option>
                    </select>
                </div>
                <div class="grid-inputs">
                    <input type="text" name="price" placeholder="Price (e.g. ₹5,000 / mo)" required>
                    <input type="text" name="location" placeholder="Location" required>
                </div>
                <input type="file" name="main_image" accept="image/*" required>
                <div class="grid-inputs">
                    <input type="number" name="beds" placeholder="Beds">
                    <input type="number" name="baths" placeholder="Baths">
                </div>
                
                <div class="fac-checklist">
                    <h4 style="margin-top:0;"><i class="fa-solid fa-couch"></i> Furnishing & Facilities</h4>
                    <div class="fac-grid">
                        <label><input type="checkbox" name="facilities[]" value="Wardrobe"> Wardrobe</label>
                        <label><input type="checkbox" name="facilities[]" value="Bed"> Bed</label>
                        <label><input type="checkbox" name="facilities[]" value="Geyser"> Geyser</label>
                        <label><input type="checkbox" name="facilities[]" value="Modular Kitchen"> Modular Kitchen</label>
                        <label><input type="checkbox" name="facilities[]" value="AC"> AC</label>
                        <label><input type="checkbox" name="facilities[]" value="TV"> TV</label>
                        <label><input type="checkbox" name="facilities[]" value="Fridge"> Fridge</label>
                        <label><input type="checkbox" name="facilities[]" value="Washing Machine"> Washing Machine</label>
                        <label><input type="checkbox" name="facilities[]" value="Water Purifier"> Water Purifier</label>
                        <label><input type="checkbox" name="facilities[]" value="Sofa"> Sofa</label>
                    </div>
                </div>

                <textarea name="description" placeholder="Description..." rows="4"></textarea>
                <button type="submit" name="add_property" class="btn-submit">Publish Property</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>