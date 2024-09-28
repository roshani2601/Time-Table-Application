<?php
require ("../db_connect.php");

if (isset($_GET['get_id'])) {
    $get_id = mysqli_real_escape_string($conn, $_GET['get_id']);
    $query = "SELECT * FROM students WHERE student_id = '$get_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
    } else {
        header('Location: students.php');
        exit();
    }
}

if (isset($_POST['edit'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $new_name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $sem = mysqli_real_escape_string($conn, $_POST['sem']);
    $bod = mysqli_real_escape_string($conn, $_POST['bod']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    $old_name = $user['student_name'];
    $old_image = $user['image'];

    $new_image = $old_image;

    if ($old_name != $new_name) {
        $new_image = $new_name . '.jpg';
        rename("upload/student/" . $old_image, "upload/student/" . $new_image);
    }

    if (!empty($_FILES['image']['tmp_name'])) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $new_image = $new_name . '.jpg';
        move_uploaded_file($image_tmp, "upload/student/" . $new_image);
    }

    $query = "UPDATE students SET student_name = '$new_name', student_email = '$email',password='$password', contact_no = '$contact_no', gender = '$gender',bod='$bod',course_id='$course',sem_id='$sem' ,image='$new_image' WHERE student_id = '$student_id'";

    if (mysqli_query($conn, $query)) {
        header('Location: students.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
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


$courses = [];
$sql = "SELECT * FROM courses ORDER BY course_name ASC";
$all_courses = $conn->query($sql);
while ($course = $all_courses->fetch_assoc()) {
    $courses[] = $course;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
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
                <input type="hidden" name="student_id" value="<?php echo $user['student_id']; ?>">

                <h3>Edit Student<span class="close"><a href="students.php">&times;</a></span></h3>
                <p>Name <span>*</span></p>
                <input type="text" name="name" value="<?php echo $user['student_name']; ?>" required maxlength="50"
                    class="box">

                <p>Email <span>*</span></p>
                <input type="email" name="email" value="<?php echo $user['student_email']; ?>" required maxlength="50"
                    class="box">

                <p>Password <span>*</span></p>
                <input type="text" name="password" value="<?php echo $user['password']; ?>"
                    pattern="(?=.*[!@#$%^&])(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}" required maxlength="20" class="box"
                    id="myInput">
                <h4>Ex: Basic@123</h4>

                <p>Contact No. <span>*</span></p>
                <input type="text" name="contact_no" value="<?php echo $user['contact_no']; ?>" required maxlength="10"
                    class="box" pattern="[0-9]{10}">

                <p>Course <span>*</span></p>
                <select name="course" id="course" class="box" required>
                    <option value="">Select an option</option>
                    <?php
                    foreach ($courses as $course) {
                        $selected = ($course['course_id'] == $user['course_id']) ? 'selected' : '';
                        echo "<option value=\"{$course['course_id']}\" $selected>{$course['course_name']}</option>";
                    }
                    ?>
                </select>

                <p>Semester <span>*</span></p>
                <select name="sem" id="sem" class="box" required>
                    <option value="">Select an option</option>
                </select>

                <p>BOD <span>*</span></p>
                <input type="date" name="bod" value="<?php echo $user['bod']; ?>" required maxlength="10" class="box">

                <p>Gender <span>*</span></p>
                <select name="gender" class="box" required>
                    <option value="">select an option</option>
                    <option value="male" <?php echo ($user['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($user['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                </select>

                <p>Image <span>*</span></p>
                <div class="box">
                    <img src="upload/student/<?php echo $user['image']; ?>?v=<?php echo time(); ?>" class="image" alt="">
                    <p>Update image </p>
                    <input type="file" name="image" class="box">
                </div>

                <input type="submit" value="Edit" name="edit" class="btn">
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

                    var userSem = <?php echo json_encode($user['sem_id']); ?>;
                    document.querySelector(`#sem option[value="${userSem}"]`).selected = true;
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });

        document.getElementById('course').dispatchEvent(new Event('change'));
    </script>
</body>

</html>