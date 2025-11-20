<?php
include('../includes/db.php');
session_start();

// Redirect if not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$user_sql = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_sql);

// Fetch orders
$order_sql = mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$user_id' ORDER BY created_at DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Account</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .account-container {
      max-width: 1200px;
      margin: 30px auto;
      padding: 20px;
      display: grid;
      grid-template-columns: 1fr 3fr;
      gap: 20px;
    }
    .account-sidebar {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .account-sidebar h3 {
      margin-bottom: 15px;
    }
    .account-sidebar a {
      display: block;
      padding: 10px;
      margin-bottom: 8px;
      background: #f8f9fa;
      border-radius: 8px;
      text-decoration: none;
      color: #333;
      transition: 0.3s;
    }
    .account-sidebar a:hover {
      background: #007bff;
      color: #fff;
    }
    .account-main {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .profile-info {
      margin-bottom: 30px;
    }
    .profile-info h2 {
      margin-bottom: 10px;
    }
    .orders {
      margin-top: 20px;
    }
    .order-card {
      border: 1px solid #eee;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 15px;
    }
    .order-card h4 {
      margin: 0 0 10px 0;
    }
    .status {
      display: inline-block;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 14px;
    }
    .status.pending { background:#fff3cd; color:#856404; }
    .status.shipped { background:#cce5ff; color:#004085; }
    .status.delivered { background:#d4edda; color:#155724; }
    .status.cancelled { background:#f8d7da; color:#721c24; }
    @media(max-width:768px){
      .account-container{
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <?php 
  include("../includes/header.php");
   ?>

  <div class="account-container">
    <!-- Sidebar -->
    <div class="account-sidebar">
      <h3>My Account</h3>
      <a href="account.php">Profile</a>
      <a href="wishlist.php">My Wishlist</a>
      <a href="cart.php">My Cart</a>
      <a href="checkout.php">Checkout</a>
      <a href="logout.php">Logout</a>
    </div>

    <!-- Main -->
    <div class="account-main">
      <div class="profile-info">
        <h2>Hello, <?= htmlspecialchars($user['name']); ?> 👋</h2>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <a href="edit_profile.php"><button>Edit Profile</button></a>
      </div>

      <div class="orders">
        <h3>My Orders</h3>
        <?php if(mysqli_num_rows($order_sql) > 0): ?>
          <?php while($order = mysqli_fetch_assoc($order_sql)): ?>
            <div class="order-card">
              <h4>Order #<?= $order['id']; ?></h4>
              <p><strong>Date:</strong> <?= $order['created_at']; ?></p>
              <p><strong>Total:</strong> ₹<?= $order['total_amount']; ?></p>
              <p class="status <?= strtolower($order['status']); ?>">
                <?= ucfirst($order['status']); ?>
              </p>
              <a href="orders.php?id=<?= $order['id']; ?>">Tracking</a>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>You have no orders yet.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php include("../includes/footer.php"); ?>

</body>
</html>
