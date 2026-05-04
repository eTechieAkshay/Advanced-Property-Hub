<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current data
$res = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($res);

// Update Logic
if(isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $img_name = $user['profile_pic']; // Default purani image

    // Image Upload Logic
    if(!empty($_FILES['profile_pic']['name'])) {
        $img_name = time() . '_' . $_FILES['profile_pic']['name'];
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/profiles/" . $img_name);
        $_SESSION['user_pic'] = $img_name; // Session update for header
    }

    $update_query = "UPDATE users SET name='$name', phone='$phone', profile_pic='$img_name' WHERE id=$user_id";

    if(mysqli_query($conn, $update_query)) {
        $_SESSION['user_name'] = $name; // Session update for header
        header('location: profile.php?msg=updated');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile | PropertyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #c3d8f5; padding: 50px; margin:0; }
        .edit-card { 
            max-width: 500px; margin: auto; background: white; padding: 40px; 
            border-radius: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); 
        }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 700; color: #1e293b; }
        input { 
            width: 100%; padding: 12px; border-radius: 12px; 
            border: 1px solid #ddd; outline: none; box-sizing: border-box;
        }
        .btn-save { 
            background: #3f4ffd; color: white; border: none; padding: 15px; 
            width: 100%; border-radius: 12px; font-weight: 800; cursor: pointer; transition: 0.3s;
        }
        .btn-save:hover { background: #0f172a; }
        .current-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #3f4ffd; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="edit-card">
     
        <h2 style="margin-top:0; text-align:center;">Edit <span style="color:#3f4ffd;">Profile</span></h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group" style="text-align: center;">
                <img src="uploads/profiles/<?php echo !empty($user['profile_pic']) ? $user['profile_pic'] : 'default.png'; ?>" class="current-img">
                <input type="file" name="profile_pic" style="font-size: 12px; border:none;">
            </div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" value="<?php echo $user['phone'] ?? ''; ?>" placeholder="Enter phone number">
            </div>
            <div class="form-group">
                <label>Email (Read Only)</label>
                <input type="text" value="<?php echo $user['email']; ?>" disabled style="background: #f1f5f9;">
            </div>
            <button type="submit" name="update_profile" class="btn-save">Save Changes</button>
            <a href="profile.php" style="display:block; text-align:center; color:#64748b; text-decoration:none; font-weight:600; margin-top:15px;">Cancel</a>
        </form>
    </div>
       <div class="edit-card">
    <a href="profile.php" style="text-decoration: none; color: #64748b; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 5px; margin-bottom: 20px; transition: 0.3s;">
        <i class="fa-solid fa-arrow-left"></i> Back to Profile
    </a>
</body>
</html>