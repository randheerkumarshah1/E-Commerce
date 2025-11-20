<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$response = ['cart_items'=>'', 'total'=>0];

if ($_POST['action'] == "update") {
    $id = $_POST['id'];
    $qty = max(1, (int)$_POST['qty']);
    if (isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]['qty'] = $qty;
}

if ($_POST['action'] == "remove") {
    $id = $_POST['id'];
    if (isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);
}

if ($_POST['action'] == "save") {
    $id = $_POST['id'];
    if (isset($_SESSION['cart'][$id])) {
        $product = $_SESSION['cart'][$id];
        if (isset($_SESSION['user_id'])) {
            $uid = $_SESSION['user_id'];
            $pname = mysqli_real_escape_string($conn, $product['name']);
            $price = $product['price'];
            // Check if already in wishlist
            $check = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id=$uid AND product_name='$pname'");
            if(mysqli_num_rows($check) == 0){
                mysqli_query($conn, "INSERT INTO wishlist (user_id, product_name, price) VALUES ($uid,'$pname',$price)");
            }
        }
        unset($_SESSION['cart'][$id]);
    }
}


// Generate updated cart HTML
$total = 0;
$html = '';
foreach($_SESSION['cart'] as $id => $item){
    $subtotal = $item['price'] * $item['qty'];
    $total += $subtotal;
    $html .= '<tr id="item-'.$id.'">
        <td>'.htmlspecialchars($item['name']).'</td>
        <td>'.number_format($item['price'],2).'</td>
        <td><input type="number" value="'.$item['qty'].'" min="1" class="qty-input" data-id="'.$id.'" style="width:60px;"></td>
        <td class="subtotal">'.number_format($subtotal,2).'</td>
        <td><button class="btn btn-danger btn-sm remove-btn" data-id="'.$id.'">❌ Remove</button></td>
    </tr>';
}

$response['cart_items'] = $html;
$response['total'] = number_format($total,2);

echo json_encode($response);
