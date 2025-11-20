<?php
include '../includes/db.php';
if(isset($_POST['update'])){
    $uid = (int)$_POST['user_id'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    mysqli_query($conn,"UPDATE users SET role='$role', status='$status' WHERE id=$uid");
}

$users = mysqli_query($conn,"SELECT * FROM users ORDER BY created_at DESC");
?>
<h2>Users</h2>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Action</th></tr>
<?php while($u=mysqli_fetch_assoc($users)): ?>
<tr>
<td><?= $u['id'] ?></td>
<td><?= htmlspecialchars($u['name']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>
<td><?= $u['role'] ?></td>
<td><?= $u['status'] ?></td>
<td>
<form method="post">
<input type="hidden" name="user_id" value="<?= $u['id'] ?>">
<select name="role">
<option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>Admin</option>
<option value="manager" <?= $u['role']=='manager'?'selected':'' ?>>Manager</option>
<option value="support" <?= $u['role']=='support'?'selected':'' ?>>Support</option>
<option value="customer" <?= $u['role']=='customer'?'selected':'' ?>>Customer</option>
</select>
<select name="status">
<option value="active" <?= $u['status']=='active'?'selected':'' ?>>Active</option>
<option value="blocked" <?= $u['status']=='blocked'?'selected':'' ?>>Blocked</option>
</select>
<button type="submit" name="update" class="btn">Update</button>
</form>
</td>
</tr>
<?php endwhile; ?>
</table>
