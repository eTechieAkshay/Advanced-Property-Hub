<?php 
session_start(); 
// Agar header/footer alag files mein hain toh include kar sakte ho, 
// lekin maine yahan standalone code diya hai with your theme.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | PropertyHub Wardha</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Outfit:wght@800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root { 
            --accent: #7C3AED; 
            --dark: #0f172a; 
            --glass: rgba(255, 255, 255, 0.7);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Mesh Gradient Background */
        .bg-glow {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 0% 0%, rgba(124, 58, 237, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 100% 100%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        /* Header Style (Consistent with index) */
        header { 
            display: flex; 
            justify-content: space-between; 
            padding: 20px 8%; 
            background: rgba(217, 212, 255, 0.8); 
            backdrop-filter: blur(15px); 
            position: sticky; 
            top:0; z-index:100; 
            border-bottom: 1px solid rgba(0,0,0,0.05); 
            align-items: center; 
        }
        .logo { font-family: 'Outfit'; font-size: 28px; font-weight: 800; color: var(--dark); text-decoration: none; }
        .nav-links a { text-decoration: none; color: var(--dark); font-weight: 600; margin-left: 30px; transition: 0.3s; }
        .nav-links a:hover { color: var(--accent); }

        /* Main Content */
        .about-hero {
            padding: 100px 8% 60px;
            text-align: center;
        }

        .about-hero h1 {
            font-family: 'Outfit';
            font-size: 3.5rem;
            margin-bottom: 20px;
            background: linear-gradient(to right, var(--dark), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            padding: 40px 8% 100px;
            align-items: center;
        }

        .about-text h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            font-family: 'Outfit';
        }

        .about-text p {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 25px;
        }

        /* Glass Cards */
        .vision-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            padding: 30px;
            border-radius: 25px;
            border: 1px solid rgba(255,255,255,0.8);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: 0.4s;
        }

        .glass-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent);
            background: white;
        }

        .glass-card i {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 15px;
        }

        .btn-home {
            display: inline-block;
            background: var(--dark);
            color: white;
            padding: 15px 35px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-home:hover {
            background: var(--accent);
            transform: scale(1.05);
        }

        /* Footer (Matching index) */
        footer { background: var(--dark); color: #94a3b8; padding: 60px 8% 30px; margin-top: 50px; }
        .footer-content { text-align: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px; }

        /* Responsive */
        @media (max-width: 992px) {
            .about-grid { grid-template-columns: 1fr; text-align: center; }
            .about-hero h1 { font-size: 2.5rem; }
            .vision-cards { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="bg-glow"></div>

<header>
    <a href="index.php" class="logo">Property<span style="color:var(--accent);">Hub</span></a>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="about.php" style="color:var(--accent);">About</a>
        <a href="login.php">Sign In</a>
    </div>
</header>

<section class="about-hero">
    <h1>Our Mission & Vision</h1>
    <p style="max-width: 700px; margin: 0 auto; color: #64748b; font-size: 1.2rem;">
        PropertyHub is a premium real estate ecosystem born in the heart of Wardha at <strong>WARDHA</strong>. We blend high-end design with seamless functionality.
    </p>
</section>

<div class="about-grid">
    <div class="about-text">
        <h2>Who is <span style="color:var(--accent);">Techie?</span></h2>
        <p>
            As a professional motion graphics editor and graphic designer, I believe that finding a home should be an experience, not a task. This portal is built with the "Signature" style—clean, futuristic, and fast.
        </p>
        <p>
            Developed using core PHP and custom CSS, PropertyHub ensures that every listing gets the premium spotlight it deserves, providing a direct bridge between buyers and sellers in Maharashtra.
        </p>
        <a href="index.php" class="btn-home">Explore Properties</a>
    </div>

    <div class="vision-cards">
        <div class="glass-card">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
            <h3>Modern UI</h3>
            <p>Using Glassmorphism and Outfit fonts for a premium feel.</p>
        </div>
        <div class="glass-card">
            <i class="fa-solid fa-rocket"></i>
            <h3>Fast UX</h3>
            <p>Optimized database queries for a lightning-fast search experience.</p>
        </div>
        <div class="glass-card">
            <i class="fa-solid fa-shield-check"></i>
            <h3>Verified</h3>
            <p>Direct contact with property owners with zero hidden layers.</p>
        </div>
        <div class="glass-card">
            <i class="fa-solid fa-code"></i>
            <h3>Tech Stack</h3>
            <p>Pure PHP, MySQL, and Vanilla JS. No heavy frameworks.</p>
        </div>
    </div>
</div>

<footer>
    <div class="footer-content">
        <p>&copy; 2026 PropertyHub | Designed with <i class="fa-solid fa-heart" style="color:#ef4444;"></i> by  Techie</p>
    </div>
</footer>

</body>
</html>