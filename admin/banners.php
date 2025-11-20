<?php
include '../includes/db.php';
if(isset($_POST['add'])){
    $title = $_POST['title'];
    $link = $_POST['link'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/".$image);
    mysqli_query($conn,"INSERT INTO banners(title,link,image,active) VALUES('$title','$link','$image',1)");
    header("Location: banners.php");
}
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM banners WHERE id=$id");
    header("Location: banners.php");
}
$banners = mysqli_query($conn,"SELECT * FROM banners");
?>
<h2>Banners</h2>
<form method="post" enctype="multipart/form-data">
<input type="text" name="title" placeholder="Title" required>
<input type="text" name="link" placeholder="Link" required>
<input type="file" name="image" required>
<button type="submit" name="add" class="btn">Add</button>
</form>

<table>
<tr><th>ID</th><th>Title</th><th>Image</th><th>Link</th><th>Action</th></tr>
<?php while($b=mysqli_fetch_assoc($banners)): ?>
<tr>
<td><?= $b['id'] ?></td>
<td><?= htmlspecialchars($b['title']) ?></td>
<td><img src="../assets/images/<?= $b['image'] ?>" width="100"></td>
<td><?= $b['link'] ?></td>
<td><a href="banners.php?delete=<?= $b['id'] ?>" class="btn">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>

