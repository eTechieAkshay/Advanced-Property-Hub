<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile | PropertyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #c3d8f5; margin:0; padding: 40px; }
        
        .profile-container {
            max-width: 600px; margin: auto; background: white;
            padding: 40px; border-radius: 40px; text-align: center;
            box-shadow: 0 30px 60px rgba(0,0,0,0.1);
        }

        /* Profile Image Styling */
        .profile-img-box {
            width: 130px; height: 130px; margin: 0 auto 20px;
            position: relative;
        }

        .user-photo {
            width: 100%; height: 100%; border-radius: 50%;
            object-fit: cover; border: 4px solid #3f4ffd;
            box-shadow: 0 10px 20px rgba(63, 79, 253, 0.2);
        }

        .default-icon {
            font-size: 130px; color: #3f4ffd;
        }

        .user-name { font-size: 28px; font-weight: 800; color: #0f172a; margin: 10px 0; }
        .user-email { color: #64748b; font-weight: 600; margin-bottom: 30px; }

        .info-grid {
            text-align: left; background: #f8fafc;
            padding: 25px; border-radius: 20px; margin-bottom: 30px;
        }

        .info-item { display: flex; justify-content: space-between; margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
        .info-label { color: #64748b; font-weight: 600; }
        .info-value { color: #0f172a; font-weight: 700; }

        .action-btns { display: flex; gap: 15px; justify-content: center; }
        .btn { 
            padding: 12px 25px; border-radius: 12px; text-decoration: none; 
            font-weight: 700; transition: 0.3s; 
        }
        .btn-edit { background: #3f4ffd; color: white; }
        .btn-home { background: #0f172a; color: white; }
        .btn:hover { transform: translateY(-3px); opacity: 0.9; }
    </style>
</head>
<body>

<div class="profile-container">
    <a href="index.php" style="text-decoration:none; color:#3f4ffd; font-weight:700; display:block; text-align:left; margin-bottom:20px;">
        <i class="fa-solid fa-house"></i> Home
    </a>

    <div class="profile-img-box">
        <?php if(!empty($user['profile_pic'])): ?>
            <img src="uploads/profiles/<?php echo $user['profile_pic']; ?>" class="user-photo">
        <?php else: ?>
            <i class="fa-solid fa-circle-user default-icon"></i>
        <?php endif; ?>
    </div>

    <h1 class="user-name"><?php echo $user['name']; ?></h1>
    <p class="user-email"><?php echo $user['email']; ?></p>

    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Account Role</span>
            <span class="info-value" style="text-transform: capitalize;"><?php echo $user['role']; ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Phone</span>
            <span class="info-value"><?php echo $user['phone'] ?: 'Not Added'; ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Member Since</span>
            <span class="info-value"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></span>
        </div>
    </div>

    <div class="action-btns">
        <a href="edit_profile.php" class="btn btn-edit">Edit Profile</a>
        <a href="logout.php" class="btn" style="background:#fee2e2; color:#ef4444;">Logout</a>
    </div>
</div>

</body>
</html>