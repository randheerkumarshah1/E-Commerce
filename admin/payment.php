<?php
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['current_order_id'])){
    header("Location: cart.php");
    exit;
}

$order_id = $_SESSION['current_order_id'];
$razorpay_order_id = $_SESSION['razorpay_order_id'];

$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id");
$order = mysqli_fetch_assoc($order_query);
?>

<h2>Complete Your Payment</h2>
<form action="verify_payment.php" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="YOUR_KEY_ID"
    data-amount="<?= $order['total_price']*100 ?>"
    data-currency="INR"
    data-order_id="<?= $razorpay_order_id ?>"
    data-buttontext="Pay ₹<?= $order['total_price'] ?>"
    data-name="RKS SHOP"
    data-description="Order #<?= $order_id ?>"
    data-prefill.name="<?= htmlspecialchars($order['name']) ?>"
    data-prefill.email="<?= htmlspecialchars($order['email']) ?>"
    data-prefill.contact="<?= htmlspecialchars($order['phone']) ?>"
    data-theme.color="#007bff">
</script>
</form>
