<?php
include("../includes/db.php");
include("../includes/header.php");

// Get product ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product
$product_result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($product_result);

if(!$product){
    echo "<h2>Product not found!</h2>";
    include("../includes/footer.php");
    exit;
}

// Fetch related products (same category)
$related = mysqli_query($conn, "SELECT * FROM products WHERE category_id=".$product['category_id']." AND id!=$id LIMIT 8");

// Fetch reviews (safe check if order_items table exists)
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'order_items'");
if(mysqli_num_rows($check_table) > 0){
    $reviews = mysqli_query($conn, "
        SELECT r.*, u.name AS username, u.user_role,
               (SELECT COUNT(*) FROM orders o 
                JOIN order_items oi ON o.id=oi.order_id
                WHERE o.user_id=r.user_id AND oi.product_id=r.product_id) as purchased
        FROM reviews r
        JOIN users u ON r.user_id=u.id
        WHERE r.product_id=$id
        ORDER BY r.created_at DESC
    ");
} else {
    $reviews = false; // reviews fetch skip
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($product['name']); ?> - Product Detail</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
<link rel="stylesheet" href="../assets/css/style.css">

<style>
/* Product Detail Layout */
.product-detail {
  max-width:1200px;
  margin:30px auto;
  display:flex;
  flex-wrap:wrap;
  gap:20px;
  padding:0 15px;
}
.product-images { flex:1; min-width:280px; max-width:600px; }
.product-images img { width:100%; border-radius:10px; }

.product-info { flex:1; min-width:280px; }
.product-info h1 { font-size:2rem; margin-bottom:10px; }
.product-info .price { font-size:1.5rem; color:#007bff; margin:10px 0; }
.product-info .btn {
  background:#007bff; color:#fff; padding:10px 20px;
  border-radius:6px; text-decoration:none; display:inline-block;
  margin-top:10px;
}
.product-info .btn:hover { background:#0056b3; }

/* Reviews */
.review-card { background:#f9f9f9; padding:15px; border-radius:10px; margin-bottom:10px; }
.review-card h4 { margin:0 0 5px 0; }

/* Related Products */
.related-products .card {
  background:#fff;
  border-radius:10px;
  padding:10px;
  text-align:center;
  box-shadow:0 2px 8px rgba(0,0,0,0.1);
}
.related-products .card img { width:100%; height:180px; object-fit:cover; border-radius:8px; }
.related-products .card h3 { font-size:1rem; margin:10px 0; }
.related-products .card .price { color:#007bff; font-weight:bold; margin-bottom:10px; }
.related-products .card .btn { display:block; margin:5px auto; padding:6px 12px; }

/* Responsive */
@media(max-width:768px){
  .product-detail{ flex-direction:column; }
}
</style>
</head>
<body>

<div class="product-detail">

  <!-- Images Slider -->
  <div class="product-images swiper mySwiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <img src="../assets/images/products/<?= $product['image']; ?>" alt="<?= htmlspecialchars($product['name']); ?>">
      </div>
      <?php
      if(!empty($product['images'])){
          $imgs = explode(',', $product['images']);
          foreach($imgs as $img){
              echo '<div class="swiper-slide"><img src="../assets/images/products/'.$img.'" alt="'.$product['name'].'"></div>';
          }
      }
      ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>

  <!-- Product Info -->
  <div class="product-info">
    <h1><?= htmlspecialchars($product['name']); ?></h1>
    <p class="price">₹<?= $product['price']; ?></p>
    <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
    <a href="cart.php?action=add&id=<?= $product['id']; ?>" class="btn">Add to Cart</a>
  </div>

</div>

<!-- Reviews Section -->
<section class="section" style="max-width:900px; margin:30px auto; padding:0 15px;">
<h2>Customer Reviews</h2>
<?php if($reviews && mysqli_num_rows($reviews) > 0): ?>
  <?php while($rev = mysqli_fetch_assoc($reviews)): ?>
    <div class="review-card">
      <h4><?= htmlspecialchars($rev['username']); ?> (<?= $rev['user_role']; ?>)</h4>
      <p><?= nl2br(htmlspecialchars($rev['comment'])); ?></p>
      <small>Purchased: <?= $rev['purchased'] > 0 ? 'Yes' : 'No'; ?></small>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <p>No reviews yet.</p>
<?php endif; ?>
</section>

<!-- Related Products -->
<section class="related-products section" style="max-width:1200px; margin:30px auto; padding:0 15px;">
  <h2>Related Products</h2>
  <div class="swiper relatedSwiper">
    <div class="swiper-wrapper">
      <?php while($rel=mysqli_fetch_assoc($related)): ?>
      <div class="swiper-slide card">
        <img src="../assets/images/products/<?= $rel['image']; ?>" alt="<?= htmlspecialchars($rel['name']); ?>">
        <h3><?= htmlspecialchars($rel['name']); ?></h3>
        <p class="price">₹<?= $rel['price']; ?></p>
        <a href="product_detail.php?id=<?= $rel['id']; ?>" class="btn">View</a>
        <a href="cart.php?action=add&id=<?= $rel['id']; ?>" class="btn">Add to Cart</a>
      </div>
      <?php endwhile; ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>
</section>

<?php include("../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
// Main product images slider
var swiper = new Swiper(".mySwiper", {
  spaceBetween: 10,
  slidesPerView: 1,
  loop: true,
  navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
  pagination: { el: ".swiper-pagination", clickable: true },
});

// Related products slider
var relatedSwiper = new Swiper(".relatedSwiper", {
  spaceBetween: 20,
  slidesPerView: 1,
  navigation: { nextEl: ".relatedSwiper .swiper-button-next", prevEl: ".relatedSwiper .swiper-button-prev" },
  pagination: { el: ".relatedSwiper .swiper-pagination", clickable: true },
  breakpoints: {
    640: { slidesPerView: 1 },
    768: { slidesPerView: 2 },
    1024: { slidesPerView: 3 },
    1200: { slidesPerView: 4 },
  },
});
</script>

</body>
</html>

