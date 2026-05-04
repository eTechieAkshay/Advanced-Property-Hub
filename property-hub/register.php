<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join PropertyHub | Premium Estates</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; background: #c3d8f5; font-family: 'Plus Jakarta Sans', sans-serif; }
        .register-container { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); padding: 40px; border-radius: 35px; width: 100%; max-width: 500px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 25px 50px rgba(0,0,0,0.05); text-align: center; }
        .register-container h2 { font-size: 2.2rem; font-weight: 800; background: linear-gradient(to right, #1E1B4B, #7C3AED); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 10px; }
        .input-group { margin-bottom: 15px; text-align: left; }
        .input-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #4B5563; font-size: 0.85rem; }
        .input-group input, .input-group select { width: 100%; padding: 14px; border-radius: 15px; border: 1px solid rgba(124, 58, 237, 0.2); background: rgba(255, 255, 255, 0.9); font-size: 1rem; outline: none; }
        .btn-reg { width: 100%; background: #7C3AED; color: white; padding: 16px; border: none; border-radius: 15px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-reg:hover { transform: translateY(-3px); background: #6D28D9; }
        .msg { padding: 12px; border-radius: 12px; margin-bottom: 15px; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Create Account</h2>
    <p style="color: #6B7280; margin-bottom: 25px;">Join our elite community of buyers and sellers.</p>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="msg" style="background: #DCFCE7; color: #166534;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="msg" style="background: #FEE2E2; color: #991B1B;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="register_logic.php" method="POST">
        <div class="input-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="Akshay Datarkar" required>
        </div>
        
        <div class="input-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="akki@techie.com" required>
        </div>

        <div class="input-group">
            <label>I want to...</label>
            <select name="role" required>
                <option value="buyer">Buy/Rent Property (Buyer)</option>
                <option value="seller">List/Sell Property (Seller)</option>
            </select>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>
        
        <button type="submit" name="register_btn" class="btn-reg">Create Account</button>
    </form>

    <p style="margin-top: 20px; font-size: 0.9rem; color: #6B7280;">
        Already have an account? <a href="login.php" style="color: #7C3AED; text-decoration: none; font-weight: 700;">Login here</a>
    </p>
</div>
</body>
</html>