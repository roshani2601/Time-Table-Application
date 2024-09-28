<?php
require ("../db_connect.php");

//fetch semesters -> selected course
function fetchSemesters($conn, $course_id)
{
    $stmt = $conn->prepare("SELECT * FROM semesters WHERE course_id = ? ORDER BY sem_name ASC");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $semesters = [];
    while ($semester = $result->fetch_assoc()) {
        $semesters[] = $semester;
    }
    return $semesters;
}

//fetch teachers -> selected course
function fetchTeachers($conn, $course_id)
{
    $stmt = $conn->prepare("SELECT DISTINCT teachers.teacher_id, teachers.name 
                            FROM teachers 
                            INNER JOIN teacher_assign ON teachers.teacher_id = teacher_assign.teacher_id 
                            WHERE teacher_assign.course_id = ? ORDER BY teachers.name ASC");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $teachers = [];
    while ($teacher = $result->fetch_assoc()) {
        $teachers[] = $teacher;
    }
    return $teachers;
}

// Handle AJAX requests
if (isset($_POST['course_id'])) {
    header('Content-Type: application/json');
    $course_id = $_POST['course_id'];

    if (isset($_POST['teachers'])) {
        $teachers = fetchTeachers($conn, $course_id);
        echo json_encode($teachers);
        exit();
    } else {
        $semesters = fetchSemesters($conn, $course_id);
        echo json_encode($semesters);
        exit();
    }

}

// submit
if (isset($_POST['submit'])) {
    $subject_name = $_POST['subject_name'];
    $course_id = $_POST['course'];
    $sem_id = $_POST['sem'];
    $teacher_id = $_POST['teacher'];

    $stmt = $conn->prepare("SELECT * FROM subjects WHERE subject_name = '$subject_name' AND course_id = '$course_id' AND sem_id = '$sem_id'");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $err = "<div class='msg'>Subject already exists in this course and semester!!!</div>";
    } else {
        $stmt = $conn->prepare("SELECT assign_id FROM teacher_assign WHERE teacher_id = '$teacher_id' AND course_id = '$course_id'");
        $stmt->execute();
        $result = $stmt->get_result();
        $assign = $result->fetch_assoc();
        $assign_id = $assign['assign_id'];

        $insert_query = "INSERT INTO subjects (subject_name, course_id, sem_id, assign_id) VALUES ('$subject_name','$course_id' ,'$sem_id', '$assign_id')";
        $stmt = mysqli_query($conn, $insert_query);

        if ($stmt) {
            header('Location: subjects.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject</title>
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- header  -->
    <?php require ("header.php"); ?>

    <!-- Add subject form start -->
    <div class="addteacher">
        <?php if (isset($err))
            echo $err; ?>

        <section class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Add Subject<span class="close"><a href="subjects.php">&times;</a></span></h3>

                <p>Course <span>*</span></p>
                <select name="course" id="course" class="box" required>
                    <option value="">Select an option</option>
                    <?php
                    $sql = "SELECT * FROM courses ORDER BY course_name ASC";
                    $all_courses = $conn->query($sql);
                    while ($course = $all_courses->fetch_assoc()):
                        ?>
                        <option value="<?php echo $course["course_id"]; ?>"><?php echo $course["course_name"]; ?></option>
                    <?php endwhile; ?>
                </select>

                <p>Semester <span>*</span></p>
                <select name="sem" id="sem" class="box" required>
                    <option value="">Select an option</option>
                </select>

                <p>Teacher <span>*</span></p>
                <select name="teacher" id="teacher" class="box" required>
                    <option value="">Select an option</option>
                </select>

                <p>Subject Name <span>*</span></p>
                <input type="text" name="subject_name" placeholder="Enter subject name" required maxlength="50"
                    class="box">

                <input type="submit" value="Add" name="submit" class="btn">
            </form>
        </section>
    </div>
    <!-- add form end -->


    <!-- Custom JavaScript file link -->
    <script src="../js/script.js"></script>
    <script>
        document.getElementById('course').addEventListener('change', function () {
            var course_id = this.value;

            // Fetch semesters based on selected course
            var semSelect = document.getElementById('sem');
            semSelect.innerHTML = '<option value="">Select an option</option>';

            var teacherSelect = document.getElementById('teacher');
            teacherSelect.innerHTML = '<option value="">Select an option</option>';

            // Fetch semesters
            fetch('subject_add.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'course_id=' + course_id
            })
                .then(response => response.json())
                .then(data => {
                    data.forEach(function (semester) {
                        semSelect.innerHTML += '<option value="' + semester.sem_id + '">' + semester.sem_name + '</option>';
                    });
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

            // Fetch teachers
            fetch('subject_add.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'course_id=' + course_id + '&teachers=true'
            })
                .then(response => response.json())
                .then(data => {
                    data.forEach(function (teacher) {
                        teacherSelect.innerHTML += '<option value="' + teacher.teacher_id + '">' + teacher.name + '</option>';
                    })
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });

    </script>
</body>

</html>