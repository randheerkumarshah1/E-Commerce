<?php
include("../includes/db.php");
include("../includes/header.php");

// Check user role
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

// Admin: Handle Add Product
if($is_admin && isset($_POST['add_product'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $brand_id = intval($_POST['brand_id']);

    $img_name = 'default.png';
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $img_name = time().'_'.basename($_FILES['image']['name']);
        $target = "../assets/images/products/".$img_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    mysqli_query($conn, "INSERT INTO products (name, price, category_id, brand_id, image, created_at) 
        VALUES ('$name', $price, $category_id, $brand_id, '$img_name', NOW())");
    echo "<script>alert('Product added successfully'); window.location='products.php';</script>";
}

// Admin: Handle Edit Product
if($is_admin && isset($_POST['edit_product'])){
    $product_id = intval($_POST['product_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $brand_id = intval($_POST['brand_id']);

    $update_img = "";
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $img_name = time().'_'.basename($_FILES['image']['name']);
        $target = "../assets/images/products/".$img_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $update_img = ", image='$img_name'";
    }

    mysqli_query($conn, "UPDATE products SET name='$name', price=$price, category_id=$category_id, brand_id=$brand_id $update_img WHERE id=$product_id");
    echo "<script>alert('Product updated successfully'); window.location='products.php';</script>";
}

// Admin: Handle Delete Product
if($is_admin && isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    echo "<script>alert('Product deleted'); window.location='products.php';</script>";
}

// Fetch Products
$products = mysqli_query($conn, "SELECT p.*, c.name AS category_name, b.name AS brand_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id=c.id
    LEFT JOIN brands b ON p.brand_id=b.id
    ORDER BY p.created_at DESC");

// Fetch Categories & Brands for Admin Forms
if($is_admin){
    $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
    $brands = mysqli_query($conn, "SELECT * FROM brands ORDER BY name ASC");
}

// If editing, fetch product info
$edit_product = null;
if($is_admin && isset($_GET['edit'])){
    $pid = intval($_GET['edit']);
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id=$pid");
    if(mysqli_num_rows($res) > 0){
        $edit_product = mysqli_fetch_assoc($res);
    }
}
?>

<div class="section">
    <h2>Products</h2>

    <?php if($is_admin): ?>
    <!-- Admin: Add / Edit Product Form -->
    <form method="POST" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="product_id" value="<?= $edit_product['id'] ?? '' ?>">
        <input type="text" name="name" placeholder="Product Name" value="<?= $edit_product['name'] ?? '' ?>" required>
        <input type="number" step="0.01" name="price" placeholder="Price" value="<?= $edit_product['price'] ?? '' ?>" required>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php while($cat=mysqli_fetch_assoc($categories)): ?>
                <option value="<?= $cat['id']; ?>" <?= isset($edit_product) && $edit_product['category_id']==$cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <select name="brand_id" required>
            <option value="">Select Brand</option>
            <?php while($b=mysqli_fetch_assoc($brands)): ?>
                <option value="<?= $b['id']; ?>" <?= isset($edit_product) && $edit_product['brand_id']==$b['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($b['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <input type="file" name="image" accept="image/*">
        <?php if($edit_product): ?>
            <button type="submit" name="edit_product">Update Product</button>
            <a href="products.php" class="btn" style="background:#6c757d;">Cancel Edit</a>
        <?php else: ?>
            <button type="submit" name="add_product">Add Product</button>
        <?php endif; ?>
    </form>
    <?php endif; ?>

    <!-- Products Grid -->
    <div class="grid">
        <?php while($p=mysqli_fetch_assoc($products)): ?>
            <div class="card">
                <img src="../assets/images/products/<?= !empty($p['image']) ? $p['image'] : 'default.png'; ?>" alt="<?= htmlspecialchars($p['name']); ?>">
                <h3><?= htmlspecialchars($p['name']); ?></h3>
                <p>Category: <?= htmlspecialchars($p['category_name']); ?></p>
                <p>Brand: <?= htmlspecialchars($p['brand_name']); ?></p>
                <p class="price">₹<?= $p['price']; ?></p>

                <?php if($is_admin): ?>
                    <a href="products.php?edit=<?= $p['id']; ?>" class="btn" style="background:#ffc107;">Edit</a>
                    <a href="products.php?delete=<?= $p['id']; ?>" onclick="return confirm('Are you sure?')" class="btn">Delete</a>
                <?php else: ?>
                    <a href="product_detail.php?id=<?= $p['id']; ?>" class="btn">View</a>
                    <a href="cart.php?action=add&id=<?= $p['id']; ?>" class="btn">Add to Cart</a>
                <?php endif; ?>
                <?php if(!$is_admin): ?>
                       <a href="javascript:void(0)" class="btn wishlist-btn" data-id="<?= $p['id']; ?>"> Wishlist</a>
<?php endif; ?>

            </div>
        <?php endwhile; ?>
    </div>
</div>

<style>
/* Section & Grid */
.section{ max-width:1200px; margin:40px auto; padding:0 20px; }
.section h2{ margin-bottom:20px; }

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

.card{
    background:#fff;
    border-radius:12px;
    padding:15px;
    text-align:center;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
    transition:0.3s;
}
.card:hover{
    transform:translateY(-5px);
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
}
.card img{ max-width:100%; border-radius:10px; margin-bottom:10px; }
.card h3{ margin:10px 0; font-size:1.1rem; }
.card p{ color:#555; }
.price{ font-weight:bold; color:#007bff; margin:10px 0; }
.btn{
    display:inline-block;
    background:#007bff;
    color:#fff;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
    transition:0.3s;
    margin:2px 0;
}
.btn:hover{ background:#0056b3; }

/* Admin Form */
.admin-form{ display:flex; flex-wrap:wrap; gap:10px; margin-bottom:30px; }
.admin-form input, .admin-form select, .admin-form button{
    padding:8px 12px; border-radius:6px; border:1px solid #ccc;
}
.admin-form button{ background:#28a745; color:#fff; border:none; cursor:pointer; }
.admin-form button:hover{ background:#218838; }

/* Responsive */
@media(max-width:768px){
    .admin-form{ flex-direction:column; }
}
</style>

<?php include("../includes/footer.php"); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('.wishlist-btn').on('click', function(){
    let btn = $(this);
    let pid = btn.data('id');
    $.post('wishlist_action.php', {product_id: pid, action: 'add'}, function(res){
        let data = JSON.parse(res);
        alert(data.message);
        if(data.status === 'added'){
            btn.css('background','red'); // Change color to indicate added
            btn.text('Added to Wishlist');
        }
    });
});
</script>

