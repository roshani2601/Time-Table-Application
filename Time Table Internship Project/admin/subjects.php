<?php
require ("../db_connect.php");
require ("header.php");

if (isset($_POST['edit'])) {
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);

    $query = "UPDATE subjects SET subject_name = '$subject_name' WHERE subject_id = '$subject_id'";

    if (mysqli_query($conn, $query)) {
        header('Location: subjects.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if (isset($_POST['delete'])) {
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);

    $query = "DELETE FROM subjects WHERE subject_id = '$subject_id'";

    if (mysqli_query($conn, $query)) {
        header('Location: subjects.php');
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
    <title>Subjects</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <!-- subject start -->
    <section class="subjects">

        <h1 class="heading">Our Subjects</h1>

        <div class="data">
            <a href="subject_add.php"><button class="btn"><i class="fa fa-plus"></i> New </button></a>
           
            <div class="edit" id="editForm" style="display: none;">
                <form method="post">
                    <input type="hidden" name="subject_id" id="subjectId">
                    <p>Subject Name <span>*</span></p>
                    <input type="text" name="subject_name" id="subjectName" class="box" required>
                    <input type="submit" value="Edit" name="edit" class="btn">
                </form>
            </div>


        </div>

        <?php
        $course_id_query = "SELECT * FROM courses ORDER BY course_name ASC";
        $course_result = mysqli_query($conn, $course_id_query);
        while ($course_row = mysqli_fetch_array($course_result)):
            ?>
            <div class="subject-container">
                <h3 class="course-header"><?php echo $course_row['course_name'] ?></h3>
                <div class="box-container">
                    <?php
                    $course_id = $course_row['course_id'];
                    $subject_query = "SELECT * FROM subjects WHERE course_id='$course_id' ORDER BY subject_name ASC";
                    $subject_result = mysqli_query($conn, $subject_query);
                    if ($subject_result->num_rows > 0) {
                        while ($subject_row = mysqli_fetch_array($subject_result)): ?>
                            <div class="box">
                                <div class="tutor">
                                    <div class="info">
                                        <h3><?php echo $subject_row['subject_name']; ?></h3>
                                        <span>Teacher:
                                            <?php
                                            $ta_id = $subject_row['assign_id'];
                                            $ta_query = "SELECT * FROM teacher_assign WHERE assign_id = '$ta_id'";
                                            $ta_result = mysqli_query($conn, $ta_query);
                                            $ta_row = mysqli_fetch_array($ta_result);
                                            $teacher_id = $ta_row['teacher_id'];

                                            $teacher_query = "SELECT * FROM teachers WHERE teacher_id = '$teacher_id'";
                                            $teacher_result = mysqli_query($conn, $teacher_query);
                                            $teacher_row = mysqli_fetch_array($teacher_result);
                                            echo $teacher_row['name'];
                                            ?>
                                        </span>
                                        <span>Semester:
                                            <?php
                                            $sem_id = $subject_row['sem_id'];
                                            $sem_query = "SELECT * FROM semesters WHERE sem_id = '$sem_id'";
                                            $sem_result = mysqli_query($conn, $sem_query);
                                            $sem_row = mysqli_fetch_array($sem_result);
                                            echo $sem_row['sem_name'];
                                            ?>
                                        </span>
                                        
                                    </div>

                                    <div class="button">
                                        <a href="#" class="editBtn" data-id="<?php echo $subject_row['subject_id'] ?>"
                                            data-subject="<?php echo $subject_row['subject_name'] ?>"><i
                                                class="fa-solid fa-pen-to-square" style="color: #1e3b6b; "></i></a>

                                        <form method="post" style="display:inline;"
                                            onsubmit="return confirm('Are you sure to delete this subject?');">
                                            <input type="hidden" name="subject_id"
                                                value="<?php echo $subject_row['subject_id']; ?>">
                                            <button type="submit" name="delete" class="deleteBtn"
                                                style="background:none; border:none; cursor:pointer;">
                                                <i class="fa-solid fa-trash" style="color: #ff0f0f; "></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                    } else {
                        echo '<p class="msg" style="color: var(--light-color);">No subject added yet!</p>';
                    } ?>
                </div>
            </div>
        <?php endwhile; ?>

    </section>
    <!-- subject end -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>
    <script>
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const subjectId = this.getAttribute('data-id');
                const subjectName = this.getAttribute('data-subject');
                document.getElementById('subjectId').value = subjectId;
                document.getElementById('subjectName').value = subjectName;
                document.getElementById('editForm').style.display = 'block';
                window.scrollTo(0, document.getElementById('editForm').offsetTop);
            });
        });
    </script>

</body>

</html> 