<?php
require ("../db_connect.php");
require ("header.php");

// Delete 
if (isset($_POST['delete'])) {
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);

    $query = "SELECT name FROM teachers WHERE teacher_id = $teacher_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $imageFile = $row['name'] . ".jpg";

        $filePath = "upload/teachers/" . $imageFile;

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                $query = "DELETE FROM teachers WHERE teacher_id = $teacher_id";
                if (mysqli_query($conn, $query)) {
                    header('Location: teachers.php');
                    exit();
                } else {
                    echo "Error deleting record: " . mysqli_error($conn);
                }
            } else {
                echo "Error deleting file: Unable to delete the image file.";
            }
        } else {
            echo "File does not exist: $filePath";
        }
    } else {
        echo "No record found with ID: $teacher_id";
    }
}

// Handle search
$search = "";
$teacher_result = [];
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM teachers WHERE name LIKE '%$search%' ORDER BY name ASC";
} else {
    $sql = "SELECT * FROM teachers ORDER BY name ASC";
}

$teacher_result = $conn->query($sql);

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

    <!-- teacher page start -->
    <section class="teachers">

        <h1 class="heading">teachers</h1>

        <div class="head">
            <form action="" method="get" class="search-tutor">
                <input type="text" name="search" placeholder="search teacher..." maxlength="100"
                    value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="fas fa-search"></button>
            </form>
            <a href="teacher_assign.php"><button class="btn"><i class="fa fa-plus"></i> Assign </button></a>
            <a href="teacher_add.php"><button class="btn"><i class="fa fa-plus"></i> New </button></a>
        </div>

        <div class="box-container">

            <?php
            if ($teacher_result->num_rows > 0) {
                while ($t = $teacher_result->fetch_assoc()): ?>
                    <div class="box">
                        <form method="post" action="" onsubmit="return confirm('Are you sure to delete this semester?');">
                            <input type="hidden" name="teacher_id" value="<?php echo $t['teacher_id']; ?>">
                            <button class="close" name="delete">&times;</button>
                        </form>
                        <div class="tutor">
                            <img src="upload/teachers/<?= $t['image']; ?>?v=<?php echo time(); ?>" alt="">
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
                        <a href="teacher_profile.php?teacher=<?php echo htmlspecialchars($t['name']); ?>"
                            class="inline-btn">view
                            profile</a>

                    </div>
                    <?php
                endwhile;
            } else {
                echo '<p style="font-size: 20px; padding: 2rem; background-color: #e5e5e5;
                            margin-top: 1rem; border-radius: 4px;">No Teacher added yet!</p>';
            } ?>
        </div>

    </section>
    <!-- teacher page end -->


    <!-- custom js file link  -->
    <script src="../js/script.js"></script>

</body>

</html>