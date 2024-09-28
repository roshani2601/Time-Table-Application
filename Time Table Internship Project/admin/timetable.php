<?php
require ("../db_connect.php");

//AJAX to fetch semesters based on the selected course
if (isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);
    $stmt = $conn->prepare("SELECT * FROM semesters WHERE course_id = ? ORDER BY sem_name ASC");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $semesters = [];
    while ($semester = $result->fetch_assoc()) {
        $semesters[] = $semester;
    }
    $stmt->close();
    echo json_encode($semesters);
    exit();
}

function student_time_table($conn, $course_id, $semester_id)
{
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    $times = ['10:00 to 11:00', '11:00 to 12:00', '01:00 to 02:00', '02:00 to 03:00', '03:00 to 04:00', '04:00 to 05:00'];

    $weekTimeTable = [];
    foreach ($days as $day) {
        $dailyTimeTable = [];
        foreach ($times as $time) {
            $stmt = $conn->prepare("SELECT subject_id, teacher_id FROM timetable WHERE course_id = ' $course_id' AND sem_id = '$semester_id' AND day = '$day' AND time = '$time'");
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $subject_id = $row['subject_id'];
                $teacher_id = $row['teacher_id'];

                // Fetch subject name
                $stmt_subject = $conn->prepare("SELECT subject_name FROM subjects WHERE subject_id = '$subject_id'");
                $stmt_subject->execute();
                $result_subject = $stmt_subject->get_result();
                $subject_name = $result_subject->fetch_assoc()['subject_name'];
                $stmt_subject->close();

                // Fetch teacher name
                $stmt_teacher = $conn->prepare("SELECT name FROM teachers WHERE teacher_id = '$teacher_id'");
                $stmt_teacher->execute();
                $result_teacher = $stmt_teacher->get_result();
                $teacher_name = $result_teacher->fetch_assoc()['name'];
                $stmt_teacher->close();

                $dailyTimeTable[] = $subject_name . ' </br>(' . $teacher_name . ')';
            } else {
                $dailyTimeTable[] = '-';
            }
            $stmt->close();
        }
        $weekTimeTable[] = $dailyTimeTable;
    }
    return $weekTimeTable;
}
function teacher_time_table($conn, $teacher_id)
{
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    $times = ['10:00 to 11:00', '11:00 to 12:00', '01:00 to 02:00', '02:00 to 03:00', '03:00 to 04:00', '04:00 to 05:00'];

    $weekTimeTable = [];
    foreach ($days as $day) {
        $dailyTimeTable = [];
        foreach ($times as $time) {
            $stmt = $conn->prepare("SELECT subject_id, course_id, sem_id FROM timetable WHERE teacher_id = '$teacher_id' AND day = '$day' AND time = '$time'");
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $subject_id = $row['subject_id'];
                $course_id = $row['course_id'];
                $sem_id = $row['sem_id'];

                // Fetch subject name
                $stmt_subject = $conn->prepare("SELECT subject_name FROM subjects WHERE subject_id = '$subject_id'");
                $stmt_subject->execute();
                $result_subject = $stmt_subject->get_result();
                $subject_name = $result_subject->fetch_assoc()['subject_name'];
                $stmt_subject->close();

                // Fetch course name
                $stmt_course = $conn->prepare("SELECT course_name FROM courses WHERE course_id = '$course_id'");
                $stmt_course->execute();
                $result_course = $stmt_course->get_result();
                $course_name = $result_course->fetch_assoc()['course_name'];
                $stmt_course->close();

                // Fetch semester name
                $stmt_sem = $conn->prepare("SELECT sem_name FROM semesters WHERE sem_id = '$sem_id'");
                $stmt_sem->execute();
                $result_sem = $stmt_sem->get_result();
                $sem_name = $result_sem->fetch_assoc()['sem_name'];
                $stmt_sem->close();

                $dailyTimeTable[] = $subject_name . ' </br>(' . $course_name . ')' . '</br>(Sem :' . $sem_name . ')';
            } else {
                $dailyTimeTable[] = '-';
            }
        }
        $weekTimeTable[] = $dailyTimeTable;
    }
    return $weekTimeTable;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeTable</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- header  -->
    <?php require ("header.php"); ?>

    <!-- timetable start -->
    <section class="timetable">
        <h1 class="heading">Class TimeTable</h1>

        <div class="box-container">
            <div class="box">
                <h3 class="title">Manage Timetable</h3>
                <div style="padding: 1rem;">
                    <p class="likes">Create</p>
                    <a href="timetable_add.php" class="inline-btn">Add</a>
                    <p class="likes">Update Entry</p>
                    <a href="timetable_update_delete.php" class="inline-btn">Update</a>
                    <p class="likes">Delete Entry</p>
                    <a href="timetable_update_delete.php" class="inline-btn">Delete</a>
                </div>
            </div>

            <!-- student timetable -->
            <div class="box">
                <h3 class="title">Student TimeTable</h3>
                <div class="form-container">

                    <form action="" method="post">
                        <p>Course <span>*</span></p>
                        <select name="course" id="course" class="box" required>
                            <option value="">Select an option</option>
                            <?php
                            $sql = "SELECT * FROM courses ORDER BY course_name ASC";
                            $all_courses = $conn->query($sql);
                            while ($course = $all_courses->fetch_assoc()) {
                                echo "<option value='{$course["course_id"]}'>{$course["course_name"]}</option>";
                            }
                            ?>
                        </select>

                        <p>Semester <span>*</span></p>
                        <select name="sem" id="sem" class="box" required>
                            <option value="">Select an option</option>
                        </select>

                        <input type="submit" id="studentButton" value="Generate" name="generate_student" class="btn">
                    </form>
                </div>
            </div>

            <!-- teacher Timetable -->
            <div class="box">
                <h3 class="title">Teacher TimeTable</h3>
                <div class="form-container">
                    <form action="" method="post">
                        <p>Teacher <span>*</span></p>
                        <select name="teacher" id="teacher" class="box" required>
                            <option value="">Select an option</option>
                            <?php
                            $sql = "SELECT * FROM teachers ORDER BY name ASC";
                            $all_teacher = $conn->query($sql);
                            while ($teacher = $all_teacher->fetch_assoc()) {
                                echo "<option value='{$teacher["teacher_id"]}'>{$teacher["name"]}</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" id="teacherButton" value="Generate" name="generate_teacher" class="btn">
                    </form>
                </div>
            </div>

        </div>
        </div>
    </section>
    <!-- timetable end -->

    <!-- generate timetable start -->


    <?php
    if (isset($_POST['generate_student'])) {
        ?>
        <section class="timetablegen">
            <h1 class="heading">Generated TimeTable</h1>
            <?php
            $course_id = intval($_POST['course']);
            $semester_id = intval($_POST['sem']);

            $course1 = mysqli_query($conn, "SELECT * FROM courses WHERE course_id='$course_id'");
            $course2 = mysqli_fetch_array($course1);

            $sem1 = mysqli_query($conn, "SELECT * FROM semesters WHERE sem_id='$semester_id'");
            $sem2 = mysqli_fetch_array($sem1);

            $weekTimeTable = student_time_table($conn, $course_id, $semester_id);
            ?>

            <h3>Course : <?php echo $course2['course_name']; ?> </h3>
            <h3>Semester : <?php echo $sem2['sem_name']; ?> </h3>

            <div class="table-data">
                <table>
                    <thead>
                        <tr>
                            <th>Day/Time</th>
                            <th>10:00 to 11:00</th>
                            <th>11:00 to 12:00</th>
                            <th>12:00 to 01:00</th>
                            <th>01:00 to 02:00</th>
                            <th>02:00 to 03:00</th>
                            <th>03:00 to 04:00</th>
                            <th>04:00 to 05:00</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                        $times = ['10:00 to 11:00', '11:00 to 12:00', '12:00 to 01:00', '01:00 to 02:00', '02:00 to 03:00', '03:00 to 04:00', '04:00 to 05:00'];
                        $lunch = 'LUNCH';

                        foreach ($weekTimeTable as $i => $dailyTimeTable) {
                            ?>
                            <tr>
                                <td><?php echo $days[$i]; ?></td>
                                <?php
                                foreach ($dailyTimeTable as $j => $subject) {
                                    if ($j == 2) {
                                        ?>
                                        <td><b><?php echo $lunch[$i]; ?></td>
                                        <?php
                                    }
                                    if ($j == 6) {
                                        break;
                                    }
                                    ?>
                                    <td><?php echo ($subject ? $subject : ''); ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php

    } else if (isset($_POST['generate_teacher'])) {
        ?>
            <section class="timetablegen">
                <h1 class="heading">Generated TimeTable</h1>
                <?php
                $teacher_id = intval($_POST['teacher']);

                $teacher1 = mysqli_query($conn, "SELECT * FROM teachers WHERE teacher_id='$teacher_id'");
                $teacher2 = mysqli_fetch_array($teacher1);
                $weekTimeTable = teacher_time_table($conn, $teacher_id);

                ?>
                <h3>Teacher Name : <?php echo ucwords($teacher2['name']); ?> </h3>
                <div class="table-data">
                    <table>
                        <thead>
                            <tr>
                                <th>Day/Time</th>
                                <th>10:00 to 11:00</th>
                                <th>11:00 to 12:00</th>
                                <th>12:00 to 01:00</th>
                                <th>01:00 to 02:00</th>
                                <th>02:00 to 03:00</th>
                                <th>03:00 to 04:00</th>
                                <th>04:00 to 05:00</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                            $times = ['10:00 to 11:00', '11:00 to 12:00', '12:00 to 01:00', '01:00 to 02:00', '02:00 to 03:00', '03:00 to 04:00', '04:00 to 05:00'];
                            $lunch = 'LUNCH';

                            foreach ($weekTimeTable as $i => $dailyTimeTable) {
                                ?>
                                <tr>
                                    <td><?php echo $days[$i]; ?></td>
                                    <?php
                                    foreach ($dailyTimeTable as $j => $subject) {
                                        if ($j == 2) {
                                            ?>
                                            <td><b><?php echo $lunch[$i]; ?></td>
                                        <?php
                                        }
                                        if ($j == 6) {
                                            break;
                                        }
                                        ?>
                                        <td><?php echo ($subject ? $subject : ''); ?></td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php
    }
    // else {
    //     echo "<div class='msg'>Generate a timetable for a student or teacher!</div>";
    // }
    ?>
    </section>
    <!-- generate timetable end -->

    <!-- custom js file link -->
    <script src="../js/script.js"></script>
    <script>
        // Fetch and populate semesters based on selected course
        document.getElementById('course').addEventListener('change', function () {
            var course_id = this.value;

            // Fetch semesters based on selected course
            var semSelect = document.getElementById('sem');
            semSelect.innerHTML = '';
            semSelect.innerHTML = '<option value="">Select an option</option>';

            fetch('', {
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
        });

    </script>
</body>

</html>