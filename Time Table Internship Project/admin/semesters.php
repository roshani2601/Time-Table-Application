<?php
require ("../db_connect.php");
require ("header.php");

if (isset($_POST['submit'])) {

    $sem_name = mysqli_real_escape_string($conn, $_POST['sem_name']);
    $course_id = mysqli_real_escape_string($conn, $_POST['Category']);

    $que = mysqli_query($conn, "SELECT * FROM semesters WHERE sem_name='$sem_name' AND course_id='$course_id'");
    $row = mysqli_num_rows($que);
    if ($row > 0) {
        $err = "<div class='msg'>The semester already exists for this course!</div>";
    } else {
        if ($sem_name == "") {
            echo " ";
        } else {
            $query = "INSERT INTO semesters(sem_name, course_id) VALUES('$sem_name', '$course_id')";
            $query_run = mysqli_query($conn, $query);
            if ($query_run) {
                header('Location: semesters.php');
                exit();
            } else {
                $err = "<div class='msg'>Failed to add the semester. Please try again.</div>";
            }
        }
    }
}


// delete 
if (isset($_POST['delete'])) {
    $sem_id = mysqli_real_escape_string($conn, $_POST['sem_id']);

    $query = "DELETE FROM semesters WHERE sem_id = $sem_id";
    if (mysqli_query($conn, $query)) {
        header('Location: semesters.php');
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
    <title>Semester</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- semester start -->
    <section class="semester">
        <h1 class="heading">Our Semesters</h1>


        <!-- semester form -->
        <?php if (isset($err))
            echo $err; ?>

        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="data">
                    <p>Select Course <span>*</span></p>
                    <select name="Category" class="box">
                        <option value="0">select an option</option>
                        <?php
                        $sql = "SELECT * FROM courses ORDER BY course_name ASC";
                        $all_courses = mysqli_query($conn, $sql);
                        while ($course = mysqli_fetch_array($all_courses)):
                            ?>
                            <option value="<?php echo $course["course_id"]; ?>">
                                <?php echo $course["course_name"]; ?>
                            </option>
                            <?php
                        endwhile;
                        ?>
                    </select>
                </div>
                <div class="data">
                    <p>Semester Name <span>*</span></p>
                    <input type="text" name="sem_name" placeholder="enter semester" required maxlength="50" class="box">
                </div>
                <input type="submit" id="submitButton" value="Add" name="submit" class="btn">
            </form>
        </div>


        <!-- All semster -->
        <div class="box-container">
            <?php
            $course = $conn->query("SELECT * FROM courses ORDER BY course_name ASC");

            while ($row = $course->fetch_assoc()) { ?>
                <div class="box">

                    <h3 class="title"><?php echo $row['course_name']; ?></h3>
                    <div class="flex">

                        <?php
                        $course_id = $row['course_id'];
                        $sem = $conn->query("SELECT * FROM semesters WHERE course_id='$course_id' ORDER BY sem_name ASC");

                        if ($sem->num_rows > 0) {
                            while ($inner_row = $sem->fetch_assoc()) { ?>
                                <a href="#"><span>Semester : <?php echo $inner_row['sem_name']; ?></span>
                                    <form method="post" action=""
                                        onsubmit="return confirm('Are you sure to delete this semester?');">
                                        <input type="hidden" name="sem_id" value="<?php echo $inner_row['sem_id']; ?>">
                                        <button class="close" name="delete">&times;</button>
                                    </form>

                                </a>

                                <?php
                            }
                        } else {
                            ?>
                            <div class="msg"
                                style="background-color: var(--light-bg); color: var(--light-color); font-size: 1.5rem;">
                                No semesters added yet!
                            </div>
                        <?php } ?>
                    </div>

                </div>
                <?php
            } ?>


        </div>



    </section>
    <!-- semester end -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>

</body>

</html>