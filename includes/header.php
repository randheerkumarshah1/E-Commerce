<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include("db.php");

// Check if user/admin is logged in
$user_logged_in = false;
$user_data = [];

if(isset($_SESSION['user_id'])){
    $user_id = intval($_SESSION['user_id']);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id");
    if($result && mysqli_num_rows($result) > 0){
        $user_data = mysqli_fetch_assoc($result);
        $user_logged_in = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RKS SHOP</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* Navbar Styles */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:10px 20px;
    background:#007bff;
    color:#fff;
    flex-wrap:wrap;
}
.navbar a{ color:#fff; text-decoration:none; margin:0 10px; }
.navbar a:hover{ text-decoration:underline; }
.navbar .logo{ font-size:24px; font-weight:bold; }
.navbar .menu{ display:flex; align-items:center; flex-wrap:wrap; }
.navbar .menu a{ margin:5px 10px; }
.navbar .menu-right{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.navbar .menu-right a, .navbar .menu-right span{ display:flex; align-items:center; gap:5px; }
.navbar .cart-count{
    background:red; color:#fff; border-radius:50%; padding:2px 6px; font-size:12px;
}

/* Dropdown */
.dropdown{
    position:relative;
}
.dropdown-content{
    display:none;
    position:absolute;
    right:0;
    background:#fff;
    color:#333;
    min-width:140px;
    box-shadow:0 2px 8px rgba(0,0,0,0.2);
    border-radius:6px;
    z-index:100;
    flex-direction:column;
}
.dropdown-content a{
    color:#333;
    padding:10px 15px;
    text-decoration:none;
    display:block;
}
.dropdown-content a:hover{ background:#f1f1f1; }
.dropdown:hover .dropdown-content{ display:flex; flex-direction:column; }

/* Profile Image */
.profile-img{
    width:30px; height:30px; border-radius:50%; object-fit:cover;
}

/* Responsive */
@media(max-width:768px){
    .navbar{ flex-direction:column; align-items:flex-start; }
    .navbar .menu, .navbar .menu-right{ flex-direction:column; align-items:flex-start; }
}
</style>
</head>
<body>

<nav class="navbar">
    <div class="logo"><a href="index.php">RKS SHOP</a></div>

    <div class="menu">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="categories.php">Categories</a>
        <a href="brands.php">Brands</a>
        <a href="orders.php">Orders
        <a href="wishlist.php">Wishlist</a>
        <a href="cart.php">Cart
            <?php 
            $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            if($cart_count > 0) echo "<span class='cart-count'>$cart_count</span>";
            ?>
        </a>
    </div>

    <div class="menu-right">
        <?php if($user_logged_in): ?>
            <div class="dropdown">
                <span>
                    <?php
                    if(!empty($user_data['profile_image'])){
                        echo '<img src="assets/images/users/'.$user_data['profile_image'].'" class="profile-img"> ';
                    }
                    echo htmlspecialchars($user_data['name']);
                    ?>
                    <i class="fas fa-caret-down"></i>
                </span>
                <div class="dropdown-content">
                    <?php if($user_data['user_role']=='admin'): ?>
                        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <?php else: ?>
                        <a href="account.php"><i class="fas fa-user"></i> Account</a>
                    <?php endif; ?>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="register.php"><i class="fas fa-user-plus"></i> Register</a>
        <?php endif; ?>
    </div>
</nav>


