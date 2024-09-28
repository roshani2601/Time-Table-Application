<?php
require ("../db_connect.php");
session_start();

if (isset($_SESSION['t_id'])) {
   $teacher_id = $_SESSION['t_id'];
} else {
   header('location:../index.php');
   exit;
}

$query = "SELECT * FROM teachers WHERE teacher_id = '$teacher_id' LIMIT 1";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
   <header class="header">

      <section class="flex">

         <a href="index.php" class="logo">TimeTab..</a>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
         </div>

         <div class="profile">
            <img src="../admin/upload/teachers/<?= $user_data['image']; ?>" class="image" alt="">
            <h3 class="name"><?php echo ucwords($user_data['name']); ?></h3>
            <p class="role">Teacher</p>
            <a href="view_profile.php" class="btn">view profile</a>
            <div class="flex-btn">
               <a href="../logout.php" class="option-btn">Logout</a>
            </div>
         </div>
      </section>

   </header>

   <div class="side-bar">

      <div id="close-btn">
         <i class="fas fa-times"></i>
      </div>

      <div class="profile">
         <img src="../admin/upload/teachers/<?= $user_data['image']; ?>" class="image" alt="">
         <h3 class="name"><?php echo ucwords($user_data['name']); ?></h3>
         <p class="role">Teacher</p>
         <a href="view_profile.php" class="btn">view profile</a>
      </div>

      <nav class="navbar">
         <a href="index.php"><i class="fas fa-home"></i><span>Home</span></a>
         <a href="timetable.php"><i class="fa-solid fa-table"></i><span>TimeTable</span></a>
         <a href="subjects.php"><i class="fa-solid fa-book"></i><span>Subjects</span></a>
      </nav>

   </div>

   <!-- custom js file link  -->
   <script src="../js/script.js"></script>
</body>

</html>