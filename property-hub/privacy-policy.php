<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Privacy Policy | PropertyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --accent: #7C3AED; --dark: #0f172a; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; margin:0; color: #334155; line-height: 1.6; }
        
        .legal-container { max-width: 800px; margin: 60px auto; padding: 40px; background: white; border-radius: 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.04); }
        
        h1 { color: var(--dark); font-size: 2.5rem; font-weight: 800; margin-bottom: 30px; text-align: center; }
        h2 { color: var(--dark); margin-top: 30px; font-weight: 700; border-left: 4px solid var(--accent); padding-left: 15px; }
        p { margin-bottom: 20px; }
        
        .back-btn { display: inline-block; margin-bottom: 20px; text-decoration: none; color: var(--accent); font-weight: 700; }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .legal-container { margin: 20px; padding: 25px; border-radius: 20px; }
            h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <div class="legal-container">
        <a href="index.php" class="back-btn">← Back to Home</a>
        <h1>Privacy Policy</h1>
        
        <p>Last Updated: April 2026</p>

        <h2>1. Information We Collect</h2>
        <p>At PropertyHub, we collect information you provide directly to us when you register, create a listing, or send an enquiry. This includes your name, email address, phone number, and property details.</p>

        <h2>2. How We Use Information</h2>
        <p>We use your data to facilitate connections between buyers and sellers, improve our services, and send important updates regarding your account or listings.</p>

        <h2>3. Data Security</h2>
        <p>We implement professional security measures to protect your personal data. However, no method of transmission over the internet is 100% secure.</p>

        <h2>4. Contact Us</h2>
        <p>If you have any questions about this Privacy Policy, please contact us at support@propertyhub.com</p>
    </div>

</body>
</html>