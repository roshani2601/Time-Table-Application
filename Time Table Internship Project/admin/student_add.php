<?php
require ("../db_connect.php");

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $sem = mysqli_real_escape_string($conn, $_POST['sem']);
    $bod = mysqli_real_escape_string($conn, $_POST['bod']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $image = '';

    if ($_FILES['image']['error'] == 0) {
        $image = $name . '.jpg';
        $image_tmp = $_FILES['image']['tmp_name'];
    } else {
        $image = 'default.jpg';
    }

    $stmt = $conn->prepare("INSERT INTO students(student_name, student_email, password, contact_no, course_id, sem_id, bod, gender, image) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissss", $name, $email, $password, $contact_no, $course, $sem, $bod, $gender, $image);
    $query_run = $stmt->execute();

    if ($query_run) {
        if (!file_exists('upload/student/')) {
            mkdir('upload/student/', 0777, true);
        }
        move_uploaded_file($image_tmp, "upload/student/" . $image);
        header('Location: students.php');
        exit();
    } else {
        header('Location: students.php?error=Unable to add user');
        exit();
    }

}


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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fetch_semesters'])) {
    $course_id = $_POST['course_id'];
    echo json_encode(fetchSemesters($conn, $course_id));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- header -->
    <?php require ("header.php"); ?>

    <!-- student add start -->
    <div class="addstudent">
        <section class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Add Student<span class="close"><a href="students.php">&times;</a></span></h3>
                <p>Name <span>*</span></p>
                <input type="text" name="name" placeholder="enter your name" required maxlength="50" class="box">

                <p>Email <span>*</span></p>
                <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">

                <p>Password <span>*</span></p>
                <input type="password" name="password" placeholder="enter your password"
                    pattern="(?=.*[!@#$%^&])(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}" required maxlength="20" class="box"
                    id="myInput">
                <h4>Ex: Basic@123</h4>

                <p>Contact No. <span>*</span></p>
                <input type="text" name="contact_no" placeholder="enter your contact no." required maxlength="10"
                    class="box" pattern="[0-9]{10}">

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

                <p>BOD <span>*</span></p>
                <input type="date" name="bod" placeholder="B-O-D" required maxlength="10" class="box">

                <p>Gender <span>*</span></p>
                <select name="gender" class="box" required>
                    <option value="">select an option</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <p>Image <span>*</span></p>
                <input type="file" name="image" class="box">

                <input type="submit" value="Add" name="submit" class="btn">
            </form>
        </section>
    </div>
    <!-- student add end -->

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>
    <script>
        document.getElementById('course').addEventListener('change', function () {
            var course_id = this.value;

            var semSelect = document.getElementById('sem');
            semSelect.innerHTML = '<option value="">Select an option</option>';

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'fetch_semesters=1&course_id=' + course_id
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
        });
    </script>
</body>

</html>