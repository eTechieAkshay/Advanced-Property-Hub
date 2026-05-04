<?php 
session_start(); 
include('config/db.php'); 

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM properties WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        die("<h1 style='text-align:center; margin-top:50px;'>Property Not Found!</h1>");
    }
} else {
    header("Location: index.php");
    exit();
}

$extra_images_res = mysqli_query($conn, "SELECT * FROM property_images WHERE property_id = '$id'");
$main_img = (!empty($data['image'])) ? $data['image'] : 'https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg';

$all_images = [$main_img];
while($img = mysqli_fetch_assoc($extra_images_res)) {
    $all_images[] = $img['image_url'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?> | PropertyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <!-- Icons ke liye FontAwesome add kiya hai -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root { --accent: #7C3AED; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; margin:0; color: #1e293b; overflow-x: hidden; }
        .hero { height: 55vh; background: url('<?php echo $main_img; ?>') center/cover no-repeat; position: relative; }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); }
        .container { max-width: 1000px; margin: -80px auto 50px; position: relative; z-index: 10; padding: 0 20px; }
        .main-card { background: white; padding: 40px; border-radius: 35px; box-shadow: 0 30px 60px rgba(0,0,0,0.08); }
        .thumb-container { display: flex; gap: 12px; margin-top: -110px; margin-bottom: 35px; overflow-x: auto; padding: 10px; z-index: 20; position: relative; scrollbar-width: none; }
        .thumb-container::-webkit-scrollbar { display: none; }
        .thumb-card { flex: 0 0 130px; height: 85px; border-radius: 18px; border: 3px solid white; cursor: pointer; overflow: hidden; box-shadow: 0 15px 30px rgba(0,0,0,0.2); transition: 0.4s; }
        .thumb-card:hover { transform: scale(1.1) translateY(-10px); border-color: var(--accent); }
        .thumb-card img { width: 100%; height: 100%; object-fit: cover; }
        
        .purpose-badge {
            display: inline-block;
            padding: 6px 18px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 12px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .rent-bg { background: #dcfce7; color: #166534; }
        .sale-bg { background: #ede9fe; color: #7C3AED; }

        .gallery-modal { position: fixed; inset: 0; background: rgba(10, 10, 15, 0.98); z-index: 999; display: none; flex-direction: column; align-items: center; justify-content: center; backdrop-filter: blur(15px); }
        .slider-wrapper { width: 100%; display: flex; overflow-x: auto; scroll-snap-type: x mandatory; gap: 40px; padding: 40px 10vw; align-items: center; scroll-behavior: smooth; }
        .slider-wrapper::-webkit-scrollbar { display: none; }
        .slider-item { flex: 0 0 auto; width: 85vw; max-width: 850px; height: 65vh; scroll-snap-align: center; border-radius: 25px; overflow: hidden; box-shadow: 0 30px 70px rgba(0,0,0,0.6); }
        .slider-item img { width: 100%; height: 100%; object-fit: cover; }
        .slider-nav { display: flex; gap: 20px; margin-top: 30px; align-items: center; }
        .nav-btn { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; width: 55px; height: 55px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s; }
        .nav-btn:hover { background: var(--accent); transform: scale(1.1); }
        .image-counter { color: white; font-weight: 700; background: rgba(255,255,255,0.05); padding: 8px 22px; border-radius: 30px; }
        .close-modal { position: absolute; top: 30px; right: 30px; color: white; font-size: 45px; cursor: pointer; z-index: 1000; }
        
        .price-tag { color: var(--accent); font-size: 35px; font-weight: 800; margin: 10px 0 25px; }
        .price-tag small { font-size: 16px; color: #64748b; font-weight: 400; }
        .amenity-row { display: flex; gap: 30px; padding: 20px 0; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
        
        /* New Facilities Grid Styling */
        .facilities-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 15px; margin: 25px 0; }
        .fac-item { display: flex; align-items: center; gap: 10px; color: #475569; font-size: 14px; font-weight: 600; padding: 10px; background: #f8fafc; border-radius: 12px; }
        .fac-item i { color: var(--accent); font-size: 16px; }

        .contact-box { margin-top: 40px; background: #f8fafc; padding: 30px; border-radius: 25px; border: 1px solid #e2e8f0; }
        input, textarea { width: 100%; padding: 15px; margin-bottom: 10px; border-radius: 12px; border: 1px solid #cbd5e1; font-family: inherit; box-sizing: border-box; }
        .btn-login { display: inline-block; background: var(--accent); color: white; padding: 15px 40px; border-radius: 15px; text-decoration: none; font-weight: 800; margin-top: 15px; transition: 0.3s; }
    </style>
</head>
<body>

    <div class="gallery-modal" id="galleryModal">
        <span class="close-modal" onclick="closeGallery()">&times;</span>
        <div class="slider-wrapper" id="sliderWrapper">
            <?php foreach($all_images as $img_url): ?>
                <div class="slider-item"><img src="<?php echo $img_url; ?>"></div>
            <?php endforeach; ?>
        </div>
        <div class="slider-nav">
            <button class="nav-btn" onclick="slideGallery('left')">←</button>
            <div class="image-counter" id="imgCounter">1 / <?php echo count($all_images); ?></div>
            <button class="nav-btn" onclick="slideGallery('right')">→</button>
        </div>
    </div>

    <div class="hero"><div class="hero-overlay"></div></div>

    <div class="container">
        <div class="thumb-container">
            <?php foreach($all_images as $index => $img_url): ?>
                <div class="thumb-card" onclick="openGallery()">
                    <img src="<?php echo $img_url; ?>">
                </div>
            <?php endforeach; ?>
            <div style="background: var(--accent); color: white; flex: 0 0 130px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-weight: 800; cursor: pointer;" onclick="openGallery()">+ Gallery</div>
        </div>

        <div class="main-card">
            <div class="purpose-badge <?php echo ($data['purpose'] == 'Rent') ? 'rent-bg' : 'sale-bg'; ?>">
                For <?php echo $data['purpose']; ?>
            </div>

            <h1 style="font-size: 2.8rem; font-weight: 800; margin-top: 0;"><?php echo $data['title']; ?></h1>
            <p style="color: #64748b; font-size: 1.1rem;">📍 <?php echo $data['location']; ?></p>
            
            <div class="price-tag">
                <?php echo $data['price']; ?>
                <?php if($data['purpose'] == 'Rent'): ?>
                    <small>/ Month</small>
                <?php endif; ?>
            </div>

            <div class="amenity-row">
                <span><strong>🛏️ <?php echo $data['beds']; ?></strong> Beds</span>
                <span><strong>🚿 <?php echo $data['baths']; ?></strong> Baths</span>
                <?php if(!empty($data['amenities'])): ?>
                    <span style="color:var(--accent);">✨ <?php echo $data['amenities']; ?></span>
                <?php endif; ?>
            </div>

            <!-- UPGRADED FACILITIES SECTION (Based on image_0d4f5a.png) -->
            <h3 style="margin-top: 30px;">Furnishing & Facilities</h3>
            <div class="facilities-grid">
                <?php 
                $facs = json_decode($data['facilities'], true);
                if(!empty($facs)):
                    foreach($facs as $f): 
                        // Icon mapping
                        $icon = "fa-check-circle";
                        if($f == "Wardrobe") $icon = "fa-door-closed";
                        if($f == "Bed") $icon = "fa-bed";
                        if($f == "Geyser") $icon = "fa-hot-tub-person";
                        if($f == "AC") $icon = "fa-wind";
                        if($f == "TV") $icon = "fa-tv";
                        if($f == "Fridge") $icon = "fa-refrigerator";
                        if($f == "Washing Machine") $icon = "fa-soap";
                ?>
                    <div class="fac-item">
                        <i class="fa-solid <?php echo $icon; ?>"></i> <?php echo $f; ?>
                    </div>
                <?php endforeach; else: ?>
                    <p style="color:#94a3b8; font-size: 14px;">No specific facilities listed.</p>
                <?php endif; ?>
            </div>

            <h3 style="margin-top: 30px;">Description</h3>
            <p style="line-height: 1.8; color: #475569;"><?php echo $data['description']; ?></p>
            
            <div class="contact-box">
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <div class="login-wall" style="text-align: center;">
                        <h3 style="margin-bottom: 10px; font-weight: 800;">Connect with Seller</h3>
                        <p style="color: #64748b;">You need to be logged in as a Buyer to send an enquiry.</p>
                        <a href="login.php" class="btn-login">Login to Enquire</a>
                    </div>
                <?php else: ?>
                    <h3 style="margin-bottom: 20px; font-weight: 800;">Quick Enquiry</h3>
                    <form action="send_enquiry.php" method="POST">
                        <input type="hidden" name="property_id" value="<?php echo $data['id']; ?>">
                        <input type="hidden" name="seller_id" value="<?php echo $data['seller_id']; ?>">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <input type="text" name="buyer_name" value="<?php echo $_SESSION['user_name']; ?>" readonly style="background: #f1f5f9; color: #64748b;">
                            <input type="text" name="buyer_phone" placeholder="Your Phone Number" required>
                        </div>
                        <textarea name="message" rows="3" placeholder="Write your message..." required></textarea>
                        <button type="submit" name="send_btn" style="background: var(--accent); color: white; border: none; padding: 18px; border-radius: 15px; font-weight: 800; cursor: pointer; width: 100%;">Send Interest Now</button>
                    </form>
                <?php endif; ?>
            </div>
            
            <a href="index.php" style="display: block; text-align: center; margin-top: 30px; color: #64748b; text-decoration: none; font-weight: 600;">← Back to Explorations</a>
        </div>
    </div>

    <script>
        const wrapper = document.getElementById('sliderWrapper');
        const counter = document.getElementById('imgCounter');
        const total = <?php echo count($all_images); ?>;
        function openGallery() { document.getElementById('galleryModal').style.display = 'flex'; document.body.style.overflow = 'hidden'; }
        function closeGallery() { document.getElementById('galleryModal').style.display = 'none'; document.body.style.overflow = 'auto'; }
        function slideGallery(direction) { const width = wrapper.querySelector('.slider-item').offsetWidth + 40; wrapper.scrollBy({ left: direction === 'right' ? width : -width, behavior: 'smooth' }); }
        wrapper.addEventListener('scroll', () => { 
            const items = wrapper.querySelectorAll('.slider-item');
            if(items.length > 0) {
                const index = Math.round(wrapper.scrollLeft / (items[0].offsetWidth + 40));
                counter.innerText = `${index + 1} / ${total}`;
            }
        });
    </script>
</body>
</html>