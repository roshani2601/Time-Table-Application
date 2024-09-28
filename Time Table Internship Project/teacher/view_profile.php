<?php
require ("../db_connect.php");
require ("header.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <!-- view profile start -->
    <section class="user-profile">

        <h1 class="heading">your profile</h1>

        <div class="info">

            <div class="user">
                <img src="../admin/upload/teachers/<?= $user_data['image']; ?>" alt="">
                <h3><?php echo ucwords($user_data['name']); ?></h3>
                <p>Teacher</p>
                <a href="update_password.php" class="inline-btn">Change Password</a>
            </div>

            <div class="box-container" style="gap: 4.5rem;">

                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Email</span>
                            <p><?php echo $user_data['email']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Contact</span>
                            <p><?php echo $user_data['contact_no']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Gender</span>
                            <p><?php echo $user_data['gender']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Address</span>
                            <p><?php echo $user_data['address']; ?></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- view profile end -->

    

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>

</body>

</html>