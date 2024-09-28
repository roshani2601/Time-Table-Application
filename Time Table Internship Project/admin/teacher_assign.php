<?php
require ("../db_connect.php");
require ("header.php");

if (isset($_POST['submit'])) {
    $course_id = mysqli_real_escape_string($conn, $_POST['course']);
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher']);

    $que = mysqli_query($conn, "SELECT * FROM teacher_assign WHERE course_id='$course_id' AND teacher_id='$teacher_id'");
    $row = mysqli_num_rows($que);
    if ($row > 0) {
        $err = "<div class='msg'>This teacher is already assigned to this course!</div>";
    } else {
        $query = "INSERT INTO teacher_assign (teacher_id, course_id) VALUES ('$teacher_id', '$course_id')";
        if (mysqli_query($conn, $query)) {
            header('Location: teacher_assign.php');
            exit();
        } else {
            $err = "<div class='msg'>Failed to assign teacher. Please try again.</div>";
        }
    }
}
// Delete 
if (isset($_POST['delete'])) {
    $assign_id = mysqli_real_escape_string($conn, $_POST['assign_id']);

    $query = "DELETE FROM teacher_assign WHERE assign_id = $assign_id";
    if (mysqli_query($conn, $query)) {
        header('Location: teacher_assign.php');
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher</title>
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- Teacher assign start -->
    <section class="assign-teacher">
        <h3 class="heading"><span class="back"><a href="teachers.php"><i
                        class="fa-solid fa-arrow-left"></i></a></span>Assign Teacher</h3>

        <?php if (!empty($err))
            echo $err; ?>

        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="data">
                    <p>Course Name<span>*</span></p>
                    <select name="course" class="box" required>
                        <option value="">Select an option</option>
                        <?php
                        $sql = "SELECT * FROM courses ORDER BY course_name ASC";
                        $all_courses = mysqli_query($conn, $sql);
                        while ($course = mysqli_fetch_array($all_courses)):
                            ?>
                            <option value="<?php echo $course["course_id"]; ?>">
                                <?php echo ucwords($course["course_name"]); ?>
                            </option>
                            <?php
                        endwhile;
                        ?>
                    </select>
                </div>
                <div class="data">
                    <p>Teacher Name <span>*</span></p>
                    <select name="teacher" class="box" required>
                        <option value="">Select an option</option>
                        <?php
                        $sql = "SELECT * FROM teachers ORDER BY name ASC";
                        $all_teacher = mysqli_query($conn, $sql);
                        while ($teacher = mysqli_fetch_array($all_teacher)):
                            ?>
                            <option value="<?php echo $teacher["teacher_id"]; ?>">
                                <?php echo ucwords($teacher["name"]); ?>
                            </option>
                            <?php
                        endwhile;
                        ?>
                    </select>
                </div>

                <input type="submit" value="Assign" name="submit" class="btn">
            </form>
        </div>

        <div class="box-container">
            <?php
            // course table ->course_id
            $sql = "SELECT * FROM courses ORDER BY course_name ASC";
            $course = mysqli_query($conn, $sql);
            while ($coursename = mysqli_fetch_array($course)):
                ?>
                <div class="box">
                    <h3 class="title"><?php echo $coursename['course_name']; ?></h3>
                    <div class="flex">
                        <?php
                        // course_id->teacher_assign
                        $course_id = $coursename['course_id'];

                        $teacher = "SELECT * FROM teacher_assign WHERE course_id='$course_id'";
                        $assign = mysqli_query($conn, $teacher);
                        if ($assign->num_rows > 0) {
                            while ($assign_name = mysqli_fetch_array($assign)):
                                // teacher_assign->teacher name
                                $teacher_id = $assign_name['teacher_id'];

                                $teacher_name = "SELECT * FROM teachers WHERE teacher_id='$teacher_id' ORDER BY name ASC";
                                $name = mysqli_query($conn, $teacher_name);

                                while ($teachername = mysqli_fetch_array($name)):
                                    ?>
                                    <a href="#"><span><?php echo $teachername['name']; ?></span>
                                        <form method="post" action=""
                                            onsubmit="return confirm('Are you sure to delete this assignment?');">
                                            <input type="hidden" name="assign_id" value="<?php echo $assign_name['assign_id']; ?>">
                                            <button class="close" name="delete">&times;</button>
                                        </form>
                                    </a>
                                    <?php
                                endwhile;

                            endwhile;
                        } else {
                            echo '<p style="font-size: 16px;
                            padding: 1rem;
                            background-color: var(--light-bg); border-radius: .5rem; color: #888;">No teachers assigned yet!</p>';
                        }
                        ?>
                    </div>
                </div>
                <?php
            endwhile;
            ?>
        </div>
    </section>
    <!-- Teacher assign end -->

    <!-- Custom JS file link -->
    <script src="../js/script.js"></script>

</body>

</html>