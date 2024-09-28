<?php
require ("../db_connect.php");
require ("header.php");
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
    <!-- subjects start -->
    <section class="t-subjects">
        <h1 class="heading">Subjects</h1>
        <div class="box-container">
            <?php
            $teacher_id = $user_data['teacher_id'];
            $query_assignments = "SELECT * FROM teacher_assign WHERE teacher_id='$teacher_id'";
            $result_assignments = mysqli_query($conn, $query_assignments);

            while ($assignment = mysqli_fetch_assoc($result_assignments)) {
                $assign = $assignment['assign_id'];
                $course_id = $assignment['course_id'];

                $query_subjects = "SELECT * FROM subjects WHERE assign_id='$assign'";
                $result_subjects = mysqli_query($conn, $query_subjects);

                $query_course = "SELECT * FROM courses WHERE course_id='$course_id'";
                $result_course = mysqli_query($conn, $query_course);
                $course = mysqli_fetch_assoc($result_course);


                while ($subject = mysqli_fetch_assoc($result_subjects)) {
                    $sem_id = $subject['sem_id'];
                    $query_semester = "SELECT * FROM semesters WHERE sem_id='$sem_id'";
                    $result_semester = mysqli_query($conn, $query_semester);
                    $semester = mysqli_fetch_assoc($result_semester);
                    ?>
                    <div class="box">
                        <h3 class="title"><?= htmlspecialchars($subject['subject_name']); ?></h3>
                        <p>Course: <span><?= htmlspecialchars($course['course_name']); ?></span></p>
                        <p>Semester: <span><?= htmlspecialchars($semester['sem_name']); ?></span></p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <!-- subjects end -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>
</body>

</html>