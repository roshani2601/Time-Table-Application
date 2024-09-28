<?php
require ("../db_connect.php");
session_start();
?>

<?php

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE email ='$email' AND password = '$password'");
    $row = mysqli_fetch_array($result);
    $numberOfRows = mysqli_num_rows($result);

    if ($numberOfRows > 0) {
        $_SESSION['user_id'] = $row['id'];
        header("location:index.php");
    } else {
        echo "<script>";
        echo "alert('Invalid Details!');";
        echo "</script>";
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
    <style>
        .form-container {
            display: block;
        }

        form {
            margin-left: 21rem;
            margin-top: 15rem;
        }
    </style>
</head>

<body>


    <!-- Login start-->

    <section class="form-container">

        <form action="" method="post" enctype="multipart/form-data">
            <h3>login now</h3>
            <p>your email <span>*</span></p>
            <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
            <p>your password <span>*</span></p>
            <input type="password" name="password" placeholder="enter your password" required maxlength="20"
                class="box">

            <input type="submit" value="login" name="login" class="btn">
        </form>

    </section>
    <!-- login end -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>

</body>

</html>