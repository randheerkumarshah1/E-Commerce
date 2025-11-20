<?php
include("../includes/db.php");
include("../includes/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home - E-Commerce</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
/* Hero Slider */
.hero-slider {position: relative; height: 80vh; overflow: hidden;}
.slides {display: flex; transition: transform 0.5s ease-in-out;}
.slide {width: 100%; flex-shrink: 0; height: 80vh; background-size: cover; background-position: center; position: relative;}
.slide .overlay {position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.5); display:flex; flex-direction: column; justify-content: center; align-items: center; text-align:center; color:#fff; padding: 20px;}
.slide h1 {font-size: 3rem; margin-bottom:10px;}
.slide p {font-size:1.2rem; margin-bottom:20px;}
.slide .btn {background: #ff9800; color:#fff; padding:12px 25px; border-radius:5px; text-decoration:none; font-weight:bold; transition: background 0.3s;}
.slide .btn:hover {background:#e68900;}
.slider-nav {position: absolute; top: 50%; width:100%; display:flex; justify-content: space-between; transform: translateY(-50%);}
.slider-nav span {cursor:pointer; font-size:2rem; color:#fff; padding:10px; user-select:none;}

/* Sections */
.section {max-width: 1200px; margin: 40px auto; padding: 0 20px;}
.section h2 { margin-bottom: 20px; }

/* Responsive Grid */
.grid {display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;}

/* Card Style */
.card {background: #fff; border-radius: 12px; padding: 15px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: 0.3s;}
.card:hover {transform: translateY(-5px); box-shadow: 0 4px 12px rgba(0,0,0,0.2);}
.card img {max-width: 100%; border-radius: 10px; margin-bottom: 10px;}
.card h3 { margin: 10px 0; font-size: 1.1rem; }
.card p { color: #555; }
.price { font-weight: bold; color: #007bff; margin: 10px 0; }
.btn {display: inline-block; background: #007bff; color: #fff; padding: 8px 16px; border-radius: 6px; text-decoration: none; transition: 0.3s;}
.btn:hover { background: #0056b3; }

/* Responsive Text */
@media(max-width:768px){
  .slide h1 {font-size:2rem;}
  .slide p {font-size:1rem;}
}
</style>
</head>
<body>

<!-- Hero Slider -->
<section class="hero-slider">
  <div class="slides">
    <div class="slide" style="background-image: url('../assets/images/banner1.jpg');">
      <div class="overlay">
        <h1>Welcome to Our Store</h1>
        <p>Shop the best products at amazing prices</p>
        <a href="shop.php" class="btn">Shop Now</a>
      </div>
    </div>
    <div class="slide" style="background-image: url('../assets/images/pexels-shvetsa-3962285.jpg');">
      <div class="overlay">
        <h1>New Arrivals</h1>
        <p>Discover the latest trends today</p>
        <a href="shop.php" class="btn">Shop Now</a>
      </div>
    </div>
    <div class="slide" style="background-image: url('../assets/images/baner2.jpg');">
      <div class="overlay">
        <h1>Best Deals</h1>
        <p>Grab the hottest deals before they are gone</p>
        <a href="shop.php" class="btn">Shop Now</a>
      </div>
    </div>
  </div>
  <div class="slider-nav">
    <span class="prev">&#10094;</span>
    <span class="next">&#10095;</span>
  </div>
</section>

<!-- Categories -->
<section class="section">
  <h2>Shop by Categories</h2>
  <div class="grid">
    <div class="card"><img src="../assets/images/download.jpg" alt="Category"><h3>Electronics</h3></div>
    <div class="card"><img src="../assets/images/images.jpg" alt="Category"><h3>Fashion</h3></div>
    <div class="card"><img src="../assets/images/kitchen.jpg" alt="Category"><h3>Home & Kitchen</h3></div>
    <div class="card"><img src="../assets/images/r0_0_1000_613_w1000_h613_fmax.jpg" alt="Category"><h3>Beauty</h3></div>
  </div>
</section>

<!-- Featured Products -->
<section class="section">
  <h2>Featured Products</h2>
  <div class="grid">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 8");
    while($row = mysqli_fetch_assoc($result)): ?>
      <div class="card">
        <img src="../assets/images/products/<?= $row['image']; ?>" alt="<?= htmlspecialchars($row['name']); ?>">
        <h3><?= htmlspecialchars($row['name']); ?></h3>
        <p class="price">₹<?= $row['price']; ?></p>
        <a href="product_detail.php?id=<?= $row['id']; ?>" class="btn">View</a>
        <a href="cart.php?action=add&id=<?= $row['id']; ?>" class="btn">Add to Cart</a>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<?php include("../includes/footer.php"); ?>

<script>
let currentIndex = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlide(index){
  const slidesContainer = document.querySelector('.slides');
  slidesContainer.style.transform = 'translateX(-'+ index * 100 +'%)';
}

// Auto slide every 5 seconds
setInterval(function(){
  currentIndex = (currentIndex + 1) % totalSlides;
  showSlide(currentIndex);
},5000);

// Navigation
document.querySelector('.prev').addEventListener('click', function(){
  currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
  showSlide(currentIndex);
});
document.querySelector('.next').addEventListener('click', function(){
  currentIndex = (currentIndex + 1) % totalSlides;
  showSlide(currentIndex);
});
</script>

</body>
</html>
