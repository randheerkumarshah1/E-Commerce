<?php
session_start();
include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['last_order'])){
    echo "<p class='text-center mt-5'>No recent order found. <a href='index.php'>Go shopping</a></p>";
    include("includes/footer.php");
    exit;
}

$order_id = $_SESSION['last_order'];
$uid = $_SESSION['user_id'] ?? 0;

$order_res = mysqli_query($conn,"SELECT * FROM orders WHERE order_id='$order_id' AND user_id='$uid'");
?>

<div class="container order-confirmation-page">
    <h2 class="text-center mb-4">✅ Order Confirmation</h2>

    <div class="order-card">
        <h4>Thank you for your purchase!</h4>
        <p>Order ID: <strong><?= $order_id ?></strong></p>
        <h5>Order Details:</h5>
        <ul>
        <?php
        $total = 0;
        while($item = mysqli_fetch_assoc($order_res)):
            $subtotal = $item['price']*$item['qty'];
            $total += $subtotal;
        ?>
            <li><?= htmlspecialchars($item['product_name']) ?> x<?= $item['qty'] ?> - ₹<?= number_format($subtotal,2) ?></li>
        <?php endwhile; ?>
        </ul>
        <h5>Total Paid: ₹<?= number_format($total,2) ?></h5>
        <p>Payment Method: <?= htmlspecialchars($item['payment_method']) ?></p>
        <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<style>
.order-card{
    max-width:600px;
    margin:40px auto;
    padding:25px;
    background:#fff;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    text-align:center;
}
.order-card h4{ margin-bottom:15px; }
.order-card ul{ list-style:none; padding:0; margin:10px 0; }
.order-card li{ margin-bottom:8px; display:flex; justify-content:space-between; }
</style>
