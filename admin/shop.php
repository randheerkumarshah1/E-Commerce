<?php
include("../includes/db.php");
include("../includes/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shop All Products - E-Commerce</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
/* Layout */
.section { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
.section h2 { margin-bottom: 20px; text-align:center; }

/* Grid */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
}

/* Card */
.card {
  background: #fff;
  border-radius: 12px;
  padding: 15px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  transition: 0.3s;
}
.card:hover { transform: translateY(-5px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.card img { max-width: 100%; border-radius: 10px; margin-bottom: 10px; }
.card h3 { margin: 10px 0; font-size: 1.1rem; }
.price { font-weight: bold; color: #007bff; margin: 10px 0; }
.btn {
  display: inline-block;
  background: #007bff;
  color: #fff;
  padding: 8px 16px;
  border-radius: 6px;
  text-decoration: none;
  transition: 0.3s;
}
.btn:hover { background: #0056b3; }

/* Filters */
.filters { display: flex; flex-wrap: wrap; justify-content: center; margin-bottom: 20px; }
.filters select, .filters input {
  padding: 8px 12px;
  margin: 5px;
  border-radius: 6px;
  border: 1px solid #ccc;
}
.filters button { margin: 5px; }

/* Pagination */
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 30px;
}
.pagination a {
  display: inline-block;
  margin: 0 5px;
  padding: 8px 14px;
  border: 1px solid #ccc;
  border-radius: 6px;
  text-decoration: none;
  color: #333;
}
.pagination a.active { background: #007bff; color: #fff; }
.pagination a:hover { background: #0056b3; color: #fff; }

/* Mobile */
@media(max-width:768px){
  .card h3 { font-size: 1rem; }
  .price { font-size: 0.95rem; }
}
</style>
</head>
<body>

<section class="section">
  <h2>Shop All Products</h2>

  <!-- Filters -->
  <div class="filters">
    <form method="GET">
      <select name="category">
        <option value="">All Categories</option>
        <?php
        $cat_result = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
        while($cat = mysqli_fetch_assoc($cat_result)){
          $selected = (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '';
          echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
        }
        ?>
      </select>

      <select name="sort">
        <option value="">Sort By</option>
        <option value="newest" <?php if(isset($_GET['sort']) && $_GET['sort']=='newest') echo 'selected'; ?>>Newest</option>
        <option value="oldest" <?php if(isset($_GET['sort']) && $_GET['sort']=='oldest') echo 'selected'; ?>>Oldest</option>
        <option value="price_low" <?php if(isset($_GET['sort']) && $_GET['sort']=='price_low') echo 'selected'; ?>>Price: Low → High</option>
        <option value="price_high" <?php if(isset($_GET['sort']) && $_GET['sort']=='price_high') echo 'selected'; ?>>Price: High → Low</option>
      </select>

      <input type="number" name="min_price" placeholder="Min Price" value="<?= isset($_GET['min_price']) ? $_GET['min_price'] : '' ?>">
      <input type="number" name="max_price" placeholder="Max Price" value="<?= isset($_GET['max_price']) ? $_GET['max_price'] : '' ?>">

      <button type="submit" class="btn">Apply</button>
    </form>
  </div>

  <!-- Products Grid -->
  <div class="grid">
    <?php
    // Pagination setup
    $limit = 9; // products per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Filters
    $where = "WHERE 1=1";
    if(isset($_GET['category']) && $_GET['category'] != ""){
      $cat_id = (int)$_GET['category'];
      $where .= " AND category_id = $cat_id";
    }
    if(isset($_GET['min_price']) && $_GET['min_price'] !== ""){
      $min_price = (int)$_GET['min_price'];
      $where .= " AND price >= $min_price";
    }
    if(isset($_GET['max_price']) && $_GET['max_price'] !== ""){
      $max_price = (int)$_GET['max_price'];
      $where .= " AND price <= $max_price";
    }

    // Sorting
    $order = "ORDER BY created_at DESC";
    if(isset($_GET['sort'])){
      switch($_GET['sort']){
        case 'oldest': $order = "ORDER BY created_at ASC"; break;
        case 'price_low': $order = "ORDER BY price ASC"; break;
        case 'price_high': $order = "ORDER BY price DESC"; break;
      }
    }

    // Total count
    $count_query = "SELECT COUNT(*) as total FROM products $where";
    $count_result = mysqli_query($conn, $count_query);
    $total_products = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_products / $limit);

    // Fetch products
    $query = "SELECT * FROM products $where $order LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)): ?>
        <div class="card">
          <img src="../assets/images/products/<?= $row['image']; ?>" alt="<?= htmlspecialchars($row['name']); ?>">
          <h3><?= htmlspecialchars($row['name']); ?></h3>
          <p class="price">₹<?= $row['price']; ?></p>
          <a href="product_detail.php?id=<?= $row['id']; ?>" class="btn">View</a>
          <a href="cart.php?action=add&id=<?= $row['id']; ?>" class="btn">Add to Cart</a>
        </div>
      <?php endwhile;
    } else {
      echo "<p>No products found.</p>";
    }
    ?>
  </div>

  <!-- Pagination -->
  <div class="pagination">
    <?php
    if($total_pages > 1){
      for($i=1; $i <= $total_pages; $i++){
        $active = ($i == $page) ? "active" : "";
        $query_string = $_GET;
        $query_string['page'] = $i;
        echo "<a href='?".http_build_query($query_string)."' class='$active'>$i</a>";
      }
    }
    ?>
  </div>

</section>

<?php include("../includes/footer.php"); ?>
</body>
</html>

