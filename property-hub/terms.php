<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Terms of Service | PropertyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --accent: #7C3AED; --dark: #0f172a; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc; 
            margin:0; 
            color: #334155; 
            line-height: 1.6; 
        }
        
        .legal-container { 
            max-width: 800px; 
            margin: 60px auto; 
            padding: 40px; 
            background: white; 
            border-radius: 30px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.04); 
        }
        
        h1 { color: var(--dark); font-size: 2.5rem; font-weight: 800; margin-bottom: 30px; text-align: center; }
        h2 { 
            color: var(--dark); 
            margin-top: 35px; 
            font-weight: 700; 
            border-left: 4px solid var(--accent); 
            padding-left: 15px; 
            font-size: 1.3rem;
        }
        p, li { margin-bottom: 15px; font-size: 1.05rem; }
        ul { margin-bottom: 20px; padding-left: 20px; }
        
        .back-btn { 
            display: inline-block; 
            margin-bottom: 20px; 
            text-decoration: none; 
            color: var(--accent); 
            font-weight: 700; 
            transition: 0.3s;
        }
        .back-btn:hover { transform: translateX(-5px); }
        
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
        <h1>Terms of Service</h1>
        
        <p style="text-align: center; color: #64748b;">Effective Date: April 27, 2026</p>

        <h2>1. Acceptance of Terms</h2>
        <p>By accessing and using PropertyHub, you agree to be bound by these Terms of Service. If you do not agree, please do not use our platform.</p>

        <h2>2. User Responsibilities</h2>
        <ul>
            <li>You must provide accurate information while registering or listing properties.</li>
            <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
            <li>Any fraudulent or misleading property listings will be removed immediately without notice.</li>
        </ul>

        <h2>3. Listing Policy</h2>
        <p>Sellers are responsible for the images and descriptions they upload. PropertyHub does not guarantee the 100% accuracy of user-generated content, although we strive to maintain high standards.</p>

        <h2>4. Prohibited Activities</h2>
        <p>Users are prohibited from using the site for any unlawful purposes, spamming other users, or attempting to compromise the security of our database and server.</p>

        <h2>5. Limitation of Liability</h2>
        <p>PropertyHub acts as a bridge between buyers and sellers. We are not liable for any disputes, financial losses, or legal issues arising from deals made through the platform.</p>

        <h2>6. Changes to Terms</h2>
        <p>We reserve the right to modify these terms at any time. Continued use of the portal after changes constitutes acceptance of the new terms.</p>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 40px 0;">
        
        <p style="text-align: center; font-size: 0.9rem; color: #94a3b8;">
            For any legal inquiries, reach out to us at <strong>legal@propertyhub.com</strong>
        </p>
    </div>

</body>
</html>