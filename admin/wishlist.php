<?php
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id'])){
    echo "<script>alert('Please login first'); window.location='login.php';</script>";
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Remove from wishlist
if(isset($_GET['remove'])){
    $product_id = intval($_GET['remove']);
    mysqli_query($conn, "DELETE FROM wishlist WHERE user_id=$user_id AND product_id=$product_id");
    echo "<script>alert('Product removed from wishlist'); window.location='wishlist.php';</script>";
}

// Fetch wishlist
$wishlist = mysqli_query($conn, "
    SELECT w.*, p.name, p.price, p.image 
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = $user_id
    ORDER BY w.created_at DESC
");
?>

<div class="section">
<h2>My Wishlist</h2>

<?php if(mysqli_num_rows($wishlist) == 0): ?>
    <p>Your wishlist is empty. <a href="products.php">Shop Now</a></p>
<?php else: ?>
<div class="grid">
    <?php while($item=mysqli_fetch_assoc($wishlist)): ?>
        <div class="card">
            <div class="card-img">
                <img src="../assets/images/products/<?= $item['image'] ?: 'default.png'; ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                <div class="overlay">
                    <a href="wishlist.php?remove=<?= $item['product_id']; ?>" class="btn remove">Remove</a>
                    <a href="cart.php?action=add&id=<?= $item['product_id']; ?>" class="btn cart">Add to Cart</a>
                </div>
            </div>
            <div class="card-info">
                <h3><?= htmlspecialchars($item['name']); ?></h3>
                <p class="price">₹<?= $item['price']; ?></p>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php endif; ?>
</div>

<style>
.section{ max-width:220px; margin:40px auto; padding:0 20px; }
.section h2{ margin-bottom:20px; text-align:center; color:#007bff; }

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.card{
    position:relative;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
    transition:0.3s;
}
.card:hover{
    transform:translateY(-5px);
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
}
.card-img{ position:relative; }
.card-img img{ width:100%; display:block; }
.overlay{
    position:absolute;
    bottom:0;
    left:0;
    width:100%;
    display:flex;
    justify-content:space-around;
    gap:10px;
    padding:10px 0;
    background:rgba(0,0,0,0.6);
    opacity:0;
    transition:0.3s;
}
.card:hover .overlay{ opacity:1; }

.btn{
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
    color:#fff;
    font-size:0.9rem;
    transition:0.3s;
}
.btn.remove{ background:#dc3545; }
.btn.remove:hover{ background:#a71d2a; }
.btn.cart{ background:#28a745; }
.btn.cart:hover{ background:#1e7e34; }

.card-info{ padding:15px; text-align:center; }
.card-info h3{ margin:10px 0; font-size:1.1rem; }
.card-info p.price{ font-weight:bold; color:#007bff; margin:5px 0; }

/* Responsive */
@media(max-width:768px){
    .grid{ grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); }
    .overlay{ flex-direction:column; }
}
</style>

<?php include("../includes/footer.php"); ?>


