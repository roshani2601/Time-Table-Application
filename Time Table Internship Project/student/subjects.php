<?php
require ("../db_connect.php");
require ("header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .t-subjects h3 {
            font-size: 2rem;
            margin-bottom: 2rem;
            color: var(--black);
        }
    </style>
</head>

<body>
    <!-- subjects start -->
    <section class="t-subjects">
        <h1 class="heading">Subjects</h1>

        <?php
        $course_id = $user_data['course_id'];
        $semester_id = $user_data['sem_id'];

        $course1 = mysqli_query($conn, "SELECT * FROM courses WHERE course_id='$course_id'");
        $course2 = mysqli_fetch_array($course1);

        $sem1 = mysqli_query($conn, "SELECT * FROM semesters WHERE sem_id='$semester_id'");
        $sem2 = mysqli_fetch_array($sem1);

        ?>
        <h3>Course : <?php echo $course2['course_name']; ?> </h3>
        <h3>Semester : <?php echo $sem2['sem_name']; ?> </h3>

        <div class="box-container">

            <?php
            $query = mysqli_query($conn, "SELECT * FROM subjects WHERE course_id='$course_id' AND sem_id='$semester_id'");


            while ($subject = mysqli_fetch_assoc($query)) {

                $assign_id = $subject['assign_id'];
                $assign = mysqli_query($conn, "SELECT * FROM teacher_assign WHERE assign_id='$assign_id'");
                $a = mysqli_fetch_array($assign);

                $teacher_id = $a['teacher_id'];
                $teacher = mysqli_query($conn, "SELECT * FROM teachers WHERE teacher_id='$teacher_id'");
                $t = mysqli_fetch_array($teacher);

                ?>
                <div class="box">
                    <h3 class="title"><?= htmlspecialchars($subject['subject_name']); ?></h3>
                    <p>Teacher : <span><?= htmlspecialchars($t['name']); ?></span></p>
                </div>
                <?php
            }

            ?>
        </div>
    </section>
    <!-- subjects end -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>
</body>

</html>