<?php
require ("../db_connect.php");

// edit entry
if (isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $day = mysqli_real_escape_string($conn, $_POST['day']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);

    if ($id == '') {
        $err = "<div class='msg'>First choose one!!!</div>";
    } else {
        $teacher_query = "SELECT * FROM timetable WHERE timetable_id = '$id'";
        $teacher_result = $conn->query($teacher_query);
        $teacher_data = $teacher_result->fetch_assoc();
        $teacher = $teacher_data['teacher_id'];
        $course = $teacher_data['course_id'];
        $sem = $teacher_data['sem_id'];
        $subject = $teacher_data['subject_id'];

        $check_query = "SELECT * FROM timetable WHERE course_id = '$course' AND sem_id = '$sem' AND day = '$day' AND time = '$time'";
        $course_sem_result = $conn->query($check_query);
        $course_sem_row = $course_sem_result->num_rows;

        $teacher_conflict_query = "SELECT * FROM timetable WHERE teacher_id='$teacher' AND day='$day' AND time='$time' AND timetable_id != '$id'";
        $teacher_conflict_result = $conn->query($teacher_conflict_query);
        $teacher_conflict_count = $teacher_conflict_result->num_rows;

        if ($course_sem_row) {
            $err = "<div class='msg'>A timetable entry for this course, semester, day, and time already exists!!!</div>";
        } elseif ($teacher_conflict_count) {
            $err = "<div class='msg'>The teacher is already scheduled for another subject at this time and day!!!</div>";
        } else {
            $query = "UPDATE timetable SET day = '$day', time = '$time' WHERE timetable_id = '$id'";
            if (mysqli_query($conn, $query)) {
                header('Location: timetable_update_delete.php');
                exit;
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
    }
}

// delete entry
if (isset($_POST['delete'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $query = "DELETE FROM timetable WHERE timetable_id = '$id'";
    if (mysqli_query($conn, $query)) {
        header('Location: timetable_update_delete.php');
        exit;
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
    <title>TimeTable</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- header  -->
    <?php require ("header.php"); ?>

    <!-- edit or delete start -->
    <section>
        <h1 class="heading">
            <span class="back"><a href="timetable.php"><i class="fa-solid fa-arrow-left"></i></a></span>
            Edit or Delete Slot
        </h1>
        <?php echo @$err; ?>
        <div class="timetable-edit-update">
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>Edit Entry</h3>
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

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
                    <select name="time" id="time" class="box" required>
                        <option value="">Select an option</option>
                        <option value="10:00 to 11:00">10:00 to 11:00</option>
                        <option value="11:00 to 12:00">11:00 to 12:00</option>
                        <option value="01:00 to 02:00">01:00 to 02:00</option>
                        <option value="02:00 to 03:00">02:00 to 03:00</option>
                        <option value="03:00 to 04:00">03:00 to 04:00</option>
                        <option value="04:00 to 05:00">04:00 to 05:00</option>
                    </select>

                    <input type="submit" id="submitButton" value="Edit" name="edit" class="btn">
                </form>
            </div>

            <div class="list">
                <h3>Timetable List</h3>

                <div class="table-data">
                    <table>
                        <?php
                        $sql = "SELECT * FROM timetable";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            ?>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Course</th>
                                    <th>Semester</th>
                                    <th>Teacher</th>
                                    <th>Subject</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <?php
                                        $course1 = $row['course_id'];
                                        $course2 = mysqli_query($conn, "SELECT * FROM courses WHERE course_id='$course1'");
                                        $course3 = mysqli_fetch_array($course2);

                                        $sem1 = $row['sem_id'];
                                        $sem2 = mysqli_query($conn, "SELECT * FROM semesters WHERE sem_id='$sem1'");
                                        $sem3 = mysqli_fetch_array($sem2);

                                        $tech1 = $row['teacher_id'];
                                        $tech2 = mysqli_query($conn, "SELECT * FROM teachers WHERE teacher_id='$tech1'");
                                        $tech3 = mysqli_fetch_array($tech2);

                                        $sub1 = $row['subject_id'];
                                        $sub2 = mysqli_query($conn, "SELECT * FROM subjects WHERE subject_id='$sub1'");
                                        $sub3 = mysqli_fetch_array($sub2);

                                        ?>

                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $course3['course_name']; ?></td>
                                        <td><?php echo $sem3['sem_name']; ?></td>
                                        <td><?php echo $tech3['name']; ?></td>
                                        <td><?php echo $sub3['subject_name']; ?></td>
                                        <td><?php echo $row['day']; ?></td>
                                        <td><?php echo $row['time']; ?></td>


                                        <td class="btn-group">
                                            <button class="btn editBtn" type="button"
                                                data-id="<?php echo $row['timetable_id'] ?>"
                                                data-course="<?php echo $row['course_id'] ?>"
                                                data-sem="<?php echo $row['sem_id'] ?>"
                                                data-subject="<?php echo $row['subject_id'] ?>"
                                                data-teacher="<?php echo $row['teacher_id'] ?>"
                                                data-day="<?php echo $row['day'] ?>"
                                                data-time="<?php echo $row['time'] ?>">Edit</button>

                                            <form method="post" action=""
                                                onsubmit="return confirm('Are you sure to delete this record?');">
                                                <input type="hidden" name="id" value="<?php echo $row['timetable_id']; ?>">
                                                <button type="submit" name="delete" class="btn">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            <?php
                        } else {
                            echo '<p style="font-size: 20px; padding: 2rem; background-color: #e5e5e5; margin-top: 1rem; border-radius: 4px;">No entries found!</p>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- edit or delete end -->


    <!-- custom js file link  -->
    <script src="../js/script.js"></script>
    <script>
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const courseId = this.getAttribute('data-course');

                const day = this.getAttribute('data-day');
                const time = this.getAttribute('data-time');
                // document.getElementById('course').value = courseId;

                document.getElementById('day').value = day;
                document.getElementById('time').value = time;
                document.querySelector('input[name="id"]').value = id;
                document.getElementById('submitButton').value = 'Edit';
            });
        });

    </script>
</body>

</html>