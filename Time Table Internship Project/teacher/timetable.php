<?php
require ("../db_connect.php");
require ("header.php");

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
    <title>Teacher</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <section class="timetablegen">
        <h1 class="heading">TimeTable</h1>

        <?php
        $teacher_id = $user_data['teacher_id'];

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


    <!-- custom js file link  -->
    <script src="../js/script.js"></script>
</body>

</html>