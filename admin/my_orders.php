<?php
session_start();
include("../includes/db.php");

// मान लो कि user login system है और user_id session में store है
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch all orders of this user
$orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id=$user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Orders</title>
<style>
body{ font-family:Arial, sans-serif; background:#f8f9fa; margin:0; padding:0; }
.container{ max-width:1000px; margin:40px auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h2{ text-align:center; color:#007bff; margin-bottom:20px; }

.order-card{
    border:1px solid #ddd;
    border-radius:10px;
    padding:15px;
    margin-bottom:20px;
    background:#fff;
    transition:0.3s;
}
.order-card:hover{ box-shadow:0 4px 12px rgba(0,0,0,0.15); }

.order-header{
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    margin-bottom:10px;
}
.order-header h3{ margin:0; font-size:18px; }
.order-header small{ color:#666; }

.order-details{ margin:10px 0; color:#444; }

.status{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    font-weight:bold;
    font-size:14px;
}
.pending{ background:#ffc107; color:#fff; }
.processing{ background:#17a2b8; color:#fff; }
.shipped{ background:#007bff; color:#fff; }
.delivered{ background:#28a745; color:#fff; }
.cancelled{ background:#dc3545; color:#fff; }

.btn{
    display:inline-block;
    padding:8px 14px;
    margin-top:10px;
    background:#007bff;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    transition:0.3s;
}
.btn:hover{ background:#0056b3; }

.no-orders{
    text-align:center;
    font-size:18px;
    color:#666;
    padding:40px 0;
}
</style>
</head>
<body>

<div class="container">
    <h2>📦 My Orders</h2>

    <?php if(mysqli_num_rows($orders) > 0): ?>
        <?php while($o=mysqli_fetch_assoc($orders)): ?>
            <div class="order-card">
                <div class="order-header">
                    <h3>Order #<?= $o['id']; ?></h3>
                    <small>Placed on <?= date("d M Y, h:i A", strtotime($o['created_at'])); ?></small>
                </div>
                <div class="order-details">
                    <p><b>Total:</b> ₹<?= $o['total_amount']; ?></p>
                    <p><b>Payment:</b> <?= $o['payment_method']; ?></p>
                    <p><b>Delivery:</b> <?= $o['delivery_address']; ?> (📱 <?= $o['delivery_phone']; ?>)</p>
                </div>
                <div class="status <?= strtolower($o['status']); ?>">
                    <?= $o['status']; ?>
                </div>
                <br>
                <a href="order_success.php?order_id=<?= $o['id']; ?>" class="btn">View Details</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-orders">
            😕 You haven’t placed any orders yet.<br>
            <a href="index.php" class="btn">🛒 Start Shopping</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
