<?php
include '../includes/db.php';
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    mysqli_query($conn,"INSERT INTO vendors(name,email) VALUES('$name','$email')");
    header("Location: vendors.php");
}
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM vendors WHERE id=$id");
    header("Location: vendors.php");
}
$vendors = mysqli_query($conn,"SELECT * FROM vendors");
?>
<h2>Vendors</h2>
<form method="post">
<input type="text" name="name" placeholder="Vendor Name" required>
<input type="email" name="email" placeholder="Email" required>
<button type="submit" name="add" class="btn">Add</button>
</form>

<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Action</th></tr>
<?php while($v=mysqli_fetch_assoc($vendors)): ?>
<tr>
<td><?= $v['id'] ?></td>
<td><?= htmlspecialchars($v['name']) ?></td>
<td><?= htmlspecialchars($v['email']) ?></td>
<td><?= $v['status'] ?></td>
<td><a href="vendors.php?delete=<?= $v['id'] ?>" class="btn">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
