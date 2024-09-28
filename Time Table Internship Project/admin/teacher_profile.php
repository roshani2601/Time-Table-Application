<?php
require ("../db_connect.php");
require ("header.php");

if (isset($_GET['teacher'])) {
    $teacher_name = mysqli_real_escape_string($conn, $_GET['teacher']);
    $query = "SELECT * FROM teachers WHERE name = '$teacher_name'";
    $result = mysqli_query($conn, $query);
    $teacher = mysqli_fetch_assoc($result);
    $teacher_id = $teacher['teacher_id'];
} else {
    echo "No teacher selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- teacher profile start -->
    <section class="teacher-profile">
        <h1 class="heading">
            <span class="back">
                <a href="teachers.php"><i class="fa-solid fa-arrow-left"></i></a>
            </span>
            Profile Details
        </h1>
        <div class="details">
            <div class="tutor">
                <img src="upload/teachers/<?= htmlspecialchars($teacher['image']); ?>?v=<?php echo time(); ?>" alt="">
                <h3><?= htmlspecialchars($teacher['name']); ?></h3>
                <a href="teacher_edit.php?get_id=<?php echo $teacher['teacher_id']; ?>" class="inline-btn">Update
                    Profile</a>
            </div>
            <div class="flex">
                <p>Email : <span><?= htmlspecialchars($teacher['email']); ?></span></p>
                <p>Password : <span><?= htmlspecialchars($teacher['password']); ?></span></p>
                <p>Contact : <span><?= htmlspecialchars($teacher['contact_no']); ?></span></p>
                <p>Gender : <span><?= htmlspecialchars($teacher['gender']); ?></span></p>
                <p>Address : <span><?= htmlspecialchars($teacher['address']); ?></span></p>
            </div>
        </div>
    </section>
    <!-- teacher profile end -->

    <!-- subjects start -->
    <section class="t-subjects">
        <h1 class="heading">Subjects</h1>
        <div class="box-container">
            <?php
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

    <!-- custom js file link -->
    <script src="../js/script.js"></script>

</body>

</html>