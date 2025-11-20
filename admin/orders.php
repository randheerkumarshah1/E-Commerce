<?php
session_start();
include("../includes/db.php");

// अगर user login नहीं है तो login पर भेज दो
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role']; // admin या user

// Admin status update कर सकता है
if($user_role === 'admin' && isset($_POST['update_status'])){
    $order_id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$order_id");
    echo "<script>alert('Order status updated!'); window.location='orders.php';</script>";
}

// Orders fetch करो
if($user_role === 'admin'){
    // Admin सब देखेगा
    $orders = mysqli_query($conn, "SELECT o.*, u.username 
        FROM orders o 
        LEFT JOIN users u ON o.user_id=u.id 
        ORDER BY o.created_at DESC");
} else {
    // User सिर्फ अपने orders देखेगा
    $orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id=$user_id ORDER BY created_at DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $user_role==='admin' ? 'Manage Orders (Admin)' : 'My Orders'; ?></title>
<style>
body{ font-family:Arial, sans-serif; background:#f4f6f9; margin:0; padding:0; }
.container{ max-width:1100px; margin:40px auto; background:#fff; padding:25px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h2{ text-align:center; margin-bottom:20px; color:#007bff; }

.table{ width:100%; border-collapse:collapse; margin-top:20px; }
.table th, .table td{ border:1px solid #ddd; padding:10px; text-align:center; }
.table th{ background:#007bff; color:#fff; }

.status{
    padding:6px 12px;
    border-radius:20px;
    font-weight:bold;
    font-size:14px;
    display:inline-block;
}
.pending{ background:#ffc107; color:#fff; }
.processing{ background:#17a2b8; color:#fff; }
.shipped{ background:#007bff; color:#fff; }
.delivered{ background:#28a745; color:#fff; }
.cancelled{ background:#dc3545; color:#fff; }

form{ margin:0; }
select{ padding:6px; border-radius:6px; border:1px solid #ccc; }
button{ padding:6px 12px; background:#28a745; color:#fff; border:none; border-radius:6px; cursor:pointer; }
button:hover{ background:#218838; }
</style>
</head>
<body>

<div class="container">
    <h2><?= $user_role==='admin' ? '📋 Manage Orders' : '🛒 My Orders'; ?></h2>
    <table class="table">
        <tr>
            <th>ID</th>
            <?php if($user_role==='admin'): ?><th>User</th><?php endif; ?>
            <th>Total (₹)</th>
            <th>Payment</th>
            <th>Delivery Address</th>
            <th>Phone</th>
            <th>Status</th>
            <?php if($user_role==='admin'): ?><th>Action</th><?php endif; ?>
        </tr>
        <?php while($o=mysqli_fetch_assoc($orders)): ?>
        <tr>
            <td><?= $o['id']; ?></td>
            <?php if($user_role==='admin'): ?><td><?= htmlspecialchars($o['username']); ?></td><?php endif; ?>
            <td><?= $o['total_amount']; ?></td>
            <td><?= $o['payment_method']; ?></td>
            <td><?= htmlspecialchars($o['delivery_address']); ?></td>
            <td><?= htmlspecialchars($o['delivery_phone']); ?></td>
            <td>
                <span class="status <?= strtolower($o['status']); ?>">
                    <?= $o['status']; ?>
                </span>
            </td>
            <?php if($user_role==='admin'): ?>
            <td>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $o['id']; ?>">
                    <select name="status">
                        <option value="Pending" <?= $o['status']=="Pending"?"selected":""; ?>>Pending</option>
                        <option value="Processing" <?= $o['status']=="Processing"?"selected":""; ?>>Processing</option>
                        <option value="Shipped" <?= $o['status']=="Shipped"?"selected":""; ?>>Shipped</option>
                        <option value="Delivered" <?= $o['status']=="Delivered"?"selected":""; ?>>Delivered</option>
                        <option value="Cancelled" <?= $o['status']=="Cancelled"?"selected":""; ?>>Cancelled</option>
                    </select>
                    <button type="submit" name="update_status">Update</button>
                </form>
            </td>
            <?php endif; ?>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
