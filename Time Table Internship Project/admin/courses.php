<?php
require ("../db_connect.php");
require ("header.php");

// Submit-edit button
if (isset($_POST['submit'])) {
    $course_name = mysqli_real_escape_string($conn, $_POST['course']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $course_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($course_name == "") {
        echo " ";
    } else {
        if ($course_id > 0) {
            // Update existing course
            $query = "UPDATE courses SET course_name='$course_name', description='$description' WHERE course_id=$course_id";
        } else {
            // Insert new course
            $query = "INSERT INTO courses(course_name, description) VALUES('$course_name', '$description')";
        }

        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            header('Location: courses.php');
            exit();
        } else {
            echo "Unable to save course.";
        }
    }
}

if (isset($_POST['delete'])) {
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);

    $query = "DELETE FROM courses WHERE course_id = $course_id";
    if (mysqli_query($conn, $query)) {
        header('Location: courses.php');
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Handle search
$search = "";
$course_result = [];
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM courses WHERE course_name LIKE '%$search%' OR description LIKE '%$search%' ORDER BY course_name ASC";
} else {
    $sql = "SELECT * FROM courses ORDER BY course_name ASC";
}

$course_result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- courses start -->
    <section>
        <h1 class="heading">our courses</h1>

        <div class="courses">

            <div class="form-container">
                <form id="courseForm" action="" method="post" enctype="multipart/form-data">
                    <h3>Course Form</h3>
                    <hr>
                    <p>Course <span>*</span></p>
                    <input type="text" name="course" id="course" placeholder="enter your course" maxlength="50"
                        class="box">
                    <p>Description <span>*</span></p>
                    <textarea cols="30" rows='3' name="description" id="description" placeholder="write..."
                        class="box"></textarea>
                    <input type="hidden" name="id" id="courseId" value="">
                    <div class="btn-group">
                        <input type="submit" id="submitButton" value="Save" name="submit" class="btn">
                        <input type="button" value="Cancel" onclick="_reset()" class="btn">
                    </div>
                </form>
            </div>
            <div class="list">
                <h3>Course List</h3>
                <form method="get" action="">
                    <div class="search">
                        <label>Search:</label>
                        <input type="search" name="search" value="<?php echo htmlspecialchars($search); ?>"
                            class="s-box">
                    </div>
                </form>
                <div class="table-data">
                    <table>
                        <?php
                        if ($course_result->num_rows > 0) {
                            ?>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Course</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $course_result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td>
                                            <p>Course: <b><?php echo $row['course_name'] ?></b></p>
                                            <p>Description: <small><b><?php echo $row['description'] ?></b></small></p>
                                        </td>
                                        <td class="btn-group">
                                            <button class="btn editBtn" type="button" data-id="<?php echo $row['course_id'] ?>"
                                                data-course="<?php echo $row['course_name'] ?>"
                                                data-description="<?php echo $row['description'] ?>">Edit</button>

                                            <form method="post" action=""
                                                onsubmit="return confirm('Are you sure to delete this course?');">
                                                <input type="hidden" name="course_id" value="<?php echo $row['course_id']; ?>">
                                                <button type="submit" name="delete" class="btn">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php
                                }
                        } else {
                            echo '<p style="font-size: 20px; padding: 2rem; background-color: #e5e5e5;
                            margin-top: 1rem; border-radius: 4px;">No course available!</p>';
                        } ?>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- courses end -->


    <!-- custom js file link  -->
    <script src="../js/script.js"></script>
    <script>
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const courseId = this.getAttribute('data-id');
                const courseName = this.getAttribute('data-course');
                const description = this.getAttribute('data-description');
                document.getElementById('courseId').value = courseId;
                document.getElementById('course').value = courseName;
                document.getElementById('description').value = description;
                document.getElementById('submitButton').value = 'Edit';
            });
        });

        function _reset() {
            document.getElementById('courseForm').reset();
            document.getElementById('courseId').value = '';
            document.getElementById('submitButton').value = 'Save';
        }
    </script>

</body>

</html>