<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

// --- Admin check ---
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: adminlogin.php");
    exit;
}

// --- Summary data ---
$total_sales_res = mysqli_query($conn,"SELECT SUM(price*stock) as total_sales FROM products");
$total_sales = mysqli_fetch_assoc($total_sales_res)['total_sales'] ?? 0;

$total_orders_res = mysqli_query($conn,"SELECT COUNT(*) as total_orders FROM orders");
$total_orders = mysqli_fetch_assoc($total_orders_res)['total_orders'] ?? 0;

$top_products_res = mysqli_query($conn,"SELECT * FROM products ORDER BY stock DESC LIMIT 5");

// --- All products for list ---
$products_res = mysqli_query($conn,"SELECT p.*, c.name as category_name, b.name as brand_name 
                                   FROM products p 
                                   LEFT JOIN categories c ON p.category_id=c.id
                                   LEFT JOIN brands b ON p.brand_id=b.id
                                   ORDER BY p.id DESC");
?>

<div class="container">
    <h2 class="mb-4">Admin Dashboard</h2>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="card">
            <h4>Total Sales</h4>
            <p>₹<?= number_format($total_sales,2) ?></p>
        </div>
        <div class="card">
            <h4>Total Orders</h4>
            <p><?= $total_orders ?></p>
        </div>
    </div>

    <!-- Top Products -->
    <h4 class="mt-4">Top Products (by Stock)</h4>
    <div class="top-products">
        <?php while($p = mysqli_fetch_assoc($top_products_res)): ?>
            <div class="top-product-card">
                <img src="../assets/images/products/<?= $p['image'] ?? 'default.png' ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                <p><?= htmlspecialchars($p['name']) ?></p>
                <p>Stock: <?= $p['stock'] ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Products List -->
    <h4 class="mt-4">All Products</h4>
    <table class="products-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price (₹)</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p=mysqli_fetch_assoc($products_res)): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= number_format($p['price'],2) ?></td>
                <td><?= $p['stock'] ?></td>
                <td><?= htmlspecialchars($p['category_name']) ?></td>
                <td><?= htmlspecialchars($p['brand_name']) ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_product.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include("../includes/footer.php"); ?>

<style>
.container{max-width:1200px;margin:20px auto;padding:10px;}
.summary-cards{display:flex;gap:20px;flex-wrap:wrap;margin-bottom:30px;}
.summary-cards .card{flex:1; min-width:200px;background:#f8f9fa;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);text-align:center;}
.top-products{display:flex;gap:15px;flex-wrap:wrap;margin-bottom:30px;}
.top-product-card{flex:1; min-width:150px;background:#fff;padding:10px;border-radius:10px;box-shadow:0 2px 5px rgba(0,0,0,0.1);text-align:center;}
.top-product-card img{width:100%; height:100px; object-fit:cover; border-radius:8px;}
.products-table{width:100%;border-collapse:collapse;margin-bottom:50px;}
.products-table th, .products-table td{border:1px solid #ddd;padding:8px;text-align:center;}
.products-table th{background:#007bff;color:#fff;}
.btn{padding:5px 10px;text-decoration:none;border-radius:6px;color:#fff;}
.btn-warning{background:#ffc107;}
.btn-warning:hover{background:#e0a800;}
.btn-danger{background:#dc3545;}
.btn-danger:hover{background:#c82333;}
</style>
