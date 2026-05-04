<?php 
include('admin_auth.php'); 
include('../config/db.php');

$total_properties = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM properties"));
$total_users = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
$pending_approvals = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM properties WHERE status='pending'")); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | PropertyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root { 
            --accent: #7C3AED; 
            --text-main: #1e293b;
            --text-muted: #64748b;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0; 
            display: flex; 
            /* Soft Blue-Purple Light Gradient */
            background: linear-gradient(135deg, #f5f7ff 0%, #ede9fe 100%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
        }
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
        .header h1 { font-size: 28px; font-weight: 800; margin: 0; }
        
        /* Stats Cards - Frosted Glass */
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); 
            gap: 25px; 
            margin: 40px 0; 
        }
        .stat-card { 
            background: rgba(255, 255, 255, 0.6); 
            backdrop-filter: blur(10px);
            padding: 30px; 
            border-radius: 28px; 
            border: 1px solid rgba(255, 255, 255, 0.7);
            transition: 0.4s ease; 
        }
        .stat-card:hover { 
            transform: translateY(-8px); 
            background: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }
        .stat-card h3 { color: var(--text-muted); font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin: 0; }
        .stat-card .value { font-size: 36px; font-weight: 800; color: var(--text-main); margin-top: 10px; display: block; }
        .activity-table { 
            background: rgba(255, 255, 255, 0.6); 
            backdrop-filter: blur(10px);
            border-radius: 30px; 
            padding: 35px; 
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 15px 35px rgba(0,0,0,0.03);
        }

        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        th { text-align: left; color: var(--text-muted); font-weight: 600; padding-bottom: 20px; font-size: 14px; }
        td { padding: 18px 0; border-top: 1px solid rgba(226, 232, 240, 0.5); font-size: 15px; color: var(--text-main); }

        .badge { padding: 6px 14px; border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
        .status-active { background: #dcfce7; color: #166534; }

        .btn-action { 
            background: var(--accent); 
            color: white; 
            padding: 10px 18px; 
            border-radius: 12px; 
            text-decoration: none; 
            font-size: 13px; 
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-action:hover { background: #6d28d9; transform: scale(1.05); }

    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin<span>Hub</span></h2>
    <nav>
        <a href="admin_dashboard.php" class="nav-item active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
        <a href="manage_properties.php" class="nav-item"><i class="fa-solid fa-house"></i> Properties</a>
        <a href="manage_users.php" class="nav-item"><i class="fa-solid fa-users"></i> Users</a>
        <a href="enquiries.php" class="nav-item"><i class="fa-solid fa-envelope"></i> Enquiries</a>
        <a href="../logout.php" class="nav-item" style="margin-top: 100px; color: #ef4444;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </nav>
</div>

<div class="main-content">
    <div class="header" style="display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <p style="color: var(--accent); font-weight: 700; margin: 0; text-transform: uppercase; font-size: 12px; letter-spacing: 2px;">Overview</p>
            <h1>Welcome back, Techie</h1>
        </div>
        <div style="text-align: right;">
            <span style="background: white; padding: 10px 20px; border-radius: 50px; font-weight: 700; font-size: 14px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <i class="fa-regular fa-calendar-check" style="color: var(--accent);"></i> <?php echo date('d M, Y'); ?>
            </span>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Properties</h3>
            <span class="value"><?php echo $total_properties; ?></span>
        </div>
        <div class="stat-card">
            <h3>Registered Users</h3>
            <span class="value"><?php echo $total_users; ?></span>
        </div>
        <div class="stat-card">
            <h3>Pending Approvals</h3>
            <span class="value" style="color: #f59e0b;"><?php echo $pending_approvals; ?></span>
        </div>
    </div>

    <div class="activity-table">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.3rem; margin: 0; font-weight: 800;">Recent Listings</h2>
            <a href="manage_properties.php" style="color: var(--accent); font-weight: 700; text-decoration: none; font-size: 14px;">View All <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Property Title</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $recent = mysqli_query($conn, "SELECT * FROM properties ORDER BY id DESC LIMIT 5");
                while($row = mysqli_fetch_assoc($recent)):
                ?>
                <tr>
                    <td style="font-weight: 700;"><?php echo $row['title']; ?></td>
                    <td><i class="fa-solid fa-location-dot" style="color: #cbd5e1; margin-right: 5px;"></i> <?php echo $row['location']; ?></td>
                    <td style="color: var(--accent); font-weight: 800;"><?php echo $row['price']; ?></td>
                    <td><span class="badge status-active">Live</span></td>
                    <td style="text-align: right;"><a href="manage_properties.php?id=<?php echo $row['id']; ?>" class="btn-action">Manage</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>