<?php
require ("../db_connect.php");
require ("header.php");
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
    <style>
        .timetable img {
            /* display: block; */
            /* width: 100%; */
        }
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
                $i = 0;
                $course_id = $user_data['course_id'];
                $sem_id = $user_data['sem_id'];

                $query_subjects = "SELECT * FROM subjects WHERE course_id='$course_id' AND sem_id='$sem_id'";
                $result_subjects = mysqli_query($conn, $query_subjects);

                while (mysqli_fetch_assoc($result_subjects)):
                    $i++;
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