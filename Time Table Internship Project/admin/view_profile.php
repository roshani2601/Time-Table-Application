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
                <?php
                $query = "SELECT * FROM admin WHERE id = '$user_id' LIMIT 1";
                $result = mysqli_query($conn, $query);
                $user = mysqli_fetch_assoc($result);
                ?>
                <img src="upload/<?= $user['image']; ?>?v=<?php echo time(); ?>" alt="">
                <h3><?php echo ucwords($user['username']); ?></h3>
                <p><?php echo ucwords($user['type']); ?></p>
                <a href="useredit.php?id=<?php echo $user['id']; ?>" class="inline-btn">Update Profile</a>
            </div>

            <div class="box-container">

                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Email</span>
                            <p><?php echo $user['email']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Contact</span>
                            <p><?php echo $user['contact_no']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Password</span>
                            <p><?php echo $user['password']; ?></p>
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