<?php
session_start();
include('../includes/db.php');


$message = '';
$show_form = false;

if(isset($_GET['token'])){
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $res = mysqli_query($conn,"SELECT * FROM users WHERE reset_token='$token' AND reset_expires > NOW()");
    if(mysqli_num_rows($res)==1){
        $show_form = true;
        $user = mysqli_fetch_assoc($res);
    } else {
        $message = "Invalid or expired reset token.";
    }
}

if(isset($_POST['reset'])){
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $password = md5($_POST['password']); // use bcrypt in production
    $cpassword = md5($_POST['cpassword']);

    if($password !== $cpassword){
        $message = "Passwords do not match";
        $show_form = true;
    } else {
        mysqli_query($conn,"UPDATE users SET password='$password', reset_token=NULL, reset_expires=NULL WHERE reset_token='$token'");
        $message = "Password successfully reset! <a href='login.php'>Login here</a>";
        $show_form = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password - E-Commerce</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
body{display:flex;justify-content:center;align-items:center;height:100vh;background:#f0f2f5;}
.reset-container{background:#fff;padding:40px;border-radius:12px;box-shadow:0 0 15px rgba(0,0,0,0.1);width:100%;max-width:400px;}
.reset-container h2{text-align:center;margin-bottom:25px;color:#333;}
.reset-container form{display:flex;flex-direction:column;}
.reset-container input{padding:12px;margin-bottom:15px;border-radius:8px;border:1px solid #ccc;font-size:16px;}
.reset-container button{padding:12px;background:#17a2b8;color:#fff;border:none;border-radius:8px;font-size:16px;cursor:pointer;transition:0.3s;}
.reset-container button:hover{background:#117a8b;}
.reset-container a{margin-top:10px;text-align:center;color:#007bff;text-decoration:none;font-size:14px;}
.reset-container a:hover{text-decoration:underline;}
.message{color:green;text-align:center;margin-bottom:10px;}
.error{color:red;text-align:center;margin-bottom:10px;}
</style>
</head>
<body>
<div class="reset-container">
<h2>Reset Password</h2>
<?php if($message): ?><p class="<?= $show_form ? 'error':'message' ?>"><?= $message ?></p><?php endif; ?>

<?php if($show_form): ?>
<form method="post">
<input type="password" name="password" placeholder="New Password" required>
<input type="password" name="cpassword" placeholder="Confirm Password" required>
<input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
<button type="submit" name="reset">Reset Password</button>
</form>
<?php endif; ?>

<a href="login.php">Back to Login</a>
</div>
</body>
</html>
