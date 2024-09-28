<?php
require ("../db_connect.php");

// submit
if (isset($_POST['submit'])) {
    $course = mysqli_real_escape_string($conn, trim($_POST['course']));
    $sem = mysqli_real_escape_string($conn, trim($_POST['sem']));
    $teacher = mysqli_real_escape_string($conn, trim($_POST['teacher']));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $day = mysqli_real_escape_string($conn, trim($_POST['day']));
    $time = mysqli_real_escape_string($conn, trim($_POST['time']));

    $check_query = "SELECT * FROM timetable WHERE course_id = '$course' AND sem_id = '$sem' AND day = '$day' AND time = '$time'";
    $course_sem_row = $conn->query($check_query)->num_rows;

    $teacher_conflict_query = "SELECT * FROM timetable WHERE teacher_id='$teacher' AND day='$day' AND time='$time'";
    $teacher_conflict_count = $conn->query($teacher_conflict_query)->num_rows;

    if ($course_sem_row) {
        $err = "<div class='msg'>A timetable entry for this course, semester, day, and time already exists.</div>";
    } elseif ($teacher_conflict_count) {
        $err = "<div class='msg'>The teacher is already scheduled for another subject at this time and day.</div>";
    } else {
        // Insert data into timetable table
        $insert_query = "INSERT INTO timetable (time, course_id, sem_id, teacher_id, subject_id, day) VALUES ('$time', '$course', '$sem', '$teacher', '$subject', '$day')";

        if ($conn->query($insert_query)) {
            header('Location: timetable.php');
        } else {
            $err = "<font color='red'>Error: " . $conn->error . "</font>";
        }
    }
}

// Function to fetch semesters based on the selected course
function fetchSemesters($conn, $course_id)
{
    $sql = "SELECT * FROM semesters WHERE course_id = '$course_id' ORDER BY sem_name ASC";
    $result = $conn->query($sql);
    $semesters = [];
    while ($semester = $result->fetch_assoc()) {
        $semesters[] = $semester;
    }
    return $semesters;
}

// Function to fetch teachers based on the selected course
function fetchTeachers($conn, $course_id)
{
    $sql = "SELECT DISTINCT teachers.teacher_id, teachers.name 
            FROM teachers 
            INNER JOIN teacher_assign ON teachers.teacher_id = teacher_assign.teacher_id 
            WHERE teacher_assign.course_id = '$course_id' ORDER BY teachers.name ASC";
    $result = $conn->query($sql);
    $teachers = [];
    while ($teacher = $result->fetch_assoc()) {
        $teachers[] = $teacher;
    }
    return $teachers;
}

// Function to fetch subjects based on the selected course, semester, and teacher
function fetchSubjects($conn, $course_id, $semester_id, $teacher_id)
{
    $sql = "SELECT assign_id FROM teacher_assign WHERE teacher_id = '$teacher_id' AND course_id = '$course_id'";
    $result = $conn->query($sql);
    $assign_ids = [];
    while ($row = $result->fetch_assoc()) {
        $assign_ids[] = $row['assign_id'];
    }

    if (empty($assign_ids)) {
        return [];
    }

    $placeholders = implode(',', $assign_ids);
    $sql = "SELECT * FROM subjects WHERE course_id = '$course_id' AND sem_id = '$semester_id' AND assign_id IN ($placeholders)";
    $result = $conn->query($sql);
    $subjects = [];
    while ($subject = $result->fetch_assoc()) {
        $subjects[] = $subject;
    }
    return $subjects;
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'] ?? null;

    if ($course_id) {
        if (isset($_POST['semester_id']) && isset($_POST['teacher_id'])) {
            $semester_id = $_POST['semester_id'];
            $teacher_id = $_POST['teacher_id'];
            $subjects = fetchSubjects($conn, $course_id, $semester_id, $teacher_id);
            echo json_encode($subjects);
        } elseif (isset($_POST['teachers'])) {
            $teachers = fetchTeachers($conn, $course_id);
            echo json_encode($teachers);
        } else {
            $semesters = fetchSemesters($conn, $course_id);
            echo json_encode($semesters);
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeTable</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- header  -->
    <?php require ("header.php"); ?>

    <!-- timetable add start -->
    <?php echo @$err; ?>
    <section class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Add TimeTable<span class="close"><a href="timetable.php">&times;</a></span></h3>
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

            <p>Subject <span>*</span></p>
            <select name="subject" id="subject" class="box" required>
                <option value="">Select an option</option>
            </select>

            <p>Day <span>*</span></p>
            <select name="day" id="day" class="box" required>
                <option value="">Select an option</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
            </select>

            <p>Time<span>*</span></p>
            <select name="time" class="box" required>
                <option value="">Select an option</option>
                <option value="10:00 to 11:00">10:00 to 11:00</option>
                <option value="11:00 to 12:00">11:00 to 12:00</option>
                <option value="01:00 to 02:00">01:00 to 02:00</option>
                <option value="02:00 to 03:00">02:00 to 03:00</option>
                <option value="03:00 to 04:00">03:00 to 04:00</option>
                <option value="04:00 to 05:00">04:00 to 05:00</option>
            </select>

            <input type="submit" value="Add" name="submit" class="btn">
        </form>
    </section>
    <!-- timetable add end -->


    <script src="../js/script.js"></script>
    <script>
        document.getElementById('course').addEventListener('change', function () {
            var course_id = this.value;
            var semSelect = document.getElementById('sem');
            semSelect.innerHTML = '<option value="">Select an option</option>';
            var teacherSelect = document.getElementById('teacher');
            teacherSelect.innerHTML = '<option value="">Select an option</option>';
            var subjectSelect = document.getElementById('subject');
            subjectSelect.innerHTML = '<option value="">Select an option</option>';
            fetchSemesters(course_id, semSelect);
            fetchTeachers(course_id, teacherSelect);
        });

        document.getElementById('sem').addEventListener('change', function () {
            var course_id = document.getElementById('course').value;
            var semester_id = this.value;
            var teacher_id = document.getElementById('teacher').value;
            var subjectSelect = document.getElementById('subject');
            subjectSelect.innerHTML = '<option value="">Select an option</option>';
            fetchSubjects(course_id, semester_id, teacher_id, subjectSelect);
        });

        document.getElementById('teacher').addEventListener('change', function () {
            var course_id = document.getElementById('course').value;
            var semester_id = document.getElementById('sem').value;
            var teacher_id = this.value;
            var subjectSelect = document.getElementById('subject');
            subjectSelect.innerHTML = '<option value="">Select an option</option>';
            fetchSubjects(course_id, semester_id, teacher_id, subjectSelect);
        });

        function fetchSemesters(course_id, semSelect) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'course_id=' + course_id
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Semesters:', data);
                    data.forEach(function (semester) {
                        semSelect.innerHTML += '<option value="' + semester.sem_id + '">' + semester.sem_name + '</option>';
                    });
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function fetchTeachers(course_id, teacherSelect) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'course_id=' + course_id + '&teachers=true'
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Teachers:', data);
                    data.forEach(function (teacher) {
                        teacherSelect.innerHTML += '<option value="' + teacher.teacher_id + '">' + teacher.name + '</option>';
                    });
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function fetchSubjects(course_id, semester_id, teacher_id, subjectSelect) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'course_id=' + course_id + '&semester_id=' + semester_id + '&teacher_id=' + teacher_id
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Subjects:', data);
                    subjectSelect.innerHTML = '<option value="">Select an option</option>';
                    if (data.length > 0) {
                        data.forEach(function (subject) {
                            subjectSelect.innerHTML += '<option value="' + subject.subject_id + '">' + subject.subject_name + '</option>';
                        });
                    } else {
                        subjectSelect.innerHTML += '<option value="">No subjects available</option>';
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>