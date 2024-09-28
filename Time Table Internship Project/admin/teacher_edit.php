<?php
require ("../db_connect.php");
require ("header.php");

if (isset($_GET['get_id'])) {
    $teacher_id = mysqli_real_escape_string($conn, $_GET['get_id']);
    $query = "SELECT * FROM teachers WHERE teacher_id = '$teacher_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
    } else {
        header('Location: teacher_profile.php');
        exit();
    }
}

if (isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $new_name = mysqli_real_escape_string($conn, $_POST['tname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $old_name = $user['name'];
    $old_image = $user['image'];

    $new_image = $old_image;

    if ($old_name != $new_name) {
        $new_image = $new_name . '.jpg';
        rename("upload/teachers/" . $old_image, "upload/teachers/" . $new_image);
    }

    if (!empty($_FILES['image']['tmp_name'])) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $new_image = $new_name. '.jpg';
        move_uploaded_file($image_tmp, "upload/teachers/" . $new_image);
    }

    $query = "UPDATE teachers SET name = '$new_name', email = '$email',password = '$password', contact_no = '$contact_no', gender = '$gender',address = '$address', image='$new_image'  WHERE teacher_id = '$id'";

    if (mysqli_query($conn, $query)) {
        header('Location: teachers.php');

    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <!-- add tearcher start -->

    <div class="addteacher">
        <section class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="teacher_id" value="<?php echo $user['teacher_id']; ?>">
                <h3>Update Profile<span class="close"><a href="teachers.php">&times;</a></span></h3>
                <p>Name <span>*</span></p>
                <input type="text" name="tname" value="<?php echo $user['name'] ?>" required maxlength="50" class="box" >

                <p>Email <span>*</span></p>
                <input type="email" name="email" value="<?php echo $user['email'] ?>" required maxlength="50"
                    class="box">

                <p>Password <span>*</span></p>
                <input type="text" name="password" value="<?php echo $user['password'] ?>" required maxlength="20"
                    class="box" id="myInput">
                <h4>Ex: Basic@123</h4>

                <p>Contact No. <span>*</span></p>
                <input type="text" name="contact_no" value="<?php echo $user['contact_no'] ?>" required maxlength="10"
                    class="box" pattern="[0-9]{10}">

                <p>Gender <span>*</span></p>
                <select name="gender" class="box" required>
                    <option value="">select an option</option>
                    <option value="male" <?php echo ($user['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($user['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                </select>

                <p>Address <span>*</span></p>
                <textarea cols="30" rows='3' name="address" id="description" class="box"
                    required><?php echo $user['address']; ?></textarea></textarea>

                <p>Image <span>*</span></p>
                <div class="box">
                    <img src="upload/teachers/<?php echo $user['image']; ?>?v=<?php echo time(); ?>" class="image" alt="">
                    <p>Update image </p>
                    <input type="file" name="image" class="box">
                </div>

                <input type="submit" value="Edit" name="edit" class="btn">
            </form>
        </section>
    </div>
    <!-- add tearcher end -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>

</body>

</html>