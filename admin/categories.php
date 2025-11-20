<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

// --- Admin check ---
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: login.php");
    exit;
}

// --- Handle Add Category ---
if(isset($_POST['add_category'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    if(!empty($name)){
        mysqli_query($conn,"INSERT INTO categories (name) VALUES ('$name')");
        $success = "Category added successfully!";
    } else {
        $error = "Category name cannot be empty!";
    }
}

// --- Handle Delete Category ---
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];

    // Check if any product uses this category
    $check = mysqli_query($conn,"SELECT * FROM products WHERE category_id=$id LIMIT 1");
    if(mysqli_num_rows($check) > 0){
        $error = "Cannot delete category. Some products are using it!";
    } else {
        mysqli_query($conn,"DELETE FROM categories WHERE id=$id");
        $success = "Category deleted successfully!";
    }
}


// --- Handle Update Category ---
if(isset($_POST['edit_category'])){
    $id = (int)$_POST['category_id'];
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    if(!empty($name)){
        mysqli_query($conn,"UPDATE categories SET name='$name' WHERE id=$id");
        $success = "Category updated successfully!";
    } else {
        $error = "Category name cannot be empty!";
    }
}

// --- Fetch all categories ---
$categories_res = mysqli_query($conn,"SELECT * FROM categories ORDER BY id DESC");
?>

<div class="container">
    <h2>Manage Categories</h2>

    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <!-- Add Category Form -->
    <form method="post" class="admin-form">
        <input type="text" name="name" placeholder="Category Name" required>
        <button type="submit" name="add_category" class="btn btn-success">Add Category</button>
    </form>

    <!-- Categories Table -->
    <table class="categories-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($c = mysqli_fetch_assoc($categories_res)): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td>
                    <!-- Edit Category Modal Trigger -->
                    <button onclick="editCategory(<?= $c['id'] ?>,'<?= htmlspecialchars($c['name'],ENT_QUOTES) ?>')" class="btn btn-warning btn-sm">Edit</button>
                    <a href="categories.php?delete=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Edit Category Modal -->
<div id="editModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
    <form method="post" style="background:#fff;padding:20px;border-radius:12px;max-width:400px;width:100%;">
        <h3>Edit Category</h3>
        <input type="hidden" name="category_id" id="category_id">
        <input type="text" name="name" id="category_name" required>
        <button type="submit" name="edit_category" class="btn btn-success">Update</button>
        <button type="button" onclick="closeModal()" class="btn btn-danger">Cancel</button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>

<script>
function editCategory(id,name){
    document.getElementById('category_id').value = id;
    document.getElementById('category_name').value = name;
    document.getElementById('editModal').style.display='flex';
}
function closeModal(){
    document.getElementById('editModal').style.display='none';
}
</script>

<style>
.container{max-width:1000px;margin:20px auto;padding:10px;}
.admin-form{margin-bottom:20px;}
.admin-form input{padding:10px;width:300px;margin-right:10px;border-radius:6px;border:1px solid #ccc;}
.admin-form button{padding:10px 15px;border:none;border-radius:6px;background:#28a745;color:#fff;cursor:pointer;}
.admin-form button:hover{background:#218838;}
.categories-table{width:100%;border-collapse:collapse;}
.categories-table th, .categories-table td{border:1px solid #ddd;padding:8px;text-align:center;}
.categories-table th{background:#007bff;color:#fff;}
.btn{padding:5px 10px;text-decoration:none;border-radius:6px;color:#fff;}
.btn-warning{background:#ffc107;}
.btn-warning:hover{background:#e0a800;}
.btn-danger{background:#dc3545;}
.btn-danger:hover{background:#c82333;}
</style>
