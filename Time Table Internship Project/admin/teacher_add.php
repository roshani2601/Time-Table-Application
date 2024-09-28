<?php

require ("../db_connect.php");
require ("header.php");

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    if ($_FILES['image']['error'] == 0) {
        $image = $name . '.jpg' ;
        $image_tmp = $_FILES['image']['tmp_name'];
    } else {
        $image = 'default.jpg';
    }


    $query = "INSERT INTO teachers(name, email, password, contact_no, gender,address, image) VALUES('$name','$email','$password','$contact_no','$gender','$address','$image')";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        if (!file_exists('upload/teachers/')) {
            mkdir('upload/teachers/', 0777, true);
        }
        move_uploaded_file($image_tmp, "upload/teachers/" . $image);
        header('Location: teachers.php');
        exit();
    } else {
        header('Location: teachers.php?error=Unable to add user');
        exit();

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher</title>
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
                <h3>Add Teacher<span class="close"><a href="teachers.php">&times;</a></span></h3>
                <p>Name <span>*</span></p>
                <input type="text" name="name" placeholder="enter your name" required maxlength="50" class="box" >
                <p>Email <span>*</span></p>
                <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
                <p>Password <span>*</span></p>
                <input type="password" name="password" placeholder="enter your password" required maxlength="20"
                    class="box" pattern="(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}" id="myInput">
                <h4>Ex: Basic@123</h4>
                <p>Contact No. <span>*</span></p>
                <input type="text" name="contact_no" placeholder="enter your contact no." required maxlength="10"
                    class="box" pattern="[0-9]{10}">
                <p>Gender <span>*</span></p>
                <select name="gender" class="box" required>
                    <option value="">select an option</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <p>Address <span>*</span></p>
                <textarea cols="30" rows='3' name="address" id="description" placeholder="write..." class="box"
                    required></textarea>
                <p>Image <span>*</span></p>
                <input type="file" name="image" class="box">

                <input type="submit" value="Add" name="submit" class="btn">

            </form>
        </section>
    </div>
    <!-- add tearcher end -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>

</body>

</html>