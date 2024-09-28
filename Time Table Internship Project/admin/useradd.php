<?php
require ("../db_connect.php");


if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    if ($_FILES['image']['error'] == 0) {
        $image = $username . '.jpg';
        $image_tmp = $_FILES['image']['tmp_name'];
    } else {
        $image = 'default.jpg';
    }

    if ($type == "") {
        $error_msg[] = 'Please select a valid type!';
    } else {
        $query = "INSERT INTO admin(username, email, password, contact_no, type, image) VALUES('$username','$email','$password','$contact_no','$type','$image')";
        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            if (!file_exists('upload/')) {
                mkdir('upload/', 0777, true);
            }
            move_uploaded_file($image_tmp, "upload/" . $image);
            header('Location: user.php');
            exit();
        } else {
            header('Location: user.php?error=Unable to add user');
            exit();
        }
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

<!-- header -->
 <?php require ("header.php"); ?>
    <!-- user start -->

    <section class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Add Users<span class="close"><a href="user.php">&times;</a></span></h3>
            <p>Name <span>*</span></p>
            <input type="text" name="username" placeholder="enter your name" required maxlength="50" class="box">
            <p>Email <span>*</span></p>
            <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
            <p>Password <span>*</span></p>
            <input type="password" name="password" placeholder="enter your password" required maxlength="20" class="box"
                pattern="(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}" id="myInput">
            <h4>Ex: Basic@123</h4>
            <p>Contact No. <span>*</span></p>
            <input type="text" name="contact_no" placeholder="enter your contact no." pattern="[0-9]{10}" required
                maxlength=" 10" class="box">
            <p>Type <span>*</span></p>
            <select name="type" class="box" required>
                <option value="">select an option</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
            <p>Image <span>*</span></p>
            <input type="file" name="image" class="box" required>

            <input type="submit" value="Add" name="submit" class="btn">

        </form>
    </section>

    <!-- user end -->


    <!-- custom js file link  -->
    <script src="../js/script.js"></script>


</body>

</html>