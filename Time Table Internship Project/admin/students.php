<?php
require ("../db_connect.php");
require ("header.php");

// delete 
if (isset($_POST['delete'])) {
   $s_id = mysqli_real_escape_string($conn, $_POST['student_id']);

   $query = "SELECT student_name FROM students WHERE student_id = $s_id";
   $result = mysqli_query($conn, $query);

   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);

      $imageFile = $row['student_name'] . ".jpg";

      $filePath = "upload/student/" . $imageFile;

      if (file_exists($filePath)) {
         if (unlink($filePath)) {
            $query = "DELETE FROM students WHERE student_id = $s_id";
            if (mysqli_query($conn, $query)) {
               header('Location: students.php');
               exit();
            } else {
               echo "Error deleting record: " . mysqli_error($conn);
            }
         } else {
            echo "Error deleting file: Unable to delete the image file.";
         }
      } else {
         echo "File does not exist: $filePath";
      }
   } else {
      echo "No record found with ID: $s_id";
   }
}

// Handle search
$search = "";
$student_result = [];
if (isset($_GET['search'])) {
   $search = $conn->real_escape_string($_GET['search']);
   $sql = "SELECT * FROM students WHERE student_name LIKE '%$search%' ORDER BY student_name ASC";
   ;
} else {
   $sql = "SELECT * FROM students ORDER BY student_name ASC";
}

$student_result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Student</title>
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="../css/style.css">
</head>

<body>
   <!-- student start -->
   <section class="students">
      <h1 class="heading">Students</h1>
      <div class="head">
         <form action="" method="get" class="search-tutor">
            <input type="text" name="search" placeholder="Search Student..." maxlength="100"
               value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="fas fa-search"></button>
         </form>
         <a href="student_add.php"><button class="btn"><i class="fa fa-plus"></i> Add </button></a>
      </div>


      <div class="box-container">
         <?php
         if ($student_result->num_rows > 0) {
            while ($student = $student_result->fetch_assoc()):

               ?>
               <div class="box">
                  <div class="tutor">
                     <img src="upload/student/<?= $student['image']; ?>?v=<?php echo time(); ?>" alt="">
                     <div>
                        <h3><?php echo $student['student_name']; ?></h3>
                     </div>
                  </div>

                  <?php
                  $course1 = $student['course_id'];
                  $course2 = mysqli_query($conn, "SELECT * FROM courses WHERE course_id='$course1'");
                  $course3 = mysqli_fetch_array($course2);

                  $sem1 = $student['sem_id'];
                  $sem2 = mysqli_query($conn, "SELECT * FROM semesters WHERE sem_id='$sem1'");
                  $sem3 = mysqli_fetch_array($sem2);
                  ?>

                  <p>E-mail : <span><?php echo $student['student_email'] ?></span></p>
                  <p>Course: <span><?php echo $course3['course_name'] ?></span></p>
                  <p>Semester: <span><?php echo $sem3['sem_name'] ?></span></p>

                  <div class="btn-grp">
                     <a href="student_edit.php?get_id=<?php echo $student['student_id']; ?>" class="inline-btn">Update</a>
                     <form action="" method="POST" onsubmit="return confirm('Are you sure to delete this student?');">
                        <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                        <input type="submit" name="delete" value="Delete" class="inline-btn">
                     </form>
                  </div>
               </div>
            <?php endwhile;
         } else {
            echo '<p style="font-size: 20px; padding: 2rem; background-color: #e5e5e5;
                           margin-top: 1rem; border-radius: 4px;">No Student added yet!</p>';
         } ?>

      </div>

   </section>
   <!-- student end -->

   <!-- Custom JavaScript file link -->
   <script src="../js/script.js"></script>

</body>

</html>