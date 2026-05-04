<?php 
session_start(); 
include('config/db.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Explore Properties | PropertyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root { --accent: #3f4ffd; --dark: #0f172a; --rent: #10b981; }
        body { font-family: 'Inter', sans-serif; background: #c3d8f5; margin:0; color: var(--dark); }
        
        /* Header Glassmorphism */
        header { 
            display: flex; 
            justify-content: space-between; 
            padding: 0 8%; 
            height: 80px;
            background: rgba(255, 255, 255, 0.7); 
            backdrop-filter: blur(20px); 
            position: sticky; 
            top:0; 
            z-index:100; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.3); 
            align-items: center; 
        }
        .logo { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--dark); text-decoration: none; letter-spacing: -1px; }
        .nav-links a { text-decoration: none; color: var(--dark); font-weight: 600; margin-left: 30px; transition: 0.3s; }
        .nav-links a:hover { color: var(--accent); }
        .btn-accent { background: var(--accent); color: white !important; padding: 12px 25px; border-radius: 12px; }
        .default-avatar { width: 35px; height: 35px; background: linear-gradient(135deg, var(--accent) 0%, #7c3aed 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; border: 2px solid white; font-family: 'Sora', sans-serif; }

        /* Explore Specific Layout */
        .explore-title { padding: 50px 8% 20px; text-align: left; }
        .explore-title h1 { font-family: 'Sora', sans-serif; font-size: 2.5rem; margin-bottom: 10px; font-weight: 800; }

        .category-tabs { display: flex; justify-content: flex-start; gap: 15px; padding: 0 8% 40px; }
        .tab-btn { padding: 10px 25px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.1); background: white; color: #64748b; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .tab-btn.active { background: var(--accent); color: white; box-shadow: 0 10px 20px rgba(63, 79, 253, 0.2); }

        /* Grid System */
        .property-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px; padding: 0 8% 60px; }
        .card { background: white; border-radius: 30px; overflow: hidden; transition: 0.4s; border: 1px solid rgba(0,0,0,0.04); text-decoration: none; color: inherit; position: relative; }
        .card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(0,0,0,0.1); }
        .img-box { height: 240px; position: relative; }
        .card-img { width: 100%; height: 100%; object-fit: cover; }
        .purpose-badge { position: absolute; top: 15px; left: 15px; padding: 5px 12px; border-radius: 50px; color: white; font-size: 10px; font-weight: 800; text-transform: uppercase; z-index: 5; font-family: 'Sora', sans-serif; }
        .badge-rent { background: var(--rent); }
        .badge-sale { background: var(--accent); }
        .price-chip { position: absolute; bottom: 15px; left: 15px; background: rgba(15,23,42,0.9); color: white; padding: 8px 15px; border-radius: 12px; font-weight: 700; font-family: 'Sora', sans-serif; }
        .card-body { padding: 20px; }
        .specs { display:flex; gap:15px; font-size:13px; font-weight:700; color:#94a3b8; margin-top: 12px; }
        .hidden { display: none; }
    </style>
</head>
<body>

<header>
    <a href="index.php" class="logo">Property<span style="color:var(--accent);">Hub</span></a>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="explore.php" style="color:var(--accent);">Explore</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="profile.php">Profile</a>
        <?php else: ?>
            <a href="login.php" class="btn-accent" style="color:white !important;">Sign In</a>
        <?php endif; ?>
    </div>
</header>

<div class="explore-title">
    <h1>Explore <span style="color:var(--accent);">Properties</span></h1>
    <p style="color:#64748b;">Browse all available listings in Wardha</p>
</div>

<div class="category-tabs">
    <button class="tab-btn active" onclick="filterProps('all', this)">All Listings</button>
    <button class="tab-btn" onclick="filterProps('Sale', this)">For Sale</button>
    <button class="tab-btn" onclick="filterProps('Rent', this)">For Rent</button>
</div>

<div class="property-grid" id="propGrid">
    <?php
    // Fetching only approved properties
    $sql = "SELECT * FROM properties WHERE status = 'approved' ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0):
        while($row = mysqli_fetch_assoc($result)):
    ?>
    <a href="property_detail.php?id=<?php echo $row['id']; ?>" class="card prop-item" data-category="<?php echo $row['purpose']; ?>">
        <div class="img-box">
            <span class="purpose-badge <?php echo ($row['purpose'] == 'Rent') ? 'badge-rent' : 'badge-sale'; ?>">
                For <?php echo $row['purpose']; ?>
            </span>
            <img src="<?php echo $row['image']; ?>" class="card-img" onerror="this.src='https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg'">
            <div class="price-chip">
                <?php echo $row['price']; ?>
                <?php if($row['purpose'] == 'Rent') echo '<small style="font-size:10px;">/mo</small>'; ?>
            </div>
        </div>
        
        <div class="card-body">
            <h3 style="margin:0; font-family:'Sora'; font-size:1.1rem;"><?php echo $row['title']; ?></h3>
            <p style="color:#64748b; font-size:13px; margin: 5px 0;">📍 <?php echo $row['location']; ?></p>
            <div class="specs">
                <span>🛏️ <?php echo $row['beds']; ?> Beds</span>
                <span>🚿 <?php echo $row['baths']; ?> Baths</span>
            </div>
        </div>
    </a>
    <?php 
        endwhile; 
    else:
        echo "<h3 style='grid-column: 1/-1; text-align:center; color:#64748b;'>No properties available at the moment.</h3>";
    endif;
    ?>
</div>

<script>
function filterProps(category, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const items = document.querySelectorAll('.prop-item');
    items.forEach(item => {
        if (category === 'all' || item.getAttribute('data-category') === category) {
            item.classList.remove('hidden');
        } else {
            item.classList.add('hidden');
        }
    });
}
</script>

</body>
</html>