<?php 
session_start(); 
include('config/db.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PropertyHub | Luxury Real Estate</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root { --accent: #3f4ffd; --dark: #0f172a; --rent: #10b981; }
        body { font-family: 'Inter', sans-serif; background: #c3d8f5; margin:0; color: var(--dark); }
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
            overflow: hidden; /* For background scroll */
        }
        .header-bg-scroll {
            position: absolute;
            top: 0;
            left: 0;
            width: 200%;
            height: 100%;
            display: flex;
            opacity: 0.35; /* 35% Opacity as requested */
            z-index: -1;
            pointer-events: none;
            animation: scrollBackground 40s linear infinite;
        }

        .header-bg-scroll img {
            width: 300px;
            height: 100%;
            object-fit: cover;
        }

        @keyframes scrollBackground {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .logo { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--dark); text-decoration: none; letter-spacing: -1px; position: relative; }
        
        .nav-links { display: flex; align-items: center; position: relative; }
        .nav-links a { text-decoration: none; color: var(--dark); font-weight: 600; margin-left: 30px; transition: 0.3s; }
        .nav-links a:hover { color: var(--accent); }
        .btn-accent { background: var(--accent); color: white !important; padding: 12px 25px; border-radius: 12px; }
        .btn-join { background: var(--dark); color: white !important; padding: 12px 25px; border-radius: 12px; margin-left: 20px; }
        .hero { 
            padding: 80px 8% 40px; 
            text-align: center; 
            background: radial-gradient(circle at top right, #f3e8ff, transparent 40%);
            position: relative;
            overflow: hidden; /* Added to contain scroll inside Hero */
        }
        .hero-bg-scroll {
            position: absolute;
            top: 0;
            left: 0;
            width: 200%;
            height: 100%;
            display: flex;
            opacity: 0.25; /* Lower opacity for Hero so text is readable */
            z-index: -1;
            pointer-events: none;
            animation: scrollBackground 50s linear infinite;
        }
        .hero-bg-scroll img {
            width: 400px;
            height: 100%;
            object-fit: cover;
        }
        .category-tabs { display: flex; justify-content: center; gap: 15px; margin: 30px 0 50px; }
        .tab-btn { padding: 12px 30px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.1); background: white; color: #64748b; font-weight: 700; cursor: pointer; transition: 0.3s; font-family: 'Inter', sans-serif; }
        .tab-btn.active { background: var(--accent); color: white; border-color: var(--accent); box-shadow: 0 10px 20px rgba(63, 79, 253, 0.2); }
        .property-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 40px; padding: 0 8% 40px; }
        .card { background: white; border-radius: 35px; overflow: hidden; transition: 0.4s; border: 1px solid rgba(0,0,0,0.04); text-decoration: none; color: inherit; display: block; }
        .card:hover { transform: translateY(-12px); box-shadow: 0 30px 60px rgba(124,58,237,0.1); }
        .hidden { display: none; }
        .img-box { height: 260px; position: relative; }
        .card-img { width: 100%; height: 100%; object-fit: cover; }
        .purpose-badge { position: absolute; top: 20px; left: 20px; padding: 6px 15px; border-radius: 50px; color: white; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; z-index: 5; font-family: 'Sora', sans-serif; }
        .badge-rent { background: var(--rent); }
        .badge-sale { background: var(--accent); }
        .price-chip { position: absolute; bottom: 20px; left: 20px; background: rgba(15,23,42,0.9); color: white; padding: 8px 18px; border-radius: 12px; font-weight: 700; font-family: 'Sora', sans-serif; }       
        .card-body { padding: 25px; }
        .card-body h3 { font-family: 'Sora', sans-serif; font-weight: 700; letter-spacing: -0.5px; }
        .specs { display:flex; gap:15px; font-size:13px; font-weight:700; color:#94a3b8; margin-top: 15px; }   
        .search-container { max-width: 700px; margin: 40px auto; padding: 10px; position: relative; z-index: 10; }
        .search-box { display: flex; align-items: center; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); padding: 10px 15px; border-radius: 24px; border: 1px solid rgba(124, 58, 237, 0.2); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); transition: all 0.4s ease; }
        .search-box input { flex: 1; border: none; background: transparent; padding: 15px 20px; font-size: 1.1rem; outline: none; font-family: 'Inter', sans-serif; }
        .search-box button { background: var(--dark); color: white; border: none; padding: 15px 35px; border-radius: 18px; font-weight: 700; cursor: pointer; font-family: 'Sora', sans-serif; }
        .main-footer {
            background: #0f172a; 
            color: #94a3b8;
            padding: 60px 8% 30px;
            margin-top: 80px;
            border-radius: 50px 50px 0 0; 
        }
        .footer-container {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1.2fr;
            gap: 50px;
        }
        .footer-section h4 {
            color: white;
            margin-bottom: 20px;
            font-family: 'Sora', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
        }
        .footer-logo {
            color: white;
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 15px;
            display: block;
            text-decoration: none;
            letter-spacing: -1px;
        }
        .footer-section p {
            line-height: 1.6;
            font-size: 0.95rem;
        }
        .footer-section ul { list-style: none; padding: 0; }
        .footer-section ul li { margin-bottom: 12px; }
        .footer-section ul li a { 
            color: #94a3b8; 
            text-decoration: none; 
            transition: 0.3s; 
            font-weight: 500;
        }
        .footer-section ul li a:hover { color: #3f4ffd; transform: translateX(5px); display: inline-block; }

        .social-links { display: flex; gap: 12px; margin-top: 20px; }
        .social-links a { 
            background: rgba(255,255,255,0.05); 
            color: white; width: 40px; height: 40px; 
            display: flex; align-items: center; justify-content: center; 
            border-radius: 12px; text-decoration: none; transition: 0.3s;
        }
        .social-links a:hover { background: #3f4ffd; transform: translateY(-5px); }

        .footer-bottom {
            text-align: center;
            margin-top: 50px;
            padding-top: 25px;
            border-top: 1px solid rgba(255,255,255,0.05);
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .footer-container { grid-template-columns: 1fr; gap: 30px; }
        }

        .default-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--accent) 0%, #7c3aed 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 15px;
            font-weight: 800;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(63, 79, 253, 0.2);
            font-family: 'Sora', sans-serif;
        }
        html {
            scroll_behavior: smooth;
        }
    </style>
</head>
<body>

<header>
 
    <a href="index.php" class="logo">Property<span style="color:var(--accent);">Hub</span></a>
    
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="explore.php">Explore</a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <div style="display: flex; align-items: center; gap: 15px; margin-left: 20px;">
                <a href="profile.php" style="text-decoration: none; display: flex; align-items: center; gap: 8px; color: var(--dark);">
                    
                    <?php 
                    $user_name = $_SESSION['user_name'];
                    $first_letter = strtoupper(substr($user_name, 0, 1));
                    
                    if(!empty($_SESSION['user_pic']) && file_exists("uploads/profiles/" . $_SESSION['user_pic'])): ?>
                        <img src="uploads/profiles/<?php echo $_SESSION['user_pic']; ?>" 
                             style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent);">
                    <?php else: ?>
                        <div class="default-avatar">
                            <?php echo $first_letter; ?>
                        </div>
                    <?php endif; ?>
                    
                    <span style="font-weight: 700;">Hi, <?php echo explode(' ', $user_name)[0]; ?></span>
                </a>

                <?php if($_SESSION['role'] == 'seller'): ?>
                    <a href="seller_dashboard.php" class="btn-accent">Dashboard</a>
                <?php endif; ?>
                
                <a href="logout.php" style="color: #ef4444; margin-left: 10px;"><i class="fa-solid fa-power-off"></i></a>
            </div>
        <?php else: ?>
            <a href="login.php">Sign In</a>
            <a href="register.php" class="btn-join">Join Now</a>
        <?php endif; ?>
    </div>
</header>

<section class="hero">
    <div class="hero-bg-scroll">
        <img src="https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg">
        <img src="https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg">
        <img src="https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg">
        <img src="https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg">
        <img src="https://images.pexels.com/photos/277667/pexels-photo-277667.jpeg">
        <!-- Duplicate for loop -->
        <img src="https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg">
        <img src="https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg">
    </div>

    <h1 style="font-family:'Sora', sans-serif; font-size: 3.5rem; margin-bottom:10px; font-weight: 800; letter-spacing: -2px;">Find Your <span style="color:var(--accent);">Signature</span> Space.</h1>
    <p style="color:#64748b; font-size:1.1rem; font-weight: 500;">Curated collection of high-end properties in Wardha.</p>
    
    <form method="GET" class="search-container">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass" style="margin-left:15px; color:var(--accent);"></i>
            <input type="text" name="search" placeholder="Search by city or area..." value="<?php echo @$_GET['search']; ?>">
            <button type="submit">Find Now</button>
        </div>
    </form>

    <div class="category-tabs">
        <button class="tab-btn active" onclick="filterProps('all', this)">All</button>
        <button class="tab-btn" onclick="filterProps('Sale', this)">Buy</button>
        <button class="tab-btn" onclick="filterProps('Rent', this)">Rent</button>
    </div>
</section>

<div class="property-grid" id="propGrid">
    <?php
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $sql = "SELECT * FROM properties WHERE status = 'approved'";
    if($search) { $sql .= " AND (location LIKE '%$search%' OR title LIKE '%$search%')"; }
    $sql .= " ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0):
        while($row = mysqli_fetch_assoc($result)):
    ?>
    <a href="<?php echo ($row['availability'] == 'available') ? 'property_detail.php?id='.$row['id'] : '#'; ?>" 
       class="card prop-item" data-category="<?php echo $row['purpose']; ?>"
       style="<?php echo ($row['availability'] != 'available') ? 'cursor: default;' : ''; ?>">
        
        <div class="img-box">
            <?php if($row['availability'] != 'available'): ?>
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.7); display: flex; align-items: center; justify-content: center; z-index: 10; backdrop-filter: blur(2px);">
                    <span style="background: #ef4444; color: white; padding: 10px 25px; border-radius: 14px; font-weight: 900; transform: rotate(-10deg); border: 3px solid white; font-family: 'Sora', sans-serif; letter-spacing: 1px;">
                        <?php echo strtoupper($row['availability']); ?>
                    </span>
                </div>
            <?php endif; ?>

            <span class="purpose-badge <?php echo ($row['purpose'] == 'Rent') ? 'badge-rent' : 'badge-sale'; ?>">
                For <?php echo $row['purpose']; ?>
            </span>
            
            <img src="<?php echo $row['image']; ?>" class="card-img" onerror="this.src='https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg'">
            
            <div class="price-chip">
                <?php echo $row['price']; ?>
                <?php if($row['purpose'] == 'Rent') echo '<small style="font-size:10px; font-weight:400;">/mo</small>'; ?>
            </div>
        </div>
        
        <div class="card-body" style="<?php echo ($row['availability'] != 'available') ? 'opacity: 0.5;' : ''; ?>">
            <h3 style="margin:0;"><?php echo $row['title']; ?></h3>
            <p style="color:#64748b; font-size:14px; margin: 8px 0 15px; font-weight: 500;">📍 <?php echo $row['location']; ?></p>
            <div class="specs">
                <span>🛏️ <?php echo $row['beds']; ?> Beds</span>
                <span>🚿 <?php echo $row['baths']; ?> Baths</span>
            </div>
        </div>
    </a>
    <?php 
        endwhile; 
    else:
        echo "<h3 style='grid-column: 1/-1; text-align:center; color:#64748b; font-family: Sora, sans-serif;'>No properties found.</h3>";
    endif;
    ?>
</div>

<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-section">
            <a href="index.php" class="footer-logo">Property<span style="color:#3f4ffd">Hub</span></a>
            <p>Making your dream home search futuristic and seamless. The most premium real estate portal in Wardha.</p>
            <div class="social-links">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">Browse Properties</a></li>
                <li><a href="register.php">Join as Seller</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="privacy-policy.php">Privacy Policy</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Contact Us</h4>
            <p style="margin-bottom: 10px;">📍 Mhada Colony, Wardha, Maharashtra</p>
            <p style="margin-bottom: 10px;">📧 support@propertyhub.com</p>
            <p>📞 +91 876686 7361</p>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; 2026 PropertyHub. Designed by <span style="color:#3f4ffd; font-weight:700; font-family: Sora, sans-serif;">Techie</span>. All Rights Reserved.</p>
    </div>
</footer>

<script>
function filterProps(category, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const items = document.querySelectorAll('.prop-item');
    items.forEach(item => {
        if (category === 'all') {
            item.classList.remove('hidden');
        } else {
            if (item.getAttribute('data-category') === category) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        }
    });
}
</script>
</body>
</html>