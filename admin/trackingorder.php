<?php
session_start();
include("../includes/db.php");

// अगर user login नहीं है
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Order ID check
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$order = null;

if($order_id > 0){
    $res = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id AND user_id=$user_id");
    if(mysqli_num_rows($res) > 0){
        $order = mysqli_fetch_assoc($res);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Track Order</title>
<style>
body{ font-family:Arial, sans-serif; background:#f4f6f9; margin:0; padding:0; }
.container{ max-width:800px; margin:40px auto; background:#fff; padding:25px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h2{ text-align:center; margin-bottom:20px; color:#007bff; }
.order-info{ margin-bottom:20px; padding:10px; border:1px solid #ddd; border-radius:8px; background:#fafafa; }

.tracking-steps{ list-style:none; padding:0; margin:0; position:relative; }
.tracking-steps::before{
    content:""; position:absolute; top:0; left:20px; width:4px; height:100%; background:#ddd;
}
.tracking-steps li{
    position:relative; padding-left:50px; margin-bottom:30px;
}
.tracking-steps li::before{
    content:""; position:absolute; left:12px; top:5px; width:16px; height:16px; border-radius:50%; background:#ddd; border:3px solid #fff; box-shadow:0 0 0 2px #ddd;
}
.tracking-steps li.active::before{
    background:#28a745; box-shadow:0 0 0 2px #28a745;
}
.tracking-steps li span{
    display:block; font-weight:bold; color:#333;
}
.tracking-steps li small{ color:#666; }

.back-btn{ display:inline-block; margin-top:20px; padding:10px 20px; background:#007bff; color:#fff; border-radius:6px; text-decoration:none; }
.back-btn:hover{ background:#0056b3; }
</style>
</head>
<body>

<div class="container">
    <h2>📦 Track Your Order</h2>

    <?php if($order): ?>
    <div class="order-info">
        <p><b>Order ID:</b> <?= $order['id']; ?></p>
        <p><b>Total:</b> ₹<?= $order['total_amount']; ?></p>
        <p><b>Current Status:</b> <?= $order['status']; ?></p>
    </div>

    <ul class="tracking-steps">
        <li class="<?= ($order['status']=="Pending" || $order['status']!="")?'active':''; ?>">
            <span>Order Placed</span>
            <small>Your order has been placed successfully.</small>
        </li>
        <li class="<?= ($order['status']=="Processing" || in_array($order['status'],["Shipped","Delivered"]))?'active':''; ?>">
            <span>Processing</span>
            <small>Your order is being prepared.</small>
        </li>
        <li class="<?= ($order['status']=="Shipped" || $order['status']=="Delivered")?'active':''; ?>">
            <span>Shipped</span>
            <small>Your order is on the way.</small>
        </li>
        <li class="<?= ($order['status']=="Delivered")?'active':''; ?>">
            <span>Delivered</span>
            <small>Your order has been delivered.</small>
        </li>
    </ul>

    <a href="orders.php" class="back-btn">⬅ Back to Orders</a>

    <?php else: ?>
        <p>No order found or you don’t have permission to track this order.</p>
        <a href="orders.php" class="back-btn">⬅ Back to Orders</a>
    <?php endif; ?>
</div>

</body>
</html>
