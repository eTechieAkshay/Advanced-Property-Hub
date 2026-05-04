<?php
ob_start();
session_start();
include('admin_auth.php'); 
include('../config/db.php');

// Approve Logic
if(isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE properties SET status = 'approved' WHERE id = $id");
    header('location: manage_properties.php?msg=approved');
    exit();
}

// Delete Logic
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM properties WHERE id = $id");
    header('location: manage_properties.php?msg=deleted');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Properties | Admin Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    :root { 
        --accent: #7C3AED; 
        --text-main: #1e293b;
        --text-muted: #64748b;
        --danger: #ef4444; 
        --success: #10b981; 
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        margin: 0; 
        display: flex; 
        /* Match with your new Light Theme */
        background: linear-gradient(135deg, #f5f7ff 0%, #ede9fe 100%);
        background-attachment: fixed;
        color: var(--text-main);
        min-height: 100vh;
    }

    /* Glassmorphism Sidebar */
    .sidebar { 
        width: 260px; 
        height: 100vh; 
        background: rgba(255, 255, 255, 0.4); 
        backdrop-filter: blur(15px);
        border-right: 1px solid rgba(255, 255, 255, 0.5);
        padding: 40px 20px; 
        position: fixed; 
        z-index: 100;
    }

    .sidebar h2 { 
        font-size: 24px; 
        font-weight: 800;
        margin-bottom: 50px; 
        color: var(--accent); 
        text-align: center;
    }

    .nav-item { 
        padding: 14px 18px; 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        color: var(--text-muted); 
        text-decoration: none; 
        border-radius: 16px; 
        margin-bottom: 8px; 
        font-weight: 600;
        transition: 0.3s; 
    }

    .nav-item:hover, .nav-item.active { 
        background: white; 
        color: var(--accent); 
        box-shadow: 0 10px 20px rgba(124, 58, 237, 0.1);
    }

    .main-content { 
        margin-left: 260px; 
        padding: 50px; 
        width: calc(100% - 260px); 
    }

    /* Light Glass Table Container */
    .table-container { 
        background: rgba(255, 255, 255, 0.6); 
        backdrop-filter: blur(10px);
        border-radius: 30px; 
        padding: 35px; 
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0 15px 35px rgba(0,0,0,0.03);
        margin-top: 30px;
    }

    table { width: 100%; border-collapse: collapse; }
    th { 
        text-align: left; 
        color: var(--text-muted); 
        font-weight: 600; 
        padding: 15px; 
        font-size: 14px; 
        border-bottom: 2px solid rgba(226, 232, 240, 0.8); 
    }
    td { 
        padding: 18px 15px; 
        border-top: 1px solid rgba(226, 232, 240, 0.5); 
        font-size: 15px; 
        color: var(--text-main); 
    }

    /* Property Styling */
    .prop-img { 
        width: 65px; 
        height: 48px; 
        border-radius: 12px; 
        object-fit: cover; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 2px solid white;
    }

    /* Modern Action Buttons */
    .btn { 
        padding: 10px 16px; 
        border-radius: 12px; 
        text-decoration: none; 
        font-size: 12px; 
        font-weight: 800; 
        transition: 0.3s ease; 
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-approve { 
        background: #dcfce7; 
        color: #166534; 
        border: none;
    }
    .btn-approve:hover { background: #bbf7d0; transform: translateY(-2px); }

    .btn-delete { 
        background: #fee2e2; 
        color: #991b1b; 
        border: none;
        margin-left: 8px;
    }
    .btn-delete:hover { background: #fecaca; transform: translateY(-2px); }

    /* Purpose Badge (Rent/Sale) */
    .purpose-badge { 
        padding: 6px 12px; 
        border-radius: 10px; 
        font-size: 11px; 
        font-weight: 800; 
        background: rgba(124, 58, 237, 0.1); 
        color: var(--accent); 
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin<span>Hub</span></h2>
    <a href="admin_dashboard.php" class="nav-item"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
    <a href="manage_properties.php" class="nav-item active"><i class="fa-solid fa-house"></i> Properties</a>
    <a href="manage_users.php" class="nav-item"><i class="fa-solid fa-users"></i> Users</a>
    <a href="../logout.php" class="nav-item" style="margin-top: 50px; color: #ef4444;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main-content">
    <h1>Manage <span style="color:var(--accent);">Properties</span></h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title & Purpose</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM properties ORDER BY id DESC");
                while($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                   <td><img src="../<?php echo $row['image']; ?>" class="prop-img"></td>
                    <td>
                        <strong><?php echo $row['title']; ?></strong> 
                        <span class="purpose-badge"><?php echo $row['purpose']; ?></span>
                        <br><small style="color:#64748b"><?php echo $row['location']; ?></small>
                    </td>
                    <td>
                        ₹<?php echo $row['price']; ?>
                        <?php echo ($row['purpose'] == 'Rent') ? '<small>/ Mo</small>' : ''; ?>
                    </td>
                    <td>
                        <?php if($row['status'] == 'pending'): ?>
                            <a href="manage_properties.php?approve=<?php echo $row['id']; ?>" class="btn btn-approve">Approve</a>
                        <?php else: ?>
                            <span style="color: var(--success); font-weight: 800; font-size: 12px;">APPROVED</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="manage_properties.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Delete?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>