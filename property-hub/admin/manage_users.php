<?php
include('admin_auth.php'); // Session start iske andar pehle se hai
include('../config/db.php');

// User Delete Logic
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    header('location: manage_users.php?msg=user_deleted');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | Admin Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
    :root { 
        --accent: #7C3AED; 
        --text-main: #1e293b;
        --text-muted: #64748b;
        --danger: #ef4444;
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        margin: 0; 
        display: flex; 
        /* Dashboard se match karta hua light gradient */
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

    /* Light Glass Card for User Table */
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
        padding: 20px 15px; 
        border-top: 1px solid rgba(226, 232, 240, 0.5); 
        font-size: 15px; 
        color: var(--text-main); 
    }

    .user-avatar { 
        width: 42px; height: 42px; 
        background: #ede9fe; 
        color: var(--accent);
        border-radius: 12px; 
        display: flex; align-items: center; justify-content: center; 
        font-weight: 800;
        box-shadow: 0 4px 10px rgba(124, 58, 237, 0.1);
    }

    .role-badge {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .role-seller { background: #ede9fe; color: var(--accent); }
    .role-buyer { background: #dcfce7; color: #166534; }

    .btn-del { 
        color: var(--danger); 
        background: rgba(239, 68, 68, 0.1);
        padding: 10px;
        border-radius: 12px;
        text-decoration: none; 
        font-size: 16px; 
        transition: 0.3s; 
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-del:hover { 
        background: var(--danger);
        color: white;
        transform: scale(1.1);
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin<span>Hub</span></h2>
    <a href="admin_dashboard.php" class="nav-item"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
    <a href="manage_properties.php" class="nav-item"><i class="fa-solid fa-house"></i> Properties</a>
    <a href="manage_users.php" class="nav-item active"><i class="fa-solid fa-users"></i> Users</a>
    <a href="../logout.php" class="nav-item" style="margin-top: 50px; color: #ef4444;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main-content">
    <h1>Manage <span style="color:var(--accent);">Users</span></h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
                while($u = mysqli_fetch_assoc($users)):
                ?>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="user-avatar"><?php echo strtoupper(substr($u['name'] ?? 'U', 0, 1)); ?></div>
                            <strong><?php echo $u['name']; ?></strong>
                        </div>
                    </td>
                    <td><?php echo $u['email']; ?></td>
                    <td>
                        <span class="role-badge <?php echo ($u['role'] == 'seller') ? 'role-seller' : 'role-buyer'; ?>">
                            <?php echo $u['role']; ?>
                        </span>
                    </td>
                    <td>
                        <?php 
                        // FIXED DATE LOGIC: Agar date empty hai toh 1970 nahi dikhayega
                        if(!empty($u['created_at']) && $u['created_at'] != '0000-00-00 00:00:00') {
                            echo date('d M, Y', strtotime($u['created_at'])); 
                        } else {
                            echo "Not Joined Yet"; 
                        }
                        ?>
                    </td>
                    <td>
                        <a href="manage_users.php?delete=<?php echo $u['id']; ?>" class="btn-del" onclick="return confirm('User delete karein?')">
                            <i class="fa-solid fa-trash-can"></i>
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