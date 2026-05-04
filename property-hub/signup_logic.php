<?php
// PHP Mailer include karna padega (Download PHPMailer via Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['signup'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $v_code = bin2hex(random_bytes(16)); // Unique Code

    // --- GRAVATAR IMAGE LOGIC ---
    // Email ko hash karke Gravatar se image fetch karna
    $hash = md5(strtolower(trim($email)));
    $default_image = "https://www.gravatar.com/avatar/$hash?s=200&d=mp"; 
    // 'd=mp' ka matlab agar image na ho toh default avatar dikhaye

    $query = "INSERT INTO users (name, email, password, profile_pic, verification_code, is_verified) 
              VALUES ('$name', '$email', '$password', '$default_image', '$v_code', 0)";

    if(mysqli_query($conn, $query)) {
        // --- EMAIL SENDING LOGIC ---
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; 
            $mail->Password = 'your-app-password'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('support@propertyhub.com', 'PropertyHub');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification - PropertyHub';
            $mail->Body = "Hi $name, <br> Please click the link to verify: 
            <a href='http://yourdomain.com/verify.php?email=$email&v_code=$v_code'>Verify Now</a>";

            $mail->send();
            echo "Verification email sent!";
        } catch (Exception $e) {
            echo "Mail error: {$mail->ErrorInfo}";
        }
    }
}