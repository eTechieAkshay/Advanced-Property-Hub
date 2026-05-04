<?php
session_start();
include('../config/db.php');

if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = "Access Denied: Invalid Credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Secure Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #7C3AED;
        }

        body { 
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Ultra Modern Gradient Background */
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            overflow: hidden;
        }

        /* Background Animated Circles for Depth */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            z-index: 1;
            filter: blur(50px);
        }

        .login-card {
            position: relative;
            z-index: 10;
            width: 400px;
            padding: 50px 40px;
            /* Real Glassmorphism */
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 35px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
            text-align: center;
            color: white;
        }

        .logo-area {
            width: 70px;
            height: 70px;
            background: white;
            color: var(--primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 28px;
            font-weight: 800;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        h2 { margin: 0 0 10px; font-weight: 800; font-size: 26px; }
        .subtitle { color: rgba(255,255,255,0.8); font-size: 14px; margin-bottom: 35px; }

        .input-group { text-align: left; margin-bottom: 20px; }
        label { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.9); margin-left: 5px; }

        input {
            width: 100%;
            padding: 15px 20px;
            margin-top: 8px;
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 15px;
            transition: 0.4s;
        }

        input::placeholder { color: rgba(255,255,255,0.5); }

        input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
            box-shadow: 0 0 15px rgba(255,255,255,0.2);
        }

        button {
            width: 100%;
            padding: 16px;
            background: white;
            border: none;
            color: var(--primary);
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            border-radius: 15px;
            margin-top: 15px;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            background: #f8fafc;
        }

        .error-msg {
            background: rgba(239, 68, 68, 0.2);
            color: #ffb3b3;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body>
    <!-- Background Decor Circles -->
    <div class="circle" style="width: 300px; height: 300px; top: -50px; right: -50px; background: #7C3AED;"></div>
    <div class="circle" style="width: 200px; height: 200px; bottom: -50px; left: -50px; background: #3B82F6;"></div>

    <div class="login-card">
        <div class="logo-area">PH</div>
        <h2>Admin Panel</h2>
        <p class="subtitle">Secure Glassmorphism Auth Interface</p>

        <?php if(isset($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label>Admin ID</label>
                <input type="email" name="email" placeholder="admin@propertyhub.com" required>
            </div>
            <div class="input-group">
                <label>Access Key</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" name="login">Authorize & Enter</button>
        </form>
        
        <p style="margin-top: 30px; font-size: 11px; color: rgba(255,255,255,0.6); font-weight: 600;">
            SYSTEM SECURED BY PROPERTYHUB ENCRYPTION
        </p>
    </div>
</body>
</html>