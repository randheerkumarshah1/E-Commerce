<?php
session_start();
include("includes/db.php");

// Check login
if(!isset($_SESSION['user_id'])){
    echo "<script>alert('Please login to add products to wishlist'); window.location='login.php';</script>";
    exit;
}

$user_id = intval($_SESSION['user_id']);
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Already exists?
$check = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id=$user_id AND product_id=$product_id");
if(mysqli_num_rows($check) > 0){
    echo "<script>alert('This product is already in your wishlist'); window.location='wishlist.php';</script>";
    exit;
}

// Insert
mysqli_query($conn, "INSERT INTO wishlist (user_id, product_id, created_at) VALUES ($user_id, $product_id, NOW())");
echo "<script>alert('Product added to wishlist'); window.location='wishlist.php';</script>";
