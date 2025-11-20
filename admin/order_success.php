<?php
session_start();
include("../includes/db.php");

if(!isset($_GET['order_id'])){
    header("Location: index.php");
    exit;
}

$order_id = intval($_GET['order_id']);
$order = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id");
if(mysqli_num_rows($order) == 0){
    echo "Invalid Order ID!";
    exit;
}
$order = mysqli_fetch_assoc($order);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Success</title>
<style>
body{ font-family:Arial, sans-serif; background:#f5f5f5; margin:0; padding:0; }
.container{ max-width:800px; margin:40px auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); text-align:center; }
h2{ color:#28a745; margin-bottom:20px; }
.order-info{ text-align:left; margin:20px 0; }
.status-box{ margin:30px 0; }
.status-step{ padding:12px; border-radius:8px; margin:10px 0; font-weight:bold; }
.pending{ background:#ffc107; color:#fff; }
.processing{ background:#17a2b8; color:#fff; }
.shipped{ background:#007bff; color:#fff; }
.delivered{ background:#28a745; color:#fff; }
.cancelled{ background:#dc3545; color:#fff; }

.btn{ display:inline-block; padding:12px 20px; margin-top:20px; background:#007bff; color:#fff; border:none; border-radius:6px; text-decoration:none; font-size:16px; transition:0.3s; }
.btn:hover{ background:#0056b3; }
</style>
</head>
<body>

<div class="container">
    <h2>🎉 Order Placed Successfully!</h2>
    <p>Your order ID: <b>#<?= $order['id']; ?></b></p>
    <div class="order-info">
        <p><b>Total Amount:</b> ₹<?= $order['total_amount']; ?></p>
        <p><b>Payment Method:</b> <?= $order['payment_method']; ?></p>
        <p><b>Delivery Address:</b> <?= $order['delivery_address']; ?></p>
        <p><b>Mobile:</b> <?= $order['delivery_phone']; ?></p>
    </div>

    <div class="status-box">
        <h3>🚚 Order Status</h3>
        <div class="status-step <?= strtolower($order['status']); ?>">
            <?= $order['status']; ?>
        </div>
    </div>

    <a href="index.php" class="btn">🏠 Go to Home</a>
</div>

</body>
</html>
