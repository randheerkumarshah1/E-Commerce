<?php
include '../includes/db.php';
if(isset($_GET['approve'])){
    $id = (int)$_GET['approve'];
    mysqli_query($conn,"UPDATE reviews SET status='approved' WHERE id=$id");
}
if(isset($_GET['reject'])){
    $id = (int)$_GET['reject'];
    mysqli_query($conn,"UPDATE reviews SET status='rejected' WHERE id=$id");
}
$reviews = mysqli_query($conn,"SELECT r.*, p.name as product_name, u.name as user_name FROM reviews r LEFT JOIN products p ON r.product_id=p.id LEFT JOIN users u ON r.user_id=u.id");
?>
<h2>Reviews Moderation</h2>
<table>
<tr><th>ID</th><th>Product</th><th>User</th><th>Rating</th><th>Comment</th><th>Status</th><th>Action</th></tr>
<?php while($r=mysqli_fetch_assoc($reviews)): ?>
<tr>
<td><?= $r['id'] ?></td>
<td><?= htmlspecialchars($r['product_name']) ?></td>
<td><?= htmlspecialchars($r['user_name']) ?></td>
<td><?= $r['rating'] ?></td>
<td><?= htmlspecialchars($r['comment']) ?></td>
<td><?= $r['status'] ?></td>
<td>
<a href="reviews.php?approve=<?= $r['id'] ?>" class="btn">Approve</a>
<a href="reviews.php?reject=<?= $r['id'] ?>" class="btn">Reject</a>
</td>
</tr>
<?php endwhile; ?>
</table>
