<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

// --- Admin check ---
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: login.php");
    exit;
}

// --- Handle Add Brand ---
if(isset($_POST['add_brand'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    if(!empty($name)){
        mysqli_query($conn,"INSERT INTO brands (name) VALUES ('$name')");
        $success = "Brand added successfully!";
    } else {
        $error = "Brand name cannot be empty!";
    }
}

// --- Handle Delete Brand ---
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];

    // Check if any product uses this brand
    $check = mysqli_query($conn,"SELECT * FROM products WHERE brand_id=$id LIMIT 1");
    if(mysqli_num_rows($check) > 0){
        $error = "Cannot delete brand. Some products are using it!";
    } else {
        mysqli_query($conn,"DELETE FROM brands WHERE id=$id");
        $success = "Brand deleted successfully!";
    }
}

// --- Handle Update Brand ---
if(isset($_POST['edit_brand'])){
    $id = (int)$_POST['brand_id'];
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    if(!empty($name)){
        mysqli_query($conn,"UPDATE brands SET name='$name' WHERE id=$id");
        $success = "Brand updated successfully!";
    } else {
        $error = "Brand name cannot be empty!";
    }
}

// --- Fetch all brands ---
$brands_res = mysqli_query($conn,"SELECT * FROM brands ORDER BY id DESC");
?>

<div class="container">
    <h2>Manage Brands</h2>

    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <!-- Add Brand Form -->
    <form method="post" class="admin-form">
        <input type="text" name="name" placeholder="Brand Name" required>
        <button type="submit" name="add_brand" class="btn btn-success">Add Brand</button>
    </form>

    <!-- Brands Table -->
    <table class="brands-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Brand Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($b = mysqli_fetch_assoc($brands_res)): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= htmlspecialchars($b['name']) ?></td>
                <td>
                    <!-- Edit Brand Modal Trigger -->
                    <button onclick="editBrand(<?= $b['id'] ?>,'<?= htmlspecialchars($b['name'],ENT_QUOTES) ?>')" class="btn btn-warning btn-sm">Edit</button>
                    <a href="brands.php?delete=<?= $b['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Edit Brand Modal -->
<div id="editModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
    <form method="post" style="background:#fff;padding:20px;border-radius:12px;max-width:400px;width:100%;">
        <h3>Edit Brand</h3>
        <input type="hidden" name="brand_id" id="brand_id">
        <input type="text" name="name" id="brand_name" required>
        <button type="submit" name="edit_brand" class="btn btn-success">Update</button>
        <button type="button" onclick="closeModal()" class="btn btn-danger">Cancel</button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>

<script>
function editBrand(id,name){
    document.getElementById('brand_id').value = id;
    document.getElementById('brand_name').value = name;
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
.brands-table{width:100%;border-collapse:collapse;}
.brands-table th, .brands-table td{border:1px solid #ddd;padding:8px;text-align:center;}
.brands-table th{background:#007bff;color:#fff;}
.btn{padding:5px 10px;text-decoration:none;border-radius:6px;color:#fff;}
.btn-warning{background:#ffc107;}
.btn-warning:hover{background:#e0a800;}
.btn-danger{background:#dc3545;}
.btn-danger:hover{background:#c82333;}
</style>
