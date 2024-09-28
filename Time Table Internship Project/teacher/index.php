<?php
require ("../db_connect.php");
require ("header.php");
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
    <style>
        .timetable img {}
    </style>
</head>

<body>
    <section class="timetable">

        <h1 class="heading">quick options</h1>

        <div class="box-container">
            <img src="../images/timetable.svg">


            <div class="box">
                <h3 class="title">Totals</h3>

                <?php
                $teacher_id = $user_data['teacher_id'];
                $query_assignments = "SELECT * FROM teacher_assign WHERE teacher_id='$teacher_id'";
                $result_assignments = mysqli_query($conn, $query_assignments);
                $i = 0;
                while ($assignment = mysqli_fetch_assoc($result_assignments)):
                    $assign = $assignment['assign_id'];

                    $query_subjects = "SELECT * FROM subjects WHERE assign_id='$assign'";
                    $result_subjects = mysqli_query($conn, $query_subjects);

                    while (mysqli_fetch_assoc($result_subjects)):
                        $i++;
                    endwhile;
                endwhile;
                ?>

                <p class="likes">Total Subjects : <span><?php echo $i; ?></span></p>
                <a href="subjects.php" class="inline-btn">view All</a>

                <p class="likes">Timetable </p>
                <a href="timetable.php" class="inline-btn">view</a>


            </div>


    </section>

    <!-- custom js file link  -->
    <script src="../js/script.js"></script>
</body>

</html>