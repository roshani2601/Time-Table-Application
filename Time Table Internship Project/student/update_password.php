<?php
require ("../db_connect.php");
require ("header.php");

$err = '';

if (isset($_POST['edit'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $oldpassword = mysqli_real_escape_string($conn, $_POST['oldpassword']);
    $newpassword = mysqli_real_escape_string($conn, $_POST['newpassword']);

    $query = "SELECT * FROM students WHERE student_id = '$student_id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result);

    if ($oldpassword != $user_data['password']) {
        $err = "Old password is incorrect!";
    } else {

        $update_query = "UPDATE students SET password='$newpassword' WHERE student_id = '$student_id'";
        if (mysqli_query($conn, $update_query)) {
            header('Location: view_profile.php');
            exit();
        } else {
            $err = "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>


    <!-- Edit Password Form -->
    <?php if (!empty($err)): ?>
        <div class="msg"><?php echo $err; ?></div>
    <?php endif; ?>

    <section class="addstudent">
        <h3 class="heading"><span class="back"><a href="view_profile.php"><i
                        class="fa-solid fa-arrow-left"></i></a></span> Update Password</h3>
        <section class="form-container">

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="student_id" value="<?php echo $user_data['student_id']; ?>">

                <!-- <h3>Update Password <span class="close"><a href="view_profile.php">&times;</a></span></h3> -->

                <p>Old Password <span>*</span></p>
                <input type="password" name="oldpassword" placeholder="Enter old password" required maxlength="20"
                    class="box">

                <p>New Password <span>*</span></p>
                <input type="password" name="newpassword" placeholder="Enter new password"
                    pattern="(?=.*[!@#$%^&])(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}" required maxlength="20" class="box">
                <h4>Ex: Basic@123</h4>

                <input type="submit" value="Edit" name="edit" class="btn">
            </form>
        </section>
    </section>

    <!-- Custom JavaScript file link -->
    <script src="../js/script.js"></script>
</body>

</html>