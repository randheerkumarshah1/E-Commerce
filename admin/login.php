<?php
session_start();
include("../includes/db.php");

$error = '';

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $role = $_POST['role'];

    // Check user
    $res = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND user_role='$role' LIMIT 1");
    if(mysqli_num_rows($res) == 1){
        $user = mysqli_fetch_assoc($res);
        if(password_verify($password,$user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $row['name']; 
            $_SESSION['user_email'] = $user['email']; 
            $_SESSION['user_role'] = $user['user_role'];

            if($role == 'admin'){
                header("Location: dashboard.php");
                exit;
            } else {
                header("Location: account.php");
                exit;
            }
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found or role mismatch!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f5f5;}
.login-container{max-width:400px;margin:50px auto;padding:30px;background:#fff;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1);}
.login-container h2{text-align:center;margin-bottom:20px;}
.login-container input, .login-container select{width:100%;padding:10px;margin:8px 0;border-radius:6px;border:1px solid #ccc;}
.login-container button{width:100%;padding:12px;background:#28a745;color:#fff;border:none;border-radius:6px;cursor:pointer;}
.login-container button:hover{background:#218838;}
.error-msg{color:red;text-align:center;}
</style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <?php if($error) echo "<p class='error-msg'>$error</p>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="customer">Customer</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="login">Login</button>
    </form>
    <p style="text-align:center;margin-top:10px;">Don't have an account? <a href="register.php">Register here</a></p>
    <p style="text-align:center;margin-top:10px;">Forget Password? <a href="forgot_password.php">Forget Password</a></p>
</div>
</body>
</html>

