<?php
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id");
$user = mysqli_fetch_assoc($result);

$errors = [];
$success = "";

if(isset($_POST['update_profile'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Handle profile image
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != ""){
        $img_name = time().'_'.basename($_FILES['profile_image']['name']);
        $target_dir = "../assets/images/profiles/";
        if(!is_dir($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        $target = $target_dir . $img_name;

        if(!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)){
            $errors[] = "Failed to upload profile image.";
        } else {
            if(!empty($user['profile_image']) && file_exists($target_dir.$user['profile_image'])){
                unlink($target_dir.$user['profile_image']);
            }
        }
    } else {
        $img_name = isset($user['profile_image']) ? $user['profile_image'] : 'default.png';
    }

    if(empty($errors)){
        $update = mysqli_query($conn, "
            UPDATE users SET 
                username='$username',
                name='$name',
                email='$email',
                profile_image='$img_name'
            WHERE id=$user_id
        ");
        if($update){
            $_SESSION['user_name'] = $username; // Update session username
            $success = "Profile updated successfully!";
            $user['username'] = $username;
            $user['name'] = $name;
            $user['email'] = $email;
            $user['profile_image'] = $img_name;
        } else {
            $errors[] = "Failed to update profile.";
        }
    }
}
?>

<section class="profile-section">
    <div class="container">
        <h2>Edit Profile</h2>

        <?php if($errors): ?>
            <div class="alert alert-error">
                <?php foreach($errors as $err) echo "<p>$err</p>"; ?>
            </div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success">
                <p><?= $success ?></p>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="profile-form">
            <div class="form-left">
                <label>Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>

                <label>Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>

                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

                <label>Profile Image</label>
                <input type="file" name="profile_image">
            </div>

            <div class="form-right">
                <h3>Current Profile</h3>
                <?php
                $profile_img = !empty($user['profile_image']) && file_exists("../assets/images/profiles/".$user['profile_image']) ? $user['profile_image'] : 'default.png';
                ?>
                <img src="../assets/images/profiles/<?= $profile_img ?>" alt="Profile" class="profile-img">
                <button type="submit" name="update_profile" class="btn">Update Profile</button>
            </div>
        </form>
    </div>
</section>

<style>
.profile-section{max-width:900px;margin:40px auto;padding:0 20px;}
.profile-section h2{text-align:center;margin-bottom:20px;}
.profile-form{display:flex; gap:40px; flex-wrap:wrap;}
.form-left, .form-right{flex:1; min-width:300px; background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1);}
.form-left label{display:block;margin-top:10px;}
.form-left input, .form-left textarea, .form-left select{width:100%;padding:8px;margin-top:5px;border-radius:5px;border:1px solid #ccc;}
.form-right{text-align:center;}
.profile-img{max-width:200px;border-radius:50%;margin-bottom:15px;}
.btn{background:#007bff;color:#fff;padding:10px 20px;border:none;border-radius:6px;margin-top:20px;cursor:pointer;}
.btn:hover{background:#0056b3;}
.alert{padding:10px; border-radius:5px; margin-bottom:15px;}
.alert-success{background:#28a745;color:#fff;}
.alert-error{background:#dc3545;color:#fff;}
@media(max-width:768px){.profile-form{flex-direction:column;}.form-left, .form-right{min-width:100%;}}
</style>
