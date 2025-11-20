<?php
session_start();
include("../includes/db.php");

// Initialize cart if not exists
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// Add product to cart
if(isset($_GET['action']) && $_GET['action'] == "add" && isset($_GET['id'])){
    $product_id = intval($_GET['id']);

    // Fetch product info from DB
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$product_id");
    if($result && mysqli_num_rows($result) > 0){
        $product = mysqli_fetch_assoc($result);

        // If product already in cart, increment quantity
        if(isset($_SESSION['cart'][$product_id])){
            $_SESSION['cart'][$product_id]['qty'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                "name" => $product['name'],
                "price" => $product['price'],
                "image" => $product['image'],
                "qty" => 1
            ];
        }
        $_SESSION['message'] = $product['name']." added to cart!";
    } else {
        $_SESSION['message'] = "Product not found!";
    }

    // Redirect back to previous page or products page
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "products.php";
    header("Location: $redirect");
    exit;
}

// Remove product from cart
if(isset($_GET['action']) && $_GET['action'] == "remove" && isset($_GET['id'])){
    $product_id = intval($_GET['id']);
    if(isset($_SESSION['cart'][$product_id])){
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['message'] = "Product removed from cart!";
    }
    header("Location: cart.php");
    exit;
}

// Update quantities
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update_cart'])){
    foreach($_POST['quantities'] as $id => $qty){
        $id = intval($id);
        $qty = intval($qty);
        if($qty <= 0){
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['qty'] = $qty;
        }
    }
    $_SESSION['message'] = "Cart updated!";
    header("Location: cart.php");
    exit;
}
?>

<?php include("../includes/header.php"); ?>

<div class="section">
<h2>My Cart</h2>

<?php if(isset($_SESSION['message'])): ?>
    <p style="color:green"><?= $_SESSION['message']; unset($_SESSION['message']); ?></p>
<?php endif; ?>

<?php if(!empty($_SESSION['cart'])): ?>
<form method="post">
<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
    </tr>
    <?php $grand_total = 0; ?>
    <?php foreach($_SESSION['cart'] as $id => $item): ?>
    <tr>
        <td><?= htmlspecialchars($item['name']); ?></td>
        <td>₹<?= $item['price']; ?></td>
        <td>
            <input type="number" name="quantities[<?= $id ?>]" value="<?= $item['qty']; ?>" min="1" style="width:60px;">
        </td>
        <td>₹<?= $item['price'] * $item['qty']; ?></td>
        <td><a href="cart.php?action=remove&id=<?= $id; ?>">Remove</a></td>
    </tr>
    <?php $grand_total += $item['price'] * $item['qty']; endforeach; ?>
    <tr>
        <td colspan="3" align="right"><strong>Grand Total:</strong></td>
        <td colspan="2"><strong>₹<?= $grand_total; ?></strong></td>
    </tr>
</table>
<br>
<input type="submit" name="update_cart" value="Update Cart">
<a href="checkout.php" class="btn">Proceed to Checkout</a>
</form>
<?php else: ?>
<p>Your cart is empty.</p>
<?php endif; ?>

</div>

<?php include("../includes/footer.php"); ?>
