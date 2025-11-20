<?php
include '../includes/header.php';
if(!isset($_SESSION['save_for_later'])) $_SESSION['save_for_later'] = [];

if(isset($_GET['move_back'])){
    $pid = (int)$_GET['move_back'];
    $_SESSION['cart'][$pid] = $_SESSION['save_for_later'][$pid];
    unset($_SESSION['save_for_later'][$pid]);
    header("Location: cart.php");
}
?>
