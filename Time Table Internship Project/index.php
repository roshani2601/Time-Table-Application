<?php
require ("db_connect.php");
session_start();

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result1 = mysqli_query($conn, "SELECT * FROM teachers WHERE email ='$email' AND password = '$password'");
    $row1 = mysqli_fetch_array($result1);
    $numberOfRows1 = mysqli_num_rows($result1);

    $result2 = mysqli_query($conn, "SELECT * FROM students WHERE student_email ='$email' AND password = '$password'");
    $row2 = mysqli_fetch_array($result2);
    $numberOfRows2 = mysqli_num_rows($result2);

    if ($numberOfRows1 > 0) {
        $_SESSION['t_id'] = $row1['teacher_id'];
        header("location:teacher/index.php");

    } else if ($numberOfRows2 > 0) {
        $_SESSION['s_id'] = $row2['student_id'];
        header("location:student/index.php");
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
    <title>TimeTable</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- Header start -->
    <header class="header">

        <section class="flex">

            <a href="#home" class="logo">TimeTable</a>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <div id="search-btn" class="fas fa-search"></div>
                <div id="user-btn" class="fas fa-user"></div>
                <div id="toggle-btn" class="fas fa-sun"></div>
            </div>

            <div class="profile">
                <img src="images/pic-1.jpg" class="image" alt="">

                <a href="#login" class="btn">Login</a>

            </div>

        </section>

    </header>

    <div class="side-bar">

        <div id="close-btn">
            <i class="fas fa-times"></i>
        </div>

        <div class="profile">
            <img src="images/pic-1.jpg" class="image" alt="">

            <a href="#login" class="btn">Login</a>
        </div>

        <nav class="navbar">
            <a href="#home"><i class="fas fa-home"></i><span>Home</span></a>
            <a href="#about"><i class="fas fa-question"></i><span>About</span></a>
            <a href="#courses"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
            <a href="#teachers"><i class="fas fa-chalkboard-user"></i><span>Teachers</span></a>

        </nav>

    </div>
    <!-- header end -->

    <!-- home start -->

    <section class="index" id="home">

        <h3 class="heading">Home</h3>
        <div class="row">
            <p>Welcome to our Timetable Application! </p>
            <img src="images/home.svg" alt="">
        </div>

    </section>

    <!-- home end-->


    <!-- about start -->
    <section class="about" id="about">

        <h3 class="heading">About</h3>
        <div class="row">

            <div class="image">
                <img src="images/about-img.svg" alt="">
            </div>

            <div class="content">
                <h3>Why choose us?</h3>
                <p>"A timetable application allows admins to manage class schedules. Students and faculty can view their
                    personalized timetables for easy organization."</p>
                <a href="#courses" class="inline-btn">our courses</a>
            </div>

        </div>

        <div class="box-container">

            <?php
            $i = 0;
            $course = mysqli_query($conn, "SELECT * FROM courses");
            while (mysqli_fetch_array($course)):
                $i++;
            endwhile;
            ?>

            <div class="box">
                <i class="fas fa-graduation-cap"></i>
                <div>
                    <h3><?php echo $i; ?></h3>
                    <p>Courses</p>
                </div>
            </div>

            <?php
            $t = 0;
            $teacher = mysqli_query($conn, "SELECT * FROM teachers");
            while (mysqli_fetch_array($teacher)):
                $t++;
            endwhile;
            ?>

            <div class="box">
                <i class="fas fa-chalkboard-user"></i>
                <div>
                    <h3><?php echo $t; ?></h3>
                    <p>Expert teachers</p>
                </div>
            </div>

            <?php
            $s = 0;
            $student = mysqli_query($conn, "SELECT * FROM students");
            while (mysqli_fetch_array($student)):
                $s++;
            endwhile;
            ?>

            <div class="box">
                <i class="fas fa-user-graduate"></i>
                <div>
                    <h3><?php echo $s; ?></h3>
                    <p>Students</p>
                </div>
            </div>


        </div>

    </section>

    <!-- about end -->


    <!-- courses start -->

    <section class="subjects" id="courses">

        <h1 class="heading">Courses</h1>
        <div class="box-container" style="grid-template-columns: repeat(auto-fit, minmax(57rem, 1fr));">

            <?php
            $sql = "SELECT * FROM courses ORDER BY course_name ASC LIMIT 6";

            $course_result = $conn->query($sql);
            if ($course_result->num_rows > 0) {
                while ($row = mysqli_fetch_array($course_result)) {

                    ?>

                    <div class="box">
                        <div class="tutor">
                            <div class="info">
                                <h3><?php echo $row['course_name']; ?></h3>
                                <span><?php echo $row['description']; ?></span>
                            </div>
                        </div>


                        <div class="thumb">

                        </div>
                        <!-- <h3 class="title">complete SASS tutorial</h3> -->

                    </div>
                    <?php
                }
            } else {
                echo '<p style="font-size: 20px; padding: 2rem; background-color: #e5e5e5;
                            margin-top: 1rem; border-radius: 4px;">No course added yet!</p>';
            } ?>

        </div>
    </section>
    <!-- courses end -->


    <!-- teachers start -->
    <section id="teachers" class="teachers">

        <h3 class="heading">Teachers</h3>

        <div class="box-container">

            <?php
            $sql = "SELECT * FROM teachers LIMIT 6";
            $teacher_result = $conn->query($sql);
            if ($teacher_result->num_rows > 0) {
                while ($t = $teacher_result->fetch_assoc()): ?>
                    <div class="box">
                        <div class="tutor">
                            <img src="admin/upload/teachers/<?= $t['image']; ?>" alt="">
                            <div>
                                <h3><?php echo $t['name']; ?></h3>
                                <span><?php echo $t['email']; ?></span>
                            </div>
                        </div>
                        <?php
                        $assign_id = $t['teacher_id'];
                        $assign1 = "SELECT * FROM teacher_assign where teacher_id='$assign_id'";
                        $assign2 = mysqli_query($conn, $assign1);
                        ?>
                        <p>Course :<span>
                                <?php
                                $i = 1;
                                if ($assign2->num_rows > 0) {
                                    while ($assign = mysqli_fetch_array($assign2)):

                                        $course_id = $assign['course_id'];
                                        $course1 = "SELECT * FROM courses where course_id='$course_id' ORDER BY course_name ASC";
                                        $course2 = mysqli_query($conn, $course1);

                                        while ($course_name = mysqli_fetch_array($course2)):
                                            echo "$i." . $course_name['course_name'] . " ";
                                        endwhile;
                                        $i++;
                                    endwhile;

                                } else {
                                    echo 'None';
                                } ?>
                            </span>
                        </p>
                        <p>Subjects : <span>
                                <?php
                                $teacher_id = $t['teacher_id'];
                                $query_assignments = "SELECT * FROM teacher_assign WHERE teacher_id='$teacher_id'";
                                $result_assignments = mysqli_query($conn, $query_assignments);
                                $i = 0;
                                while ($assignment = mysqli_fetch_assoc($result_assignments)) {
                                    $assign = $assignment['assign_id'];

                                    $query_subjects = "SELECT * FROM subjects WHERE assign_id='$assign'";
                                    $result_subjects = mysqli_query($conn, $query_subjects);


                                    while ($subject = mysqli_fetch_assoc($result_subjects)) {
                                        // echo $subject['subject_name'];
                                        $i++;
                                    }
                                }
                                echo $i;
                                ?>

                            </span></p>

                    </div>
                    <?php
                endwhile;
            } else {
                echo '<p style="font-size: 20px; padding: 2rem; background-color: #e5e5e5;
                margin-top: 1rem; border-radius: 4px;">No Teacher added yet!</p>';
            } ?>
        </div>
    </section>
    <!-- teachers end-->

    <!-- login start -->
    <section id="login">
        <h3 class="heading">Login</h3>
        <div class="form-container" style="min-height: calc(100vh - 38rem);">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Login </h3>
                <p>your email <span>*</span></p>
                <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
                <p>your password <span>*</span></p>
                <input type="password" name="password" placeholder="enter your password" required maxlength="20"
                    class="box">

                <input type="submit" value="Login" name="login" class="btn">
            </form>
        </div>
    </section>

    <!-- footer start -->
    <footer class="footer">

        &copy; copyright @ 2024 by <span>Miss Roshani Borsadiya & Miss Ashruti Pagral</span> | all rights reserved!

    </footer>
    <!-- footer end -->

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>