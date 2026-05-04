<?php 
session_start();
include('config/db.php');

// Security Check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

/** * AB QUERY MEIN MANUAL DATA UTHAYENGE:
 * Humne 'buyer_name_manual' aur 'buyer_phone_manual' use kiya hai
 * kyunki buyer ne enquiry form mein yahi bhara hoga.
 */
$query = "SELECT e.*, e.buyer_name_manual as b_name, e.buyer_phone_manual as b_phone, p.title as p_title 
          FROM enquiries e 
          LEFT JOIN properties p ON e.property_id = p.id 
          WHERE e.seller_id = '$seller_id' 
          ORDER BY e.id DESC";

$all_enquiries = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Enquiries | PropertyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; margin:0; padding: 40px; color: #1e293b; }
        .container { max-width: 900px; margin: auto; }
        .back-btn { text-decoration: none; color: #7C3AED; font-weight: 700; display: inline-block; margin-bottom: 20px; transition: 0.3s; }
        .back-btn:hover { transform: translateX(-5px); }
        .enquiry-card { 
            background: white; border-radius: 20px; padding: 25px; margin-bottom: 20px; 
            border: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
        .buyer-info h3 { margin: 0; color: #1e293b; font-size: 1.4rem; }
        .buyer-info p { margin: 8px 0; color: #64748b; font-size: 1rem; line-height: 1.5; }
        .property-tag { background: #7C3AED; color: white; padding: 5px 12px; border-radius: 8px; font-weight: 800; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; }
        .whatsapp-btn { 
            background: #22c55e; color: white; padding: 14px 24px; border-radius: 15px; 
            text-decoration: none; font-weight: 800; font-size: 0.9rem; transition: 0.3s;
            display: flex; align-items: center; gap: 10px;
        }
        .whatsapp-btn:hover { background: #16a34a; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(34, 197, 94, 0.2); }
        .no-data { text-align: center; padding: 80px 0; color: #94a3b8; }
    </style>
</head>
<body>

<div class="container">
    <a href="seller_dashboard.php" class="back-btn">← Back to Dashboard</a>
    <h1 style="font-weight: 800; margin-bottom: 30px; font-size: 2.2rem;">📩 All Buyer Enquiries</h1>

    <?php if($all_enquiries && mysqli_num_rows($all_enquiries) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($all_enquiries)): ?>
        <div class="enquiry-card">
            <div class="buyer-info">
                <span class="property-tag"><?php echo htmlspecialchars($row['p_title']); ?></span>
                <h3 style="margin-top:15px;"><?php echo htmlspecialchars($row['b_name']); ?></h3>
                <p>"<?php echo htmlspecialchars($row['message']); ?>"</p>
                <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 600;">Phone: <?php echo htmlspecialchars($row['b_phone']); ?></div>
            </div>
            
            <div class="actions">
                <?php if(!empty($row['b_phone'])): ?>
                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $row['b_phone']); ?>?text=Hi <?php echo urlencode($row['b_name']); ?>, I am responding to your enquiry for '<?php echo urlencode($row['p_title']); ?>' on PropertyHub..." 
                   target="_blank" class="whatsapp-btn">
                   <span>Contact on WhatsApp</span>
                </a>
                <?php else: ?>
                <span style="color: #ef4444; font-size: 0.8rem; font-weight: 700;">No Phone Provided</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-data">
            <h2 style="font-size: 3rem;">Empty Inbox</h2>
            <p>No one has enquired about your properties yet.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>