<?php
session_start();
include('../includes/db.php');


$message = '';
if(isset($_POST['reset'])){
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check)==1){
        $token = bin2hex(random_bytes(50));
        mysqli_query($conn,"UPDATE users SET reset_token='$token', reset_expires=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email='$email'");
        
        $reset_link = "http://".$_SERVER['HTTP_HOST']."/reset_password.php?token=$token";
        // Here you can send email using PHPMailer
        $message = "Password reset link sent! <br> <a href='$reset_link'>$reset_link</a> (For demo, direct link shown)";
    } else {
        $message = "Email not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password - E-Commerce</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
body{display:flex;justify-content:center;align-items:center;height:100vh;background:#f0f2f5;}
.forgot-container{background:#fff;padding:40px;border-radius:12px;box-shadow:0 0 15px rgba(0,0,0,0.1);width:100%;max-width:400px;}
.forgot-container h2{text-align:center;margin-bottom:25px;color:#333;}
.forgot-container form{display:flex;flex-direction:column;}
.forgot-container input{padding:12px;margin-bottom:15px;border-radius:8px;border:1px solid #ccc;font-size:16px;}
.forgot-container button{padding:12px;background:#ffc107;color:#fff;border:none;border-radius:8px;font-size:16px;cursor:pointer;transition:0.3s;}
.forgot-container button:hover{background:#e0a800;}
.forgot-container a{margin-top:10px;text-align:center;color:#007bff;text-decoration:none;font-size:14px;}
.forgot-container a:hover{text-decoration:underline;}
.message{color:green;text-align:center;margin-bottom:10px;}
</style>
</head>
<body>
<div class="forgot-container">
<h2>Forgot Password</h2>
<?php if($message): ?><p class="message"><?= $message ?></p><?php endif; ?>
<form method="post">
<input type="email" name="email" placeholder="Enter your registered email" required>
<button type="submit" name="reset">Send Reset Link</button>
</form>
<a href="login.php">Back to Login</a>
</div>
</body>
</html>
