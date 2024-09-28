<?php
require ("../db_connect.php");
require ("header.php");

if (isset($_GET['get_id'])) {
    $get_id = mysqli_real_escape_string($conn, $_GET['get_id']);
    $query = "SELECT * FROM admin WHERE id = '$get_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
    } else {
        header('Location: user.php');
        exit();
    }
} else {
    $query = "SELECT * FROM admin WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
}


if (isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    $old_username = $user['username'];
    $old_image = $user['image'];

    $new_image = $old_image;

    if ($old_username != $new_username) {
        $new_image = $new_username . '.jpg';
        rename("upload/" . $old_image, "upload/" . $new_image);
    }

    if (!empty($_FILES['image']['tmp_name'])) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $new_image = $new_username . '.jpg';
        move_uploaded_file($image_tmp, "upload/" . $new_image);
    }

    if (!empty($password)) {
        $query = "UPDATE admin SET username = '$new_username', email = '$email', password = '$password', contact_no = '$contact_no', type = '$type', image = '$new_image' WHERE id = '$id'";
    } else {
        $query = "UPDATE admin SET username = '$new_username', email = '$email', contact_no = '$contact_no', type = '$type', image = '$new_image' WHERE id = '$id'";
    }

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (isset($_GET['get_id'])) {
            header('Location: user.php');
        } else {
            header('Location: view_profile.php');
        }
        exit();
    } else {
        header('Location: user.php?error=Unable to update user');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- useredit start  -->
    <section class="form-container">

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <h3>Edit User<span class="close"><a href="user.php">&times;</a></span></h3>

            <p>Name <span>*</span></p>
            <input type="text" name="username" required maxlength="50" class="box"
                value="<?php echo $user['username']; ?>">

            <p>Email <span>*</span></p>
            <input type="email" name="email" required maxlength="50" class="box" value="<?php echo $user['email']; ?>">

            <p>Password</p>
            <input type="password" name="password" class="box"
                pattern="(?=.*[!@#$%^&])(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}"
                placeholder="Leave blank if you don't want to change the password">

            <p>Contact No. <span>*</span></p>
            <input type="text" name="contact_no" required maxlength="10" class="box" pattern="[0-9]{10}"
                value="<?php echo $user['contact_no']; ?>">

            <p>Type <span>*</span></p>
            <select name="type" class="box" required>
                <option value="">Select an option</option>
                <option value="admin" <?php echo ($user['type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="staff" <?php echo ($user['type'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
            </select>

            <p>Image</p>
            <div class="box">
                <img src="upload/<?php echo $user['image']; ?>?v=<?php echo time(); ?>" class="image" alt="">
                <p>Update image </p>
                <input type="file" name="image" class="box" accept="image/*">
            </div>

            <input type="submit" value="Edit" name="edit" class="btn">
        </form>
    </section>
    <!-- useredit end -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>

</body>

</html>