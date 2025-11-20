<?php
// Footer file
?>
<footer class="site-footer">
  <div class="footer-container">
    <!-- About -->
    <div class="footer-col">
      <h3>About Us</h3>
      <p>
        We are your one-stop shop for electronics, fashion, home essentials, and more.
        Quality products at the best prices, delivered to your doorstep.
      </p>
    </div>

    <!-- Quick Links -->
    <div class="footer-col">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="wishlist.php">Wishlist</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="checkout.php">Checkout</a></li>
      </ul>
    </div>

    <!-- Customer Service -->
    <div class="footer-col">
      <h3>Customer Service</h3>
      <ul>
        <li><a href="account.php">My Account</a></li>
        <li><a href="shipping-policy.php">Shipping Policy</a></li>
        <li><a href="return-policy.php">Return Policy</a></li>
        <li><a href="faqs.php">FAQs</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
    </div>

    <!-- Contact -->
    <div class="footer-col">
      <h3>Contact</h3>
      <p>Email: randheerkumarshah9213@gmail.com</p>
      <p>Phone: +91-9354025247</p>
      <div class="social">
        <a href="#"><img src="\ecommerce_project\assets\images\icons\733547.png" alt="Facebook"></a>
        <a href="#"><img src="\ecommerce_project\assets\images\icons\733579.png"alt="Twitter"></a>
        <a href="#"><img src="\ecommerce_project\assets\images\icons\2111463.png" alt="Instagram"></a>
        <a href="#"><img src="\ecommerce_project\assets\images\icons\1384060.png" alt="YouTube"></a>
      </div>
    </div>
  </div>

  <!-- Bottom -->
  <div class="footer-bottom">
    <p>&copy; <?= date("Y"); ?> My E-Commerce Store. All Rights Reserved.</p>
  </div>
</footer>

<style>
  .site-footer {
    background: #222;
    color: #ddd;
    padding: 40px 20px 20px;
    margin-top: 40px;
  }
  .footer-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: auto;
  }
  .footer-col h3 {
    margin-bottom: 15px;
    color: #fff;
  }
  .footer-col p {
    font-size: 14px;
    line-height: 1.6;
  }
  .footer-col ul {
    list-style: none;
    padding: 0;
  }
  .footer-col ul li {
    margin-bottom: 8px;
  }
  .footer-col ul li a {
    text-decoration: none;
    color: #ddd;
    font-size: 14px;
    transition: 0.3s;
  }
  .footer-col ul li a:hover {
    color: #007bff;
  }
  .social a img {
    width: 28px;
    margin-right: 10px;
    filter: brightness(0) invert(1);
    transition: 0.3s;
  }
  .social a img:hover {
    filter: brightness(0) invert(0.5) sepia(1) hue-rotate(190deg) saturate(5);
  }
  .footer-bottom {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid #444;
    margin-top: 20px;
    font-size: 14px;
  }
</style>
