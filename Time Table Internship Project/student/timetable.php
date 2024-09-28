<?php
require ("../db_connect.php");
require ("header.php");

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- timetable start -->
    <section class="timetablegen">
        <h1 class="heading">TimeTable</h1>

        <?php

        // $query = "SELECT * FROM students WHERE student_id = '$user_id' LIMIT 1";
        // $result = mysqli_query($conn, $query);
        // $user_data = mysqli_fetch_array($result);

        $course_id = $user_data['course_id'];
        $semester_id = $user_data['sem_id'];

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
    <!-- timetable end -->


    <!-- custom js file link  -->
    <script src="../js/script.js"></script>
</body>

</html>