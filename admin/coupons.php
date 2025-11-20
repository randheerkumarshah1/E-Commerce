<?php
include '../includes/db.php';
if(isset($_POST['add'])){
    $code = $_POST['code'];
    $type = $_POST['type'];
    $amount = (float)$_POST['amount'];
    $expires = $_POST['expires'];
    $limit = (int)$_POST['limit'];
    mysqli_query($conn,"INSERT INTO coupons(code,discount_type,amount,expires_at,usage_limit) VALUES('$code','$type',$amount,'$expires',$limit)");
    header("Location: coupons.php");
}

if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM coupons WHERE id=$id");
    header("Location: coupons.php");
}

$coupons = mysqli_query($conn,"SELECT * FROM coupons");
?>
<h2>Coupons</h2>
<form method="post">
<input type="text" name="code" placeholder="Coupon Code" required>
<select name="type"><option value="percent">Percent</option><option value="fixed">Fixed</option></select>
<input type="number" name="amount" placeholder="Amount" required>
<input type="date" name="expires" required>
<input type="number" name="limit" placeholder="Usage Limit" required>
<button type="submit" name="add" class="btn">Add</button>
</form>

<table>
<tr><th>ID</th><th>Code</th><th>Type</th><th>Amount</th><th>Expires</th><th>Limit</th><th>Action</th></tr>
<?php while($c=mysqli_fetch_assoc($coupons)): ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= htmlspecialchars($c['code']) ?></td>
<td><?= $c['discount_type'] ?></td>
<td><?= $c['amount'] ?></td>
<td><?= $c['expires_at'] ?></td>
<td><?= $c['usage_limit'] ?></td>
<td><a href="coupons.php?delete=<?= $c['id'] ?>" class="btn">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
