<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

// --- Admin check ---
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: adminlogin.php");
    exit;
}

// --- Get product ID ---
if(!isset($_GET['id'])){ 
    header("Location: products.php"); 
    exit; 
}

$id = (int)$_GET['id'];

// --- Fetch product ---
$product_res = mysqli_query($conn,"SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($product_res);
if(!$product){
    header("Location: products.php");
    exit;
}

// --- Fetch categories and brands ---
$categories_res = mysqli_query($conn,"SELECT * FROM categories");
$brands_res = mysqli_query($conn,"SELECT * FROM brands");

// --- Handle Update ---
if(isset($_POST['update_product'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $price = mysqli_real_escape_string($conn,$_POST['price']);
    $stock = mysqli_real_escape_string($conn,$_POST['stock']);
    $category_id = (int)$_POST['category_id'];
    $brand_id = (int)$_POST['brand_id'];
    $description = mysqli_real_escape_string($conn,$_POST['description']);

    $image_name = $product['image']; // current image

    // Handle new image
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $new_image = time().'_'.basename($_FILES['image']['name']);
        $target_dir = "../assets/images/products/";
        if(!is_dir($target_dir)) mkdir($target_dir,0777,true);
        $target_file = $target_dir . $new_image;
        if(move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
            $image_name = $new_image;
            // Optionally delete old image
            if(file_exists($target_dir.$product['image']) && $product['image']!='default.png'){
                unlink($target_dir.$product['image']);
            }
        }
    }

    mysqli_query($conn,"UPDATE products SET 
        name='$name', price='$price', stock='$stock', 
        category_id='$category_id', brand_id='$brand_id', 
        description='$description', image='$image_name' 
        WHERE id=$id");
    
    $success = "Product updated successfully!";
    // Refresh product data
    $product_res = mysqli_query($conn,"SELECT * FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($product_res);
}
?>

<div class="container">
    <h2>Edit Product</h2>

    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="post" enctype="multipart/form-data" class="admin-form">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
        <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php while($cat=mysqli_fetch_assoc($categories_res)) {
                $selected = $cat['id']==$product['category_id'] ? 'selected' : '';
                echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
            } ?>
        </select>
        <select name="brand_id" required>
            <option value="">Select Brand</option>
            <?php
            mysqli_data_seek($brands_res,0);
            while($brand=mysqli_fetch_assoc($brands_res)){
                $selected = $brand['id']==$product['brand_id'] ? 'selected' : '';
                echo "<option value='{$brand['id']}' $selected>{$brand['name']}</option>";
            }
            ?>
        </select>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
        <p>Current Image:</p>
        <img src="../assets/images/products/<?= $product['image'] ?>" width="100" alt="Product Image">
        <input type="file" name="image">
        <button type="submit" name="update_product" class="btn btn-success">Update Product</button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>

<style>
.container{max-width:800px;margin:20px auto;padding:10px;}
.admin-form{display:flex;flex-wrap:wrap;gap:10px;}
.admin-form input, .admin-form select, .admin-form textarea{padding:10px;border-radius:6px;border:1px solid #ccc;width:100%;}
.admin-form textarea{height:80px;}
.admin-form button{padding:10px 15px;border:none;border-radius:6px;background:#28a745;color:#fff;cursor:pointer;}
.admin-form button:hover{background:#218838;}
</style>
