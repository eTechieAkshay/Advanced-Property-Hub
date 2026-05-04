<?php 
session_start();
include('config/db.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PropertyHub Premium</title>
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #c3d8f5; font-family: 'Plus Jakarta Sans', sans-serif; margin:0; }
        .login-container { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); padding: 50px; border-radius: 35px; width: 100%; max-width: 450px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 25px 50px rgba(0,0,0,0.05); text-align: center; }
        .login-container h2 { font-size: 2.2rem; font-weight: 800; background: linear-gradient(to right, #1E1B4B, #7C3AED); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 10px; }
        .input-group { margin-bottom: 20px; text-align: left; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #4B5563; font-size: 0.9rem; }
        .input-group input { width: 100%; padding: 15px; border-radius: 15px; border: 1px solid rgba(124, 58, 237, 0.2); background: rgba(255, 255, 255, 0.9); outline: none; }
        .btn-login { width: 100%; background: #7C3AED; color: white; padding: 16px; border: none; border-radius: 15px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .btn-login:hover { transform: translateY(-3px); background: #6D28D9; }
        .error-msg { color: #EF4444; background: #FEE2E2; padding: 10px; border-radius: 10px; margin-bottom: 20px; font-size: 0.85rem; }
    </style>
</head>
<body>

<div class="login-container">
    <div style="margin-bottom: 20px;">
        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#7C3AED" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
    </div>
    <h2>Welcome Back</h2>
    <p style="color: #6B7280; margin-bottom: 30px;">Access your premium real estate dashboard.</p>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="error-msg"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="login_logic.php" method="POST">
        <div class="input-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="name@company.com" required>
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>
        
        <button type="submit" name="login_btn" class="btn-login">Sign In</button>
    </form>

    <p style="margin-top: 25px; font-size: 0.95rem; color: #6B7280;">
        Don't have an account? <a href="register.php" style="color: #7C3AED; text-decoration: none; font-weight: 700;">Create one</a>
    </p>
</div>

</body>
</html>