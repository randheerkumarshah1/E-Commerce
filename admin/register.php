<?php
session_start();
include("../includes/db.php");

$error = '';
$success = '';

if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Check password match
    if($password !== $confirm_password){
        $error = "Passwords do not match!";
    } else {
        // Check if email exists
        $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' LIMIT 1");
        if(mysqli_num_rows($check) > 0){
            $error = "Email already registered!";
        } else {
            $password_hash = password_hash($password,PASSWORD_DEFAULT);
            mysqli_query($conn,"INSERT INTO users (name,email,password,user_role) VALUES ('$name','$email','$password_hash','$role')");
            $success = "Registration successful! You can now login.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f5f5;}
.register-container{max-width:400px;margin:50px auto;padding:30px;background:#fff;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1);}
.register-container h2{text-align:center;margin-bottom:20px;}
.register-container input, .register-container select{width:100%;padding:10px;margin:8px 0;border-radius:6px;border:1px solid #ccc;}
.register-container button{width:100%;padding:12px;background:#007bff;color:#fff;border:none;border-radius:6px;cursor:pointer;}
.register-container button:hover{background:#0056b3;}
.success-msg{color:green;text-align:center;}
.error-msg{color:red;text-align:center;}
</style>
</head>
<body>
<div class="register-container">
    <h2>Register</h2>
    <?php if($error) echo "<p class='error-msg'>$error</p>"; ?>
    <?php if($success) echo "<p class='success-msg'>$success</p>"; ?>
    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="customer">Customer</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="register">Register</button>
    </form>
    <p style="text-align:center;margin-top:10px;">Already have an account? <a href="login.php">Login here</a></p>
    <p style="text-align:center;margin-top:10px;">Forget Password? <a href="forgot_password.php">Reset Password</a></p>
</div>
</body>
</html>
