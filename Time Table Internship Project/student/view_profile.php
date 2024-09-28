<?php
require ("../db_connect.php");
require ("header.php");

// $query = "SELECT * FROM students WHERE student_id = '$user_id' LIMIT 1";
// $result = mysqli_query($conn, $query);
// $user = mysqli_fetch_assoc($result);


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
                <img src="../admin/upload/student/<?= $user_data['image']; ?>?v=<?php echo time(); ?>" class="image" alt="">
                <h3><?php echo ucwords($user_data['student_name']); ?></h3>
                <p>Student</p>
                <a href="update_password.php" class="inline-btn">Change Password</a>
            </div>

            <div class="box-container">

                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Email</span>
                            <p><?php echo $user_data['student_email']; ?></p>
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
                            <span>BOD</span>
                            <p><?php echo $user_data['bod']; ?></p>
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
                <?php
                $course_id = $user_data['course_id'];
                $semester_id = $user_data['sem_id'];

                $course1 = mysqli_query($conn, "SELECT * FROM courses WHERE course_id='$course_id'");
                $course2 = mysqli_fetch_array($course1);

                $sem1 = mysqli_query($conn, "SELECT * FROM semesters WHERE sem_id='$semester_id'");
                $sem2 = mysqli_fetch_array($sem1);
                ?>
                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Course</span>
                            <p><?php echo $course2['course_name']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="flex">
                        <div>
                            <span>Sem</span>
                            <p><?php echo $sem2['sem_name']; ?></p>
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