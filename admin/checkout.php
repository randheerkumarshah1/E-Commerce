<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
$cart = $_SESSION['cart'] ?? [];

if(empty($cart)){
    echo "<script>alert('Your cart is empty!'); window.location='products.php';</script>";
    exit;
}

if(isset($_POST['checkout'])){
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $delivery_address = mysqli_real_escape_string($conn, $_POST['delivery_address']);
    $delivery_phone = mysqli_real_escape_string($conn, $_POST['delivery_phone']);

    $total_amount = 0;
    foreach($cart as $item){
        $total_amount += $item['price'] * $item['qty'];
    }

    mysqli_query($conn, "INSERT INTO orders (user_id, total_amount, payment_method, delivery_address, delivery_phone, status, created_at)
        VALUES ($user_id, $total_amount, '$payment_method', '$delivery_address', '$delivery_phone', 'Pending', NOW())");

    $order_id = mysqli_insert_id($conn);

    foreach($cart as $item){
        $product_id = intval($item['id']);
        $qty = intval($item['qty']);
        $price = floatval($item['price']);
        mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) 
            VALUES ($order_id, $product_id, $qty, $price)");
    }

    // checkout.php ke andar (checkout success ke baad)
unset($_SESSION['cart']);
echo "<script>window.location='order_success.php?order_id=$order_id';</script>";
exit;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
body{ font-family:Arial, sans-serif; background:#f5f5f5; margin:0; padding:0; }
.section{ max-width:900px; margin:40px auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h2{ text-align:center; color:#007bff; margin-bottom:20px; }
.checkout-form{ display:flex; flex-direction:column; gap:15px; }
.checkout-form label{ font-weight:bold; }
.checkout-form input, .checkout-form textarea, .checkout-form select{ padding:12px; border-radius:6px; border:1px solid #ccc; width:100%; }
.checkout-form button{ padding:12px; border:none; border-radius:6px; background:#007bff; color:#fff; cursor:pointer; font-size:16px; transition:0.3s; }
.checkout-form button:hover{ background:#0056b3; }

.cart-summary{ margin-top:30px; }
.cart-summary h3{ margin-bottom:10px; color:#333; }
.cart-summary ul{ list-style:none; padding:0; }
.cart-summary ul li{ padding:10px; border-bottom:1px solid #ddd; display:flex; justify-content:space-between; }
.cart-summary p.total{ text-align:right; font-size:18px; font-weight:bold; margin-top:10px; }

@media(max-width:768px){
    .checkout-form{ gap:10px; }
    .cart-summary ul li{ flex-direction:column; align-items:flex-start; }
    .cart-summary p.total{ text-align:left; }
}
</style>
</head>
<body>

<div class="section">
    <h2>Checkout</h2>
    <form method="POST" class="checkout-form">
        <label>Delivery Address</label>
        <textarea name="delivery_address" placeholder="Enter your delivery address" required></textarea>

        <label>Mobile Number</label>
        <input type="text" name="delivery_phone" placeholder="Enter your mobile number" required pattern="\d{10}" title="Enter 10 digit mobile number">

        <label>Payment Method</label>
        <select name="payment_method" required>
            <option value="">Select Payment Method</option>
            <option value="COD">Cash on Delivery</option>
            <option value="Razorpay">Razorpay</option>
        </select>

        <button type="submit" name="checkout">Place Order</button>
    </form>

    <div class="cart-summary">
        <h3>Your Cart</h3>
        <ul>
            <?php foreach($cart as $item): ?>
                <li>
                    <span><?= htmlspecialchars($item['name']); ?> x <?= $item['qty']; ?></span>
                    <span>₹<?= $item['price'] * $item['qty']; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="total">Total: ₹<?= array_sum(array_map(fn($i)=>$i['price']*$i['qty'], $cart)); ?></p>
    </div>
</div>

</body>
</html>
