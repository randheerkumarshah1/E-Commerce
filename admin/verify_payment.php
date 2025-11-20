<?php
include("../includes/db.php");
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

$success = true;
$error = "";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    try
    {
        $payment = $api->payment->fetch($_POST['razorpay_payment_id']);
        $order_id = $_SESSION['current_order_id'];

        // Update order status
        mysqli_query($conn, "UPDATE orders SET status='paid' WHERE id=$order_id");

        unset($_SESSION['cart'], $_SESSION['current_order_id'], $_SESSION['razorpay_order_id']);
        header("Location: success.php");
        exit;

    }
    catch(Exception $e)
    {
        $success = false;
        $error = $e->getMessage();
    }
}
else{
    $success = false;
    $error = "Payment failed!";
}

if(!$success){
    echo "<h3>Payment Error: $error</h3>";
}
?>
