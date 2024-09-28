<?php
require ("../db_connect.php");
require ("header.php");
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

    <section class="timetable">

        <h1 class="heading">quick options</h1>

        <div class="box-container">

            <div class="box">
                <h3 class="title">Totals</h3>

                <?php
                $i = 0;
                $course = mysqli_query($conn, "SELECT * FROM courses");
                while (mysqli_fetch_array($course)):
                    $i++;
                endwhile;
                ?>

                <p class="likes">Total Courses : <span><?php echo $i; ?></span></p>
                <a href="courses.php" class="inline-btn">view Courses</a>

                <?php
                $t = 0;
                $teacher = mysqli_query($conn, "SELECT * FROM teachers");
                while (mysqli_fetch_array($teacher)):
                    $t++;
                endwhile;
                ?>

                <p class="likes">Total Teachers : <span><?php echo $t; ?></span></p>
                <a href="teachers.php" class="inline-btn">view Teachers</a>

                <?php
                $s = 0;
                $student = mysqli_query($conn, "SELECT * FROM students");
                while (mysqli_fetch_array($student)):
                    $s++;
                endwhile;
                ?>

                <p class="likes">Total Students : <span><?php echo $s; ?></span></p>
                <a href="students.php" class="inline-btn">view Students</a>
            </div>

            <div class="box">
                <h3 class="title">Generate Timetable</h3>
                <p class="likes">Teacher </p>
                <a href="timetable.php" class="inline-btn"><i class="fa-solid fa-user-tie"></i><span>
                        Generate</span></a>

                <p class="likes">Student </p>
                <a href="timetable.php" class="inline-btn"><i class="fa-solid fa-people-line"></i><span>
                        Generate</span></a>


            </div>
    </section>

    <!-- home/index page  -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>

</body>

</html>