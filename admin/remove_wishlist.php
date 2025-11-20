<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user_id'])){
    echo "<script>alert('Please login first'); window.location='login.php';</script>";
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
mysqli_query($conn, "DELETE FROM wishlist WHERE id=$id AND user_id=".$_SESSION['user_id']);
echo "<script>alert('Removed from wishlist'); window.location='wishlist.php';</script>";
