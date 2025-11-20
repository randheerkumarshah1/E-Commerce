<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>'error','message'=>'Login first']);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

if($product_id <= 0){
    echo json_encode(['status'=>'error','message'=>'Invalid product']);
    exit;
}

if($action === 'add'){
    $check = mysqli_query($conn,"SELECT * FROM wishlist WHERE user_id=$user_id AND product_id=$product_id");
    if(mysqli_num_rows($check) > 0){
        echo json_encode(['status'=>'exists','message'=>'Already in wishlist']);
        exit;
    }
    mysqli_query($conn,"INSERT INTO wishlist (user_id, product_id, created_at) VALUES ($user_id,$product_id,NOW())");
    echo json_encode(['status'=>'added','message'=>'Added to wishlist']);
    exit;
}

if($action === 'remove'){
    mysqli_query($conn,"DELETE FROM wishlist WHERE user_id=$user_id AND product_id=$product_id");
    echo json_encode(['status'=>'removed','message'=>'Removed from wishlist']);
    exit;
}

echo json_encode(['status'=>'error','message'=>'Invalid action']);
